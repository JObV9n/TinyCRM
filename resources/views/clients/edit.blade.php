<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form table for client creation -->
        <form method="POST" action="{{ route('clients.update', $client) }}">
                @csrf
                @method('PUT') <!-- Include this to specify the PUT method for updating -->
                <div>
                    <x-input-label for="client_name" :value="__('Full Name')" />
                    <x-text-input id="client_name" class="block mt-1 w-full" type="text" name="client_name" :value="old('client_name', $client->client_name)" required autofocus autocomplete="client_name" />
                    <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <x-input-label for="client_email" :value="__('Email')" />
                    <x-text-input id="client_email" class="block mt-1 w-full" type="email" name="client_email" :value="old('client_email', $client->client_email)" required autofocus autocomplete="client_email" />
                    <x-input-error :messages="$errors->get('client_email')" class="mt-2" />

                </div>
                <!-- Address -->
                <div class="mb-5">
                    <x-input-label for="client_address" :value="__('Address')" />
                    <x-text-input id="client_address" class="block mt-1 w-full" type="address" name="client_address" :value="old('client_address', $client->client_address)" required autofocus autocomplete="client_address" />
                    <x-input-error :messages="$errors->get('client_address')" class="mt-2" />

                </div>
                <!-- City -->
                <div class="mb-5">
                    <x-input-label for="client_city" :value="__('City')" />
                    <x-text-input id="client_city" class="block mt-1 w-full" type="text" name="client_city" :value="old('client_email', $client->client_city)" required autofocus autocomplete="client_city" />
                    <x-input-error :messages="$errors->get('client_city')" class="mt-2" />
                </div>

                <div class="mb-5">
                    <x-input-label for="client_zipcode" :value="__('Zipcode')" />
                    <x-text-input id="client_zipcode" class="block mt-1 w-full" type="text" name="client_zipcode" :value="old('client_zipcode', $client->client_zipcode)"required autofocus autocomplete="client_zipcode" />
                    <x-input-error :messages="$errors->get('client_zipcode')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>