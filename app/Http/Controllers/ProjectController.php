<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('updated_at', 'desc')->with(['user', 'client'])->paginate(10);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($projects);
        }

        $users = User::all();
        $clients = Client::all();
        $statuses = \App\Enums\ProjectStatus::cases();
    
        // For a single project (for example, the first one)
        $project = $projects->first();
        return view('projects.index', compact('projects', 'project', 'users', 'clients', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users   = User::select(['id', 'first_name', 'last_name'])->get();
        $clients = Client::select(['id', 'client_name'])->get();

        return view('projects.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());
        $project->load(['user', 'client']);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($project, 201);
        }

        return redirect()->route('projects.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $users   = User::select(['id', 'first_name', 'last_name'])->get();
        $clients = Client::select(['id', 'client_name'])->get();

        $currentAssignedUserId   = $project->user_id;
        $currentAssignedClientId = $project->client_id;
        $currentProjectStatus    = $project->status;

        return view('projects.edit', compact('project', 'users', 'clients', 'currentAssignedUserId', 'currentAssignedClientId', 'currentProjectStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        $project->load(['user', 'client']);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($project);
        }

        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json(null, 204);
        }

        return redirect()->route('projects.index');
    }
}
