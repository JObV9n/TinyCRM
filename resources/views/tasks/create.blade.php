<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form table for task creation -->
            <form method="POST" action="{{route('tasks.store')}}">
                @csrf
                <!-- Title -->
                <div class="mb-5">
                    <label for="title" class="block mb-2 font-bold text-gray-600">Task Title</label>
                    <input type="text" id="title" name="title" placeholder="Put in your task title." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />

                </div>

                <!-- Description -->
                <div class="mb-5">
                    <label for="description" class="block mb-2 font-bold text-gray-600">Description</label>
                    <input type="text" id="Description" name="description" placeholder="Put in your Description." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />

                </div>
                <!-- Deadline_at -->
                <div class="mb-5">
                    <label for="deadline_at" class="block mb-2 font-bold text-gray-600">Deadline Date</label>
                    <input type="date" id="deadline_at" name="deadline_at" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('deadline_at')" class="mt-2" />

                </div>
                <!-- Assigned User -->
                <div class="mb-5">
                    <label for="user_id" class="block mb-2 font-bold text-gray-600">Assigned User</label>
                    <select type="text" id="user_id" name="user_id" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @selected(old("user_id")==$user->id)> {{$user->first_name ." ". $user->last_name}}</option>
                        @endforeach
                    </select>

                </div>
                <!-- Assigned Client -->
                <div class="mb-5">
                    <label for="client_id" class="block mb-2 font-bold text-gray-600">Assigned Client</label>
                    <select type="text" id="client_id" name="client_id" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach ($clients as $client)
                        <option value="{{$client->id}}"
                            @selected(old("client_id")==$client->id)> {{$client->client_name}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Assigned Project -->
                <div class="mb-5">
                    <label for="project_id" class="block mb-2 font-bold text-gray-600">Assigned Project</label>
                    <select id="project_id" name="project_id" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach ($projects as $project)
                        <option value="{{$project->id}}"
                            @selected(old("project_id")==$project->id)> {{$project->title}}</option>
                        @endforeach
                    </select>

                </div>
                <!-- Status -->
                <div class="mb-5">
                    <label for="status" class="block mb-2 font-bold text-gray-600">Status</label>
                    <select type="text" id="status" name="status" class="border border-gray-300 shadow p-3 w-full rounded mb-">
                        @foreach (\App\Enums\TaskStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status')==$status->value) >
                            {{$status->value}}
                        </option>
                        @endforeach
                    </select>

                </div>
                <!-- Submit button -->
                <button class="block w-full bg-blue-500 text-white font-bold p-4 rounded-lg">Submit Creation</button>
            </form>

        </div>
    </div>
</x-app-layout>