<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL');
        $this->apiKey = env('API_KEY');
    }

    // public function showStateMachineForm()
    // {
    //     return view('client.state_machine_form');
    // }

    // public function executeStateMachine(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'submission_timestamp' => 'required|string',
    //         'user_ml_output_csv_s3_uri' => 'required|string',
    //         'user_ml_script_s3_uri' => 'required|string',
    //         'model_name' => 'required|string',
    //         'user_name' => 'required|string',
    //         'email' => 'required|string|email',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect('/state/execute')
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $response = Http::withHeaders([
    //         'x-api-key' => $this->apiKey,
    //     ])->post("{$this->baseUrl}/state/execute", $validator->validated());

    //     if ($response->failed()) {
    //         return redirect('/state/execute')->with('error', 'API request failed');
    //     }

    //     return redirect('/state/execute')->with('success', 'State machine executed successfully');
    // }

    // public function showFileUploadLinkForm()
    // {
    //     return view('client.file_upload_link_form');
    // }

    // public function getFileUploadLink(Request $request)
    // {
    //     $response = Http::withHeaders([
    //         'x-api-key' => $this->apiKey,
    //     ])->get("{$this->baseUrl}/crud/get_file_upload_link", $request->all());

    //     if ($response->failed()) {
    //         return redirect('/crud/get_file_upload_link')->with('error', 'API request failed');
    //     }

    //     return redirect('/crud/get_file_upload_link')->with('success', 'File upload link retrieved successfully');
    // }

    public function getBenchmarks()
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("{$this->baseUrl}/crud/benchmarks");

        if ($response->failed()) {
            return view('client.benchmarks', ['error' => 'API request failed']);
        }

        return view('client.benchmarks', ['benchmarks' => $response->json()['benchmarks']]);
        // return view('client.benchmarks');
    }

    // public function addSubmission(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'submission_timestamp' => 'required|string',
    //         'user_ml_output_csv_s3_uri' => 'required|string',
    //         'user_ml_script_s3_uri' => 'required|string',
    //         'model_name' => 'required|string',
    //         'user_name' => 'required|string',
    //         'email' => 'required|string|email',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect('/crud/submission')
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $response = Http::withHeaders([
    //         'x-api-key' => $this->apiKey,
    //     ])->post("{$this->baseUrl}/crud/submission", $validator->validated());

    //     if ($response->failed()) {
    //         return redirect('/crud/submission')->with('error', 'API request failed');
    //     }

    //     return redirect('/crud/submission')->with('success', 'Submission added successfully');
    // }
}
