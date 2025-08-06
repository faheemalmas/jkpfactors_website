<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ChartController extends Controller
{
    public function showChart()
    {
        
        $files =
            ['Market.csv', ];
        $allData = [];

        foreach ($files as $file) {
            $filePath = public_path("client/csv/{$file}");
            if (File::exists($filePath)) {
                $fileData = File::get($filePath);
                $csvData = $this->parseCSV($fileData);
                // $allData[] = $csvData;
                $label = $this->extractLabelFromFilename($file);
                $allData[] = [
                    'label' => $label,
                    'data' => $csvData
                ];
            }
        }

        $myFiles =
            ['[usa]_[sale_bev]_[monthly]_[vw_cap]_stats.csv'];
        $myAllData = [];

        foreach ($myFiles as $Myfile) {
            $MyfilePath = public_path("client/csv/{$Myfile}");
            // $MyfilePath = Storage::disk('s3')->url('[usa]_[sale_bev]_[monthly]_[vw_cap]_stats.csv');

            $file = fopen($MyfilePath, 'r');
            if (!$file) return null;
            $allRows = [];
            //
            while (($data = fgetcsv($file, $limit = 100000, ',')) !== FALSE) {
                $myAllData[] = $data;
            }
            fclose($file);
        }

        return view('client.analysis');
    }

    public function showCharts()
    {
        $files = [
            'Market.csv',
            '[usa]_[ret_60_12]_[monthly]_[vw_cap].csv',
            '[usa]_[rvol_21d]_[monthly]_[vw_cap].csv',
            '[usa]_[sale_bev]_[monthly]_[vw_cap].csv'
        ];
        $allData = [];

        foreach ($files as $file) {
            $filePath = public_path("client/csv/{$file}");
            if (File::exists($filePath)) {
                $fileData = File::get($filePath);
                $csvData = $this->parseCSV($fileData);
                $label = $this->extractLabelFromFilename($file);
                $allData[] = [
                    'label' => $label,
                    'data' => $csvData
                ];
            }
        }

        return view('client.performanceoffactors', ['allData' => $allData]);
    }


    private function extractLabelFromFilename($filename)
    {

        $label = basename($filename, '.csv');
        $label = str_replace('_', ' ', $label);
        return ucwords($label);
    }

    private function parseCSV($fileContent)
    {
        $lines = explode("\n", trim($fileContent)); // Changed to double quotes

        $dates = [];
        $values = [];
        $cumulativeSum = 0;

        foreach ($lines as $line) {
            $columns = str_getcsv($line);

            if (count($columns) >= 9 && !empty($columns[7]) && !empty($columns[8])) {
                $dates[] = $columns[7];
                $cumulativeSum += (float)$columns[8];

                $values[] = $cumulativeSum;
            }
        }

        return ['dates' => $dates, 'values' => $values];
    }
}
