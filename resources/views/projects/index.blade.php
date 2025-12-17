<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div id="app">
        <project-edit-form
            :project="@json($project)"
            :users="@json($users)"
            :clients=" @json($clients)"
            :statuses="@json(\App\Enums\ProjectStatus::cases())"
        ></project-edit-form>
    </div>
</x-app-layout>