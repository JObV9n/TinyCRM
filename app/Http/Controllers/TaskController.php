<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('updated_at', 'desc')->with(['user', 'client', 'project'])->paginate(10);
        // $users = User::orderBy('updated_at','desc')->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users    = User::select(['id', 'first_name', 'last_name'])->get();
        $clients  = Client::select(['id', 'client_name'])->get();
        $projects = Project::select(['id', 'title'])->get();

        return view('tasks.create', compact('users', 'clients', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users    = User::select(['id', 'first_name', 'last_name'])->get();
        $clients  = Client::select(['id', 'client_name'])->get();
        $projects = Project::select(['id', 'title'])->get();

        $tasks                    = Task::select(['id', 'title'])->get();
        $currentAssignedUserId    = $task->user_id;
        $currentAssignedClientId  = $task->client_id;
        $currentAssignedProjectId = $task->project_id;
        $currentTaskStatus        = $task->status;

        return view('tasks.edit', compact(
            'task',
            'projects',
            'users',
            'clients',
            'currentAssignedUserId',
            'currentAssignedClientId',
            'currentAssignedProjectId',
            'currentTaskStatus'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
