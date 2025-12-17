<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{route('tasks.create')}}" class="underline">Add new Task</a>
                </div>
                <!-- table with task details -->
                <table class="w-full text-sm text-left text-gray-500 border border-slate-400 table-auto mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 border border-slate-400 ">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 border border-slate-400">
                                Assigned To
                            </th>
                            <th scope="col" class="px-6 py-3 border border-slate-400">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-3 border border-slate-400">
                                Project
                            </th>
                            <th scope="col" class="px-6 py-3 border border-slate-400">
                                Deadline
                            </th>
                            <th scope="col" class="px-6 py-3 border border-slate-400">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 border border-slate-400">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr class="bg-white">
                            <th scope="row" class="px-6 py-4 border  font-medium text-gray-900 whitespace-nowrap">
                                {{ $task->title }}
                            </th>
                            <td class="px-6 py-4 border">
                                {{ $task->user->first_name }} {{ $task->user->last_name}}
                            </td>
                            <td class="px-6 py-4 border ">
                                {{ $task->client->client_name }}
                            </td>
                            <td class="px-6 py-4 border ">
                                {{ $task->project->title }}
                            </td>
                            <td class="px-6 py-4 border ">
                                {{ $task->deadline_at }}
                            </td>
                            <td class="px-6 py-4 border ">
                                {{ $task->status }}
                            </td>
                            <td class="px-6 py-4 border ">
                                <a href="{{route('tasks.edit',$task)}}"> <u>Edit</u></a> /

                                <form action="{{route('tasks.destroy',$task)}}" method="POST" class="inline"
                                    onsubmit="confirm('Are u sure to delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="mt-4"> {{ $tasks->links()}}</p>
            </div>
        </div>
</x-app-layout>