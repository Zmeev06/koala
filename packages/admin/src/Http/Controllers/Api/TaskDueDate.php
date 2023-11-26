<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskDueDate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Task $task)
    {
        var_dump($request->due_at.' '.$request->due_time);
        $task->update([
            'due_at' => $request->due_at.' '.$request->due_time
        ]);

        return ['success' => true];
    }
}
