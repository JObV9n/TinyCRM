<!-- filepath: c:\Users\Lenovo\Desktop\miso\projects\php_projects\minicrm\resources\views\projects\edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div id="app">
        <project-edit-form
            :project="{{ $project->toJson() }}"
            :users="{{ $users->toJson() }}"
            :clients="{{ $clients->toJson() }}"
            :statuses="{{ json_encode(\App\Enums\ProjectStatus::cases()) }}"
        ></project-edit-form>
    </div>
</x-app-layout>