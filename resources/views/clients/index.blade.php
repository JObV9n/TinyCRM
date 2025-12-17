<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{route('clients.create')}}" class="underline">Add new client</a>
                </div>

            </div>

            <!-- table with client details -->

            <table class="w-full text-sm text-left text-gray-500 border border-slate-400 table-auto mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 border border-slate-400 ">
                            First Name
                        </th>
                        <th scope="col" class="px-6 py-3 border border-slate-400">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 border border-slate-400">
                            Contact Number
                        </th>
                        <th scope="col" class="px-6 py-3 border border-slate-400">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3 border border-slate-400">
                            Zipcode
                        </th>
                        <th scope="col" class="px-6 py-3 border border-slate-400">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr class="bg-white">
                        <th scope="row" class="px-6 py-4 border  font-medium text-gray-900 whitespace-nowrap">
                            {{ $client->client_name }}
                        </th>
                        <td class="px-6 py-4 border">
                            {{ $client->client_email }}

                        </td>
                        <td class="px-6 py-4 border ">
                            {{ $client->client_phone }}
                        </td>
                        <td class="px-6 py-4 border ">
                            {{ $client->client_address }}
                        </td>
                        <td class="px-6 py-4 border ">
                            {{ $client->client_zipcode }}
                        </td>
                        <td class="px-6 py-4 border ">
                            <a href="{{route('clients.edit',$client)}}"> <u>Edit</u></a> /

                            <form action="{{route('clients.destroy',$client)}}" method="POST" class="inline"
                                onsubmit="confirm('Are u sure to delete?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 underline">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="mt-4"> {{ $clients->links()}}</p>
        </div>
    </div>
</x-app-layout>