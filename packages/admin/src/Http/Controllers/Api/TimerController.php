<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\Request;

class TimerController
{
  /**
   * Handle the incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Task $task
   * @return \Illuminate\Http\Response
   */

  public function start(Request $request) {
    $time = intval(microtime(true));
    Task::where('id', $request->id)->update([
      'timer_start_at' => $time,
      'timer_end_at' => '',
      'status_time' => 1
    ]);
    return ['success' => true];
  }
  public function stop(Request $request) {
    $time = intval(microtime(true));
    $start_time = intval(Task::where('id', $request->id)->first()->timer_start_at);
    $old_delta_time = intval(Task::where('id', $request->id)->first()->time_replicated);
    $delta_time = $time - $start_time;
    Task::where('id', $request->id)->update([
      'timer_end_at' => $time,
      'time_replicated' => $old_delta_time + $delta_time,
      'status_time' => 0
    ]);
    return ['success' => true];
  }
  public function getWorkingList(){
    $tasksUser = TaskUser::where('user_id', auth()->id())
      ->distinct()
      ->pluck('task_id')
      ->toArray();
    $tasks = Task::whereIn('id', $tasksUser)->where('status_time',1)->get();
    return $tasks;
  }

}
