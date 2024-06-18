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

    public function getLastFiveDaysScores(Request $request)
    {
        try {
            $token = $request->header('Authorization');

            $token = str_replace('Bearer ', '', $token);

            $user = User::where('remember_token', $token)->first();

            if (!$user) {
                return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
            }

            $data = Data::where('user_id', $user->id)
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
            $token = $request->header('Authorization');

            $token = str_replace('Bearer ', '', $token);

            $user = User::where('remember_token', $token)->first();

            if (!$user) {
                return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
            }

            $date = $request->date;

            $data = Data::whereDate('date', $date)
                        ->where('user_id', $user->id)
                        ->get();

            $response = ['status' => 200, 'data' => $data];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
            return response()->json($response);
        }
    }

}
