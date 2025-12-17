<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form table for client creation -->
            <form method="POST" action="{{route ('clients.store')}}">
                @csrf
                <!-- Full Name -->
                <div class="mb-5">
                    <label for="client_name" class="block mb-2 font-bold text-gray-600">Full Name</label>
                    <input type="text" id="client_name" name="client_name" placeholder="Put in your Full name." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('client_name')" class="mt-2"/>

                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label for="client_email" class="block mb-2 font-bold text-gray-600">Email</label>
                    <input type="email" id="client_email" name="client_email" placeholder="Put in your email address." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('client_email')" class="mt-2"/>

                </div>
                <!-- Address -->
                <div class="mb-5">
                    <label for="client_address" class="block mb-2 font-bold text-gray-600">Address</label>
                    <input type="text" id="client_address" name="client_address" placeholder="Put in your Address." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('client_address')" class="mt-2"/>
                    
                </div>
                <!-- City -->
                <div class="mb-5">
                    <label for="client_city" class="block mb-2 font-bold text-gray-600">City</label>
                    <input type="text" id="client_city" name="client_city" placeholder="Put in your City." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('client_city')" class="mt-2"/>

                </div>
                <!-- Zipcode -->
                <div class="mb-5">
                    <label for="client_zipcode" class="block mb-2 font-bold text-gray-600">Zipcode</label>
                    <input type="text" id="client_zipcode" name="client_zipcode" placeholder="Put in your Zipcode." class="border border-gray-300 shadow p-3 w-full rounded mb-">
                    <x-input-error :messages="$errors->get('client_zipcode')" class="mt-2"/>

                </div>
                <!-- Sudmit button -->
                <button class="block w-full bg-blue-500 text-white font-bold p-4 rounded-lg">Submit</button>
            </form>

        </div>
    </div>
</x-app-layout>