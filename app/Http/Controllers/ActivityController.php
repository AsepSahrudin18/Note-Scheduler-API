<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Schedule;

class ActivityController extends Controller
{
    public function getActivitiesByScheduleId($id)
    {
        $activities = Activity::where('schedule_id', $id)->get();

        $response = [
            'code' => 200,
            'data' => $activities,
        ];

        return response()->json($response);
    }

    public function getActivityById($id)
    {
        $activity = Activity::find($id);
    
        if (!$activity) {
            $response = [
                'code' => 404,
                'message' => 'Data dengan ID '.$id.' tersebut tidak ditemukan.',
            ];
            return response()->json($response, 404);
        }
    
        $response = [
            'code' => 200,
            'data' => $activity,
        ];
    
        return response()->json($response);
    }
    
}
