<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use Exception;

class DataController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = new Data();
            $data->date = $request->date;
            $data->emotion = $request->emotion;
            $data->experienced = $request->experienced;
            $data->dayScore = $request->dayScore;
            $data->notes = $request->notes;
            $data->save();

            $response = ['status' => 200, 'message' => 'Data succesvol opgeslagen!'];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
            return response()->json($response);
        }
    }
}
