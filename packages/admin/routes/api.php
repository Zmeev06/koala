<?php

use Admin\Http\Controllers\Api\AvatarUpload;
use Admin\Http\Controllers\Api\CheckUpdates;
use Admin\Http\Controllers\Api\ChecklistItemComplete;
use Admin\Http\Controllers\Api\ChecklistItemsController;
use Admin\Http\Controllers\Api\FavoritesController;
use Admin\Http\Controllers\Api\FileUpload;
use Admin\Http\Controllers\Api\FiltersController;
use Admin\Http\Controllers\Api\GuestController;
use Admin\Http\Controllers\Api\InvitationsController;
use Admin\Http\Controllers\Api\LabelsController;
use Admin\Http\Controllers\Api\LogoUpload;
use Admin\Http\Controllers\Api\Metrics;
use Admin\Http\Controllers\Api\Notifications;
use Admin\Http\Controllers\Api\NotificationsRead;
use Admin\Http\Controllers\Api\ProfileController;
use Admin\Http\Controllers\Api\ProjectArchive;
use Admin\Http\Controllers\Api\ProjectDuplicate;
use Admin\Http\Controllers\Api\ProjectExportTimeLogs;
use Admin\Http\Controllers\Api\ProjectFavorite;
use Admin\Http\Controllers\Api\ProjectListSort;
use Admin\Http\Controllers\Api\ProjectListsController;
use Admin\Http\Controllers\Api\ProjectRestore;
use Admin\Http\Controllers\Api\ProjectTimeLogs;
use Admin\Http\Controllers\Api\ProjectTotalTime;
use Admin\Http\Controllers\Api\ProjectsController;
use Admin\Http\Controllers\Api\ProjectsOptions;
use Admin\Http\Controllers\Api\RecentProjects;
use Admin\Http\Controllers\Api\RolesController;
use Admin\Http\Controllers\Api\SettingsEmailController;
use Admin\Http\Controllers\Api\SettingsGeneralController;
use Admin\Http\Controllers\Api\SubTasksController;
use Admin\Http\Controllers\Api\TaskArchive;
use Admin\Http\Controllers\Api\TaskAssign;
use Admin\Http\Controllers\Api\TaskCommentsController;
use Admin\Http\Controllers\Api\TaskComplete;
use Admin\Http\Controllers\Api\TaskDueDate;
use Admin\Http\Controllers\Api\TaskLabel;
use Admin\Http\Controllers\Api\TaskList;
use Admin\Http\Controllers\Api\TaskMove;
use Admin\Http\Controllers\Api\TaskPriority;
use Admin\Http\Controllers\Api\TaskRecurring;
use Admin\Http\Controllers\Api\TaskRestore;
use Admin\Http\Controllers\Api\TaskSort;
use Admin\Http\Controllers\Api\TimerController;
use Admin\Http\Controllers\Api\ReportsController;
use Admin\Http\Controllers\Api\TasksController;
use Admin\Http\Controllers\Api\TimeLogsController;
use Admin\Http\Controllers\Api\TimeTaskController;
use Admin\Http\Controllers\Api\UpdateApp;
use Admin\Http\Controllers\Api\UpdateRecipe;
use Admin\Http\Controllers\Api\UsersController;
use Admin\Http\Controllers\Api\TaskAttachment;
use Illuminate\Support\Facades\Route;
use App\Models\Attachment;



Route::get('{resource}/filters', FiltersController::class);
Route::get('metrics', Metrics::class);
Route::get('notifications', Notifications::class);
Route::post('notifications/read', NotificationsRead::class);
Route::get('recent-projects', RecentProjects::class);
Route::post('logo', LogoUpload::class);
Route::post('avatar', AvatarUpload::class);
Route::post('file', FileUpload::class);
Route::post('file-delete/{file}', [Attachment::class, 'fileDelete']);
Route::resource('profile', ProfileController::class)->only(['create', 'store']);
Route::resource('time-logs', TimeLogsController::class)->only(['index', 'store']);
Route::resource('time-task', TimeTaskController::class)->only(['index', 'store']);
Route::post('timer/start', [TimerController::class, 'start']);
Route::post('timer/stop', [TimerController::class, 'stop']);
Route::post('timer/get-in-work', [TimerController::class, 'getWorkingList']);

