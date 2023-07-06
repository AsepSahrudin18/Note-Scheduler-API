<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Activity;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $schedule = new Schedule();
    //     $schedule->judul = $request->input('judul');
    //     $schedule->start_at = $request->input('start_at');
    //     $schedule->end_at = $request->input('end_at');
    //     $schedule->save();

    //     $activity = new Activity();
    //     $activity->schedule_id = $schedule->id;
    //     $activity->activity = $request->input('activity');
    //     $activity->save();

    //     $response = [
    //         'code' => 201,
    //         'data' => [
    //             'id' => $schedule->id,
    //             'judul' => $schedule->judul,
    //             'start_at' => $schedule->start_at,
    //             'end_at' => $schedule->end_at,
    //             'activities' => [
    //                 [
    //                     'id' => $activity->id,
    //                     'schedule_id' => $activity->schedule_id,
    //                     'activity' => $activity->activity,
    //                 ],
    //             ],
    //         ],
    //     ];

    //     return response()->json($response);
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         $schedule = new Schedule();
    //         $schedule->judul = $request->input('judul');
    //         $schedule->start_at = $request->input('start_at');
    //         $schedule->end_at = $request->input('end_at');
    //         $schedule->save();

    //         $activity = new Activity();
    //         $activity->schedule_id = $schedule->id;
    //         $activity->activity = $request->input('activity');
    //         $activity->save();

    //         $response = [
    //             'success' => true,
    //             'data' => [
    //                 'id' => $schedule->id,
    //                 'judul' => $schedule->judul,
    //                 'start_at' => $schedule->start_at,
    //                 'end_at' => $schedule->end_at,
    //                 'activities' => [
    //                     [
    //                         'id' => $activity->id,
    //                         'schedule_id' => $activity->schedule_id,
    //                         'activity' => $activity->activity,
    //                     ],
    //                 ],
    //             ],
    //         ];

    //         return response()->json($response, 201);

    //     } catch (\Exception $exception) {
    //         $response = [
    //             'code' => 400,
    //             'success' => false,
    //             'message' => 'Gagal menyimpan data.',
    //         ];

    //         return response()->json($response, 404);
    //     }

        
    // }

    public function store(Request $request)
    {
        $startAt = $request->input('start_at');
        $endAt = $request->input('end_at');

        if (Carbon::parse($startAt)->greaterThanOrEqualTo(Carbon::parse($endAt))) {
            $response = [
                'code' => 400,
                'success' => false,
                'message' => 'Tanggal mulai tidak boleh lebih kecil daripada tanggal berakhir.',
            ];
            return response()->json($response, 400);
        }

        try {
            $schedule = new Schedule();
            $schedule->judul = $request->input('judul');
            $schedule->start_at = $startAt;
            $schedule->end_at = $endAt;
            $schedule->save();

            $activity = new Activity();
            $activity->schedule_id = $schedule->id;
            $activity->activity = $request->input('activity');
            $activity->save();

            $response = [
                'success' => true,
                'data' => [
                    'id' => $schedule->id,
                    'judul' => $schedule->judul,
                    'start_at' => $schedule->start_at,
                    'end_at' => $schedule->end_at,
                    'activities' => [
                        [
                            'id' => $activity->id,
                            'schedule_id' => $activity->schedule_id,
                            'activity' => $activity->activity,
                        ],
                    ],
                ],
            ];

            return response()->json($response, 201);
        } catch (\Exception $exception) {
            $response = [
                'code' => 400,
                'success' => false,
                'message' => 'Gagal menyimpan data.',
            ];

            return response()->json($response, 400);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $activity = Activity::findOrFail($id);

        $response = [
            'code' => 200,
            'data' => $activity,
        ];

        return response()->json($response);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->only(['judul', 'start_at', 'end_at']));

        $activityData = $request->input('activities')[0];
        $activity = Activity::findOrFail($activityData['id']);
        $activity->update(['activity' => $activityData['activity']]);

        $response = [
            'data' => [
                'id' => $schedule->id,
                'judul' => $schedule->judul,
                'start_at' => $schedule->start_at,
                'end_at' => $schedule->end_at,
                'activities' => [
                    [
                        'id' => $activity->id,
                        'schedule_id' => $activity->schedule_id,
                        'activity' => $activity->activity,
                    ],
                ],
            ],
        ];

        return response()->json($response, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
     public function deleteSchedule($id)
     {
         $schedule = Schedule::findOrFail($id);
         $schedule->activities()->delete(); // Menghapus seluruh aktivitas terkait
 
         $schedule->delete(); // Menghapus jadwal
 
         $response = [
             'code' => 200,
             'message' => 'Schedule and related activities deleted successfully.',
         ];
 
         return response()->json($response);
     }

    public function updateActivity(Request $request, $scheduleId, $activityId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $activity = $schedule->activities()->findOrFail($activityId);

        $activity->activity = $request->input('activity');
        $activity->save();

        $schedule->load('activities');

        $response = [
            'code' => 200,
            'data' => $schedule,
        ];

        return response()->json($response);
    }

    public function deleteActivity(Request $request, $scheduleId, $activityId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $activity = $schedule->activities()->findOrFail($activityId);

        $activity->delete();

        $schedule->load('activities');

        $response = [
            'code' => 200,
            'data' => $schedule,
        ];

        return response()->json($response);
    }

    // public function getScheduleById($scheduleId)
    // {
    //     $schedule = Schedule::with('activities')->findOrFail($scheduleId);

    //     $response = [
    //         'code' => 200,
    //         'data' => $schedule,
    //     ];

    //     return response()->json($response);
    // }

    public function getScheduleById($scheduleId)
{
    try {
        $schedule = Schedule::with('activities')->findOrFail($scheduleId);

        $response = [
            'code' => 200,
            'data' => $schedule,
        ];
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
        $response = [
            'code' => 404,
            'message' => 'Data dengan ID tersebut tidak ditemukan.',
        ];
    }

    return response()->json($response);
}


    public function searchSchedulesByTitle(Request $request)
    {
        $judul = $request->input('judul');
    
        $schedules = Schedule::with('activities')
            ->where('judul', 'LIKE', "%$judul%")
            ->get();
    
        if ($schedules->isEmpty()) {
            $response = [
                'code' => 404,
                'message' => 'Data dengan judul tersebut tidak ditemukan.',
            ];
        } else {
            $response = [
                'code' => 200,
                'data' => $schedules,
            ];
        }
    
        return response()->json($response);
    }
    


    public function searchSchedulesByDate(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $schedules = Schedule::with('activities')
            ->whereDate('start_at', '>=', $startDate)
            ->whereDate('end_at', '<=', $endDate)
            ->get();
    
        if ($schedules->count() === 0) {
            $response = [
                'code' => 404,
                'message' => 'Data dengan tanggal tersebut kosong.',
            ];
        } else {
            $response = [
                'code' => 200,
                'data' => $schedules,
            ];
        }
    
        return response()->json($response);
    }
    

    public function getAllSchedules()
    {
        $schedules = Schedule::with('activities')->get();

        if(empty($schedule)){
            $response = [
                'success' => false,
                'message' => 'Resource Not Found',
                'data' => null
            ];
        }

        $response = [
            'success' => true,
            'code' => 200,
            'data' => $schedules,
        ];

        return response()->json($response);
    }

    public function addActivityToSchedule(Request $request, $scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $activity = new Activity();
        $activity->schedule_id = $schedule->id;
        $activity->activity = $request->input('activity');
        $activity->save();

        $response = [
            'code' => 201,
            'data' => [
                'id' => $activity->id,
                'schedule_id' => $activity->schedule_id,
                'activity' => $activity->activity,
            ],
        ];

        return response()->json($response, 201);
    }

}
