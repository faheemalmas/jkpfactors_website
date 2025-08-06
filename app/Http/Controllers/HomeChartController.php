<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeChartController extends Controller
{
    public function showChart()
    {
        $filePath = public_path('client/csv/Market.csv');
        if (File::exists($filePath)) {
            $fileData = File::get($filePath);
            $chartData = $this->parseCSV($fileData);
        } else {
            return abort(404, 'CSV file not found.');
        }

        return view('client.home', ['chartData' => $chartData]);
    }

    private function parseCSV($fileContent)
    {
        $lines = explode("\n", trim($fileContent));
        $dates = [];
        $column1 = [];
        $column3 = [];
        $column4 = [];

        foreach ($lines as $index => $line) {
            if ($index === 0) continue; // Skip the header
            $columns = str_getcsv($line);
            $dates[] = $columns[0];
            $column1[] = $columns[1]; // Second column (0-indexed)
            $column3[] = $columns[3]; // Fourth column (0-indexed)
            $column4[] = $columns[4]; // Fifth column (0-indexed)
        }

        return [
            'dates' => $dates,
            'column1' => $column1,
            'column3' => $column3,
            'column4' => $column4
        ];
    }
}

// @json($chartData['dates'])
        // @json($chartData['column1'])
        // @json($chartData['column3'])
        // @json($chartData['column4'])