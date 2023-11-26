<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\Label;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\ProjectList;
use Illuminate\Http\Request;
use App\Notifications\TaskAssigned;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Pagination\Paginator;


class ReportsController
{
  public function getTasks(Request $request) {
    $data = $request;

    $order = (object) '';
    $order->name = $request->query('order_name') ?? 'updated_at';
    $order->dir = $request->query('order_dir') ??'desc';

    $tasks = Task::when($request->query('users_id'), function(Builder $query, $users_id) {
      $arr = [];
      $users = TaskUser::whereIn('user_id', $users_id)->get();
      foreach ($users as $user) {
        $arr[] = $user['task_id'];
      }
      $query->whereIn('id', $arr);
    })

      ->when($request->query('projects_id'), function(Builder $query, $projects) {
        $query->whereIn('project_id', $projects);
      })

      ->when($request->query('dates'), function (Builder $query, $dates) {
        $query->whereBetween('completed_at', $dates);
      })

      ->orderBy($order->name, $order->dir)

      ->paginate(40);

    $tasks->load(
      'project',
      'projectList',
      'project.users',
      'priority',
      'users',
      'labels',
      'checklists.checklistItems',
      'comments.user',
      'comments.attachments',
      'attachments',
      'files',
      'timelogs.user');

    return [
      'data' => $tasks
    ];
  }

  public function getTasksList(Request $request){
    $data = $request;

    $tasks_statistic = Task::when($request->query('users_id'), function(Builder $query, $users_id) {
      $arr = [];
      $users = TaskUser::whereIn('user_id', $users_id)->get();
      foreach ($users as $user) {
        $arr[] = $user['task_id'];
      }
      $query->whereIn('id', $arr);
    })

      ->when($request->query('projects_id'), function(Builder $query, $projects) {
        $query->whereIn('project_id', $projects);
      })

      ->when($request->query('dates'), function (Builder $query, $dates) {
        $query->whereBetween('completed_at', $dates);
      })
      ->get();


    return [
      'tasks_all' => count($tasks_statistic),

      'tasks_done' => count(array_filter($tasks_statistic->toArray(), function($task) {
        return $task['completed_at'] != null;
      })),

      'tasks_graded' => array_sum(
        array_map(function($task) {
          return $task['deadline'];
        }, $tasks_statistic->toArray())
      ),

      'task_worked' => array_sum(
        array_map(function($task) {
          return $task['time_replicated'];
        }, $tasks_statistic->toArray())
      ),


    ];
  }

  public function getAllUsers(){
    return User::get();
  }

  public function getAllProjects(){
    return Project::get();
  }
}
