<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\ChecklistItem;

class ChecklistItemComplete
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ChecklistItem  $item
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request, ChecklistItem $item)
  {
    if ($item->completed_at) {
      $item->update(['completed_at' => null]);
      return ['success' => true, 'completed_at' => null];
    }

    $checklistId = $item->checklist_id;

    $lastCheckList = ChecklistItem::where([
      ['completed_at', '!=', null],
      ['checklist_id', '=', $checklistId],
    ])->sum('total_second');

    $task = Task::find($request->post('task'));

    $total = $request->post('time') - $task->timer_start_at - $lastCheckList + $task->time_replicated;

    $item->update([
      'completed_at' => now(),
      'total_second' => $total
    ]);

    return [
      'success' => true,
      'completed_at' => 'true',
      'time' => $total
    ];
  }
}
