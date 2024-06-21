<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\User;
use Exception;

class DataController extends Controller
{
    public function store(Request $request)
    {
        try {
            $name = $request->input('name');

            $user = User::where('name', $name)->first();

            if (!$user) {
                return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
            }

            $data = new Data();
            $data->name = $user->name;
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


    public function getLastFiveDaysScores(Request $request)
    {
        try {
            $name = $request->input('name');

            $user = User::where('name', $name)->first();

            if (!$user) {
                return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
            }

            $data = Data::where('name', $name)
                        ->orderBy('date', 'desc')
                        ->take(5)
                        ->get(['date', 'dayScore']);

            $response = ['status' => 200, 'data' => $data];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
            return response()->json($response);
        }
    }





    public function getDataByDate(Request $request)
    {
        try {
            $name = $request->input('name');

            $user = User::where('name', $name)->first();

            if (!$user) {
                return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
            }

            $date = $request->date;

            $data = Data::whereDate('date', $date)
                        ->where('name', $name)
                        ->get();

            $response = ['status' => 200, 'data' => $data];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
            return response()->json($response);
        }
    }
}
