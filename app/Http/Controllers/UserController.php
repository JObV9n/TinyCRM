<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('updated_at', 'desc')->with('roles')->paginate(10);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($users);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->load('roles');

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($user, 201);
        }

        return redirect()->route('users.index', ["message" => "New User is added"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($user);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // echo "User to be edited";
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->load('roles');

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json($user);
        }

        return redirect()->route('users.index', ["message" => $user->first_name . "data is updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json(null, 204);
        }

        return redirect()->route('users.index');
    }
}
