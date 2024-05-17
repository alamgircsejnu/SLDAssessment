<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <p class="text-xl">Welcome to the dashboard!</p> <br>
                    <p>To access the list of users, kindly proceed to the <a class="underline text-blue-500" href="{{ route('users.index') }}">
                            Users</a> section.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
