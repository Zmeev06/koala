<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Task;
use App\Models\TaskUser;
use App\Models\TimeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TimeLogRequest;

class TimeTaskController
{

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
//        if ($request->start){
//
//            $tasksUser = TaskUser::where('user_id', auth()->id())->get();
//
//
//            foreach ($tasksUser as $taskUser){
//                $task = Task::where('id', $taskUser->task_id)->first();
//                if ($task && $request->taskId != $taskUser->task_id &&  $task->time_replicated > 0){
//                    $second = strtotime(Carbon::parse($request->currentTime)) - $task->time_replicated ;
//                    Task::where('id', $taskUser->task_id)
//                        ->update([
//                            'total_seconds' => $task->total_seconds + $second,
//                            'status_time' => 0,
//                            'time_replicated' => 0
//                        ]);
//                }
//            }
//
//            return Task::where('id', $request->taskId)
//                ->update([
//                    'time_replicated' => strtotime(Carbon::parse($request->currentTime)),
//                    'status_time' => 1,
//                    'completed_at' => null
//                ]);
//        }else if($request->stop){
//            $task = Task::where('id', $request->taskId)->first();
//            $second = strtotime(Carbon::parse($request->currentTime)) - $task->time_replicated;
//            return Task::where('id', $request->taskId)
//                ->update([
//                    'total_seconds' => $task->total_seconds + $second,
//                    'status_time' => 0,
//                    'completed_at' => null
//                ]);
//        }else if ($request->complete){
//            $task = Task::where('id', $request->taskId)->first();
//            $second = strtotime(Carbon::parse($request->currentTime)) - $task->time_replicated;
//            return Task::where('id', $request->taskId)
//                ->update([
//                    'total_seconds' => $task->total_seconds + $second,
//                    'status_time' => 2,
//                    'completed_at' => now()
//                ]);
//        }
    if ($request->start) {
      $tasksUser = TaskUser::where('user_id', auth()->id())->get();
      foreach ($tasksUser as $taskUser) {
        $task = Task::where('id', $taskUser->task_id)->first();
        if ($task && $request->taskId != $taskUser->task_id && $task->time_replicated > 0) {
          $second = strtotime(Carbon::parse($request->currentTime)) - $task->time_replicated;
          Task::where('id', $taskUser->task_id)
            ->update([
              'total_seconds' => $task->total_seconds + $second,
              'status_time' => 0,
              'time_replicated' => 0
            ]);
        }
      }

    }

    return date('m/d/Y H:i:s', intval(microtime(true)));
  }
}
