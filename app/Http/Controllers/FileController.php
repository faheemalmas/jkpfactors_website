<?php

namespace App\Http\Controllers;

use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use PhpParser\Node\Expr\Cast\Double;

class FileController extends Controller
{
    public function downloadFile(Request $request)
    {
        $name = "[$request->country]_[$request->themes]_[$request->frequency]_[$request->weight].zip";
        $headers = [
            'Content-Type'        => 'Content-Type: application/zip',
            'Content-Disposition' => 'attachment; filename="' . $name . '"',
        ];
        return Response::make(Storage::disk('s3')->get('public/' . $name), 200, $headers);
    }

    public function getDataForGraph(Request $request)
    {
        $graphDataFileStream = Storage::disk('s3')->readStream('analysis/[' . $request->region . ']_[' . $request->theme . ']_[' . $request->frequency . ']_[' . $request->weight . '].csv');
        $graphDataFile = "";
        $csvReader = Reader::createFromStream($graphDataFileStream);
        $csvReader->setHeaderOffset(0);
        $graphDataFile = $csvReader->getRecords();
        $graphDataFile = iterator_to_array($graphDataFile);
        fclose($graphDataFileStream);
        $graphData = $this->parseGraphCSV($graphDataFile);


        // $marketDataFileStream = Storage::disk('s3')->readStream('market/['.$request->region.']_[mkt]_['.$request->frequency.']_['.$request->weight.'].csv');
        $marketDataFileStream =
            Storage::disk('s3')->readStream('market/[' . $request->region . ']_[mkt]_[' . $request->frequency . ']_[vw].csv');
        $marketDataFile = "";
        $csvReader = Reader::createFromStream($marketDataFileStream);
        $csvReader->setHeaderOffset(0);
        $marketDataFile = $csvReader->getRecords();
        $marketDataFile = iterator_to_array($marketDataFile);
        fclose($marketDataFileStream);
        $marketData = $this->parseGraphCSV($marketDataFile);


        $statsDataFile = Storage::disk('s3')->get('stats/[' . $request->region . ']_[' . $request->theme . ']_[' . $request->frequency . ']_[' . $request->weight . ']_stats.csv');
        // $label = '['.$request->region.']_['.$request->theme.']_['.$request->frequency.']_['.$request->weight.']';
        $label = '[' . $request->region . ']_[' . $request->theme . ']_[' . $request->weight . ']';
        // $label = "Factors                              ";
        $market_label = "Market                          ";
        $statsData = $this->parseStatsCSV($statsDataFile);

        return response()->json(["graphData" => ['label' => $label, 'data' => $graphData], "statsData" => $statsData, "marketData" => ["label" => $market_label, "data" => $marketData]]);
    }

    public function getAlphaGraphData(Request $request)
    {
        $graphDataFileStream =
            Storage::disk('s3')->readStream('analysis_alpha/[' . $request->region . ']_[' . $request->theme . ']_[' .
            $request->frequency . ']_[' . $request->weight . '].csv');
        $graphDataFile = "";
        $csvReader = Reader::createFromStream($graphDataFileStream);
        $csvReader->setHeaderOffset(0);
        $graphDataFile = $csvReader->getRecords();
        $graphDataFile = iterator_to_array($graphDataFile);
        fclose($graphDataFileStream);
        $graphData = $this->parseGraphCSV($graphDataFile);


        // $marketDataFileStream =
        Storage::disk('s3')->readStream('market_alpha/[' . $request->region . ']_[mkt]_[' . $request->frequency . ']_['
        . $request->weight . '].csv');
        $marketDataFileStream =
            Storage::disk('s3')->readStream('market_alpha/[' . $request->region . ']_[mkt]_[' . $request->frequency .
            ']_[vw].csv');
        $marketDataFile = "";
        $csvReader = Reader::createFromStream($marketDataFileStream);
        $csvReader->setHeaderOffset(0);
        $marketDataFile = $csvReader->getRecords();
        $marketDataFile = iterator_to_array($marketDataFile);
        fclose($marketDataFileStream);
        $marketData = $this->parseGraphCSV($marketDataFile);


        $statsDataFile =
            Storage::disk('s3')->get('stats/[' . $request->region . ']_[' . $request->theme . ']_[' . $request->frequency . ']_[' . $request->weight . ']_stats.csv');
        // $label = '['.$request->region.']_['.$request->theme.']_['.$request->frequency.']_['.$request->weight.']';
        $label = '[' . $request->region . ']_[' . $request->theme . ']_[' . $request->weight . ']';
        // $label = "Factors ";
        $market_label = "Market ";
        $statsData = $this->parseStatsCSV($statsDataFile);

        return response()->json([
            "graphData" => ['label' => $label, 'data' => $graphData],
            "statsData" => $statsData,
            "marketData" => ["label" => $market_label, "data" => $marketData]
        ]);
    }

    public function factorsDataToWatch(Request $request)
    {
        $factorsDataFile = Storage::disk('s3')->get('factors_to_watch/[' . $request->location . ']_[' . $request->frequency . ']_[' . $request->weight . ']_[' . $request->period . '].csv');
        $factorsData = $this->parseStatsCSV($factorsDataFile);
        return response()->json(["factorsData" => $factorsData]);
    }
    private function extractLabelFromFilename($filename)
    {

        $label = basename($filename, '.csv');
        $label = str_replace('_', ' ', $label);
        return ucwords($label);
    }

    private function parseGraphCSV($fileContent)
    {
        $dates = [];
        foreach ($fileContent as $value) {
            $dates[] = $value["date"];
        }
        $values = [];
        $val = 0;
        foreach ($fileContent as  $value) {
            // $val += $value["ret"];
            $values[] = (float)$value["ret"];
        }

        return ['dates' => $dates, 'values' => $values];
    }

    private function parseStatsCSV($fileContent)
    {
        // dd($fileContent);
        $rows = explode("\n", trim($fileContent));
        $row_column = [];
        foreach ($rows as  $value) {
            $row_column[] = explode(',', $value);
        }
        return $row_column;
    }
}
