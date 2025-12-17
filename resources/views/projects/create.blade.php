<!-- filepath: c:\Users\Lenovo\Desktop\miso\projects\php_projects\minicrm\resources\views\projects\create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project') }}
        </h2>
    </x-slot>

    <div id="app">
        <project-form
            :users="{{ $users->toJson() }}"
            :clients="{{ $clients->toJson() }}"
            :statuses="{{ json_encode(\App\Enums\ProjectStatus::cases()) }}"
        ></project-form>
    </div>
</x-app-layout>