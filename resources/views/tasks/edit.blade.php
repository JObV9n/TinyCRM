<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form table for task creation -->
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT') <!-- Include this to specify the PUT method for updating -->
                <!-- Title -->
                <div class="mb-5">
                    <label for="title" class="block mb-2 font-bold text-gray-600">Task Title</label>
                    <input type="text" id="title" name="title" value="{{old('title',$task->title)}}" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('titile')" class="mt-2" />

                </div>

                <!-- Description -->
                <div class="mb-5">
                    <label for="description" class="block mb-2 font-bold text-gray-600">Description</label>
                    <input type="text" id="Description" name="description" value="{{ old('description',$task->description) }}" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />

                </div>
                <!-- Deadline_at -->
                <div class="mb-5">
                    <label for="deadline_at" class="block mb-2 font-bold text-gray-600">Deadline Date</label>
                    <input type="date" id="deadline_at" name="deadline_at" value="{{ old('deadline_at',$task->deadline_at) }}" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('deadline_at')" class="mt-2" />

                </div>
                <!-- Assigned User -->
                <div class="mb-5">
                    <label for="user_id" class="block mb-2 font-bold text-gray-600">Assigned User</label>
                    <select type="text" id="user_id" name="user_id" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @selected(old('user_id' , $currentAssignedUserId )==$user->id)>
                            {{$user->first_name ." ". $user->last_name}}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />

                </div>
                <!-- Assigned Client -->
                <div class="mb-5">
                    <label for="client_id" class="block mb-2 font-bold text-gray-600">Assigned Client</label>
                    <select type="text" id="client_id" name="client_id" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach ($clients as $client)
                        <option value="{{ $client->id }}"
                            @selected(old(' client_id ' , $currentAssignedClientId ) == $client->id)>
                            {{$client->client_name}}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get(' client_id')" class="mt-2" />
                </div>

                <!-- Assigned Project -->
                <div class="mb-5">
                    <label for="project_id" class="block mb-2 font-bold text-gray-600">Assigned Project</label>
                    <select type="text" id="project_id" name="project_id" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            @selected(old('project_id', $currentAssignedProjectId )==$project->id)>
                            {{$project->title}}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                </div>
                <!-- Status -->
                <div class="mb-5">
                    <label for="status" class="block mb-2 font-bold text-gray-600">Status</label>
                    <select id="status" name="status" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach (\App\Enums\TaskStatus::cases() as $status)
                        <option value="{{ $status->value }}"
                            @selected(old('status', $currentTaskStatus)==$status->value) >
                            {{ ucfirst($status->value) }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />

                </div>
                <!-- Submit button -->
                <button class="block w-full bg-blue-500 text-white font-bold p-4 rounded-lg">Update Task</button>
            </form>
        </div>
    </div>
</x-app-layout>