Route::resource('favorites', FavoritesController::class)->only(['index', 'store', 'destroy']);
Route::get('projects/options', ProjectsOptions::class);
Route::resource('projects', ProjectsController::class);
Route::resource('projects.lists', ProjectListsController::class)->shallow();
Route::patch('projects/{project}/favorite', ProjectFavorite::class);
Route::post('projects/{project}/duplicate', ProjectDuplicate::class);
Route::patch('projects/{project}/archive', ProjectArchive::class);
Route::patch('projects/{project}/restore', ProjectRestore::class);
Route::patch('projects/{project}/list-sort', ProjectListSort::class);
Route::get('projects/{project}/time-logs', ProjectTimeLogs::class);
Route::get('projects/{project}/total-time', ProjectTotalTime::class);
Route::get('projects/{project}/export-time-logs', ProjectExportTimeLogs::class);
Route::get('tasks/inwork', [TasksController::class, 'inworklist']);
Route::get('tasks/stop-all-tasks', [TasksController::class, 'stopInWorks']);

Route::resource('tasks.comments', TaskCommentsController::class)->shallow()->only(['store', 'destroy']);
Route::resource('tasks', TasksController::class);
Route::patch('tasks/{task}/sort', TaskSort::class);
Route::patch('tasks/{task}/move', TaskMove::class);
Route::patch('tasks/{task}/list', TaskList::class);
Route::patch('tasks/{task}/priority', TaskPriority::class);
Route::patch('tasks/{task}/assign', TaskAssign::class);
Route::patch('tasks/{task}/label', TaskLabel::class);
Route::patch('tasks/{task}/complete', TaskComplete::class);
Route::patch('tasks/{task}/archive', TaskArchive::class);
Route::patch('tasks/{task}/restore', TaskRestore::class);
Route::patch('tasks/{task}/due-date', TaskDueDate::class);
Route::post('tasks/{task}/recurring', TaskRecurring::class);

Route::resource('tasks.attachment', TaskAttachment::class)->shallow()->only(['store', 'destroy']);
Route::post('sub-tasks', [SubTasksController::class, 'store']);
Route::patch('sub-tasks/{task}', [SubTasksController::class, 'update']);
Route::delete('sub-tasks/{task}', [SubTasksController::class, 'destroy']);
Route::post('checklist-item', [ChecklistItemsController::class, 'store']);
Route::patch('checklist-item/{item}', [ChecklistItemsController::class, 'update']);
Route::delete('checklist-item/{item}', [ChecklistItemsController::class, 'destroy']);
Route::patch('checklist-item/{item}/complete', ChecklistItemComplete::class);

Route::resource('labels', LabelsController::class);
Route::resource('users', UsersController::class);
Route::resource('guest', GuestController::class)->except(['show', 'edit', 'update']);
Route::resource('invitations', InvitationsController::class)->except(['show', 'edit', 'update']);
Route::resource('roles', RolesController::class);

Route::resource('settings/general', SettingsGeneralController::class)->only(['create', 'store']);
Route::resource('settings/email', SettingsEmailController::class)->only(['create', 'store']);
Route::post('check-updates', CheckUpdates::class)->middleware('can:setting:updates');
Route::post('update-app', UpdateApp::class)->middleware('can:setting:updates');
Route::post('update-recipe', UpdateRecipe::class)->middleware('can:setting:updates');

Route::get('reports/get-tasks', [ReportsController::class, 'getTasks']);
Route::get('reports/get-tasks-stat', [ReportsController::class, 'getTasksList']);
Route::get('reports/get-users', [ReportsController::class, 'getAllUsers']);
Route::get('reports/get-projects', [ReportsController::class, 'getAllProjects']);

Route::get('guest-list', [GuestController::class, 'index']);

