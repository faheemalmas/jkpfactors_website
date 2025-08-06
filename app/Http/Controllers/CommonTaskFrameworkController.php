<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonTaskFramework;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommonTaskFrameworkController extends Controller
{

    public function index()
    {
        return view('client.commontaskframework');
    }

    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = "https://y6az89uhsb.execute-api.us-east-1.amazonaws.com/prod";
        $this->apiKey = "VwbppkDAna7079FP4OgNHDsuGafYZhu4G34Adxuj";
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'model_name' => 'required|string',
            'fileToUploadcsv' => 'required|file|mimes:csv,txt',
            'fileToUploadpdf' => 'required|file',
        ]);

        try {
            Log::info('File upload process started.');

            // Define storage paths
            $csvFileUrl = null;
            $pyFileUrl = null;
            $pdfFileUrl = null;

            // Handle CSV file
            if ($request->hasFile('fileToUploadcsv')) {
                $originalCsvFilename = $request->file('fileToUploadcsv')->getClientOriginalName();
                $uniqueCsvFilename = pathinfo($originalCsvFilename, PATHINFO_FILENAME) . '_' . time() . '.' .
                    $request->file('fileToUploadcsv')->getClientOriginalExtension();

                $csvFilePath = $request->file('fileToUploadcsv')->storeAs('uploads/csv', $uniqueCsvFilename, 's3');

                if (!$csvFilePath || empty($csvFilePath)) {
                    throw new \Exception("CSV file upload failed.");
                }

                Log::info("CSV uploaded successfully: $csvFilePath");

                // Debug: Check if file exists in S3
                if (!Storage::disk('s3')->exists($csvFilePath)) {
                    throw new \Exception("CSV file not found in S3.");
                }

                $csvFileUrl = Storage::disk('s3')->url($csvFilePath);
            }

            // Handle Python/R file
            if ($request->hasFile('fileToUploadpy')) {
                $originalPyFilename = $request->file('fileToUploadpy')->getClientOriginalName();
                $uniquePyFilename = pathinfo($originalPyFilename, PATHINFO_FILENAME) . '_' . time() . '.' .
                    $request->file('fileToUploadpy')->getClientOriginalExtension();

                $pyFilePath = $request->file('fileToUploadpy')->storeAs('uploads/python', $uniquePyFilename, 's3');

                if (!$pyFilePath || empty($pyFilePath)) {
                    throw new \Exception("Python/R file upload failed.");
                }

                Log::info("Python/R uploaded successfully: $pyFilePath");

                if (!Storage::disk('s3')->exists($pyFilePath)) {
                    throw new \Exception("Python/R file not found in S3.");
                }

                $pyFileUrl = Storage::disk('s3')->url($pyFilePath);
            }

            // Handle PDF file
            if ($request->hasFile('fileToUploadpdf')) {
                $originalPdfFilename = $request->file('fileToUploadpdf')->getClientOriginalName();
                $uniquePdfFilename = pathinfo($originalPdfFilename, PATHINFO_FILENAME) . '_' . time() . '.' .
                    $request->file('fileToUploadpdf')->getClientOriginalExtension();

                $pdfFilePath = $request->file('fileToUploadpdf')->storeAs('uploads/pdf', $uniquePdfFilename, 's3');

                if (!$pdfFilePath || empty($pdfFilePath)) {
                    throw new \Exception("PDF file upload failed.");
                }

                Log::info("PDF uploaded successfully: $pdfFilePath");

                if (!Storage::disk('s3')->exists($pdfFilePath)) {
                    throw new \Exception("PDF file not found in S3.");
                }

                $pdfFileUrl = Storage::disk('s3')->url($pdfFilePath);
            }

            // Debugging: Output stored paths


            // Store file details in the database
            FileUpload::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'model_name' => $validatedData['model_name'],
                'csv_file_path' => $csvFileUrl,
                'python_file_path' => $pyFileUrl,
                'pdf_file_path' => $pdfFileUrl,
                'original_csv_filename' => $originalCsvFilename,
                'original_py_filename' => $originalPyFilename,
                'original_pdf_filename' => $originalPdfFilename,
            ]);

            Log::info('File upload process completed successfully.');
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Files uploaded to S3 and URLs saved in the database successfully.');
    }

    public function submitAndExecute($id)
    {

        $fileUpload = FileUpload::findOrFail($id);
        $timestamp = (string)time();

        try {
            // Step 1: Download the Python and CSV files using the URLs from the database
            $pyTempPath = storage_path('app/temp/' . $fileUpload->id . '_' . time() . '.py');
            $csvTempPath = storage_path('app/temp/' . $fileUpload->id . '_' . time() . '.csv');

            Storage::disk('local')->put('temp/' . basename($pyTempPath), file_get_contents($fileUpload->python_file_path));
            Storage::disk('local')->put('temp/' . basename($csvTempPath), file_get_contents($fileUpload->csv_file_path));

            // Read the downloaded files' content
            $pyFileContent = file_get_contents($pyTempPath);
            $csvFileContent = file_get_contents($csvTempPath);

            // Step 2: Proceed with the existing logic, using the downloaded files' content
            $pyFileName = 'script_' . $fileUpload->id . '_' . time() . '.py';
            $getPyUrlResponse = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/crud/get_file_upload_link", [
                'file_name' => $pyFileName,
                'email' => $fileUpload->email,
                'submission_timestamp' => $timestamp,
            ]);

            if ($getPyUrlResponse->failed()) {
                Log::error('Failed to get presigned URL for Python script.', ['response' => $getPyUrlResponse->json()]);
                return redirect()->back()->with('error', 'Failed to get presigned URL for Python script.');
            }

            $pyPresignedUrl = $getPyUrlResponse->json()['presigned_url'];
            $pyS3Path = $getPyUrlResponse->json()['image_s3_path'];

            $pyUploadResponse = Http::withHeaders([
                'Content-Type' => 'application/octet-stream',
            ])->withBody($pyFileContent, 'application/octet-stream')->put($pyPresignedUrl);

            if ($pyUploadResponse->failed()) {
                return redirect()->back()->with('error', 'Failed to upload Python script to S3.');
            }

            $csvFileName = 'output_' . $fileUpload->id . '_' . time() . '.csv';
            $getCsvUrlResponse = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/crud/get_file_upload_link", [
                'file_name' => $csvFileName,
                'email' => $fileUpload->email,
                'submission_timestamp' => $timestamp,
            ]);

            if ($getCsvUrlResponse->failed()) {
                Log::error('Failed to get presigned URL for CSV output.', ['response' => $getCsvUrlResponse->json()]);
                return redirect()->back()->with('error', 'Failed to get presigned URL for CSV output.');
            }

            $csvPresignedUrl = $getCsvUrlResponse->json()['presigned_url'];
            $csvS3Path = $getCsvUrlResponse->json()['image_s3_path'];

            $csvUploadResponse = Http::withHeaders([
                'Content-Type' => 'application/octet-stream',
            ])->withBody($csvFileContent, 'application/octet-stream')->put($csvPresignedUrl);

            if ($csvUploadResponse->failed()) {
                return redirect()->back()->with('error', 'Failed to upload CSV output to S3.');
            }

            $addSubmissionResponse = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->post("{$this->baseUrl}/crud/submission", [
                'submission_timestamp' => $timestamp,
                'user_ml_output_csv_s3_uri' => $csvS3Path,
                'user_ml_script_s3_uri' => $pyS3Path,
                'model_name' => $fileUpload->model_name,
                'user_name' => $fileUpload->username,
                'email' => $fileUpload->email,
            ]);

            if ($addSubmissionResponse->failed()) {
                Log::error('Failed to add submission.', ['response' => $addSubmissionResponse->json()]);
                return redirect()->back()->with('error', 'Failed to add submission.');
            }

            $fileUpload->increment('send_status');

            $apiResponseMessage = $addSubmissionResponse->json()['message'] ?? 'Submission successful';

            // Step 3: Delete the temporary files after use
            unlink($pyTempPath);
            unlink($csvTempPath);

            return redirect()->back()->with('success', $apiResponseMessage);
        } catch (\Exception $e) {
            Log::error('An error occurred during submission', ['exception' => $e]);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function downloadCsv($id)
    {
        $fileUpload = FileUpload::findOrFail($id);

        if (empty($fileUpload->csv_content)) {
            return redirect()->back()->with('error', 'CSV content is empty.');
        }

        $filename = $fileUpload->original_csv_filename ?: $fileUpload->model_name . '.csv';

        return response($fileUpload->csv_content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function downloadPy($id)
    {
        $fileUpload = FileUpload::findOrFail($id);

        if (empty($fileUpload->py_content)) {
            return redirect()->back()->with('error', 'Python script content is empty.');
        }

        $filename = $fileUpload->original_py_filename ?: $fileUpload->model_name . '.py';

        return response($fileUpload->py_content)
            ->header('Content-Type', 'text/x-python')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
