<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Create User
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Please enter user information.
                        </p>
                    </div>
                    <a href="{{ route('users.index') }}"  class="flex items-center bg-gray-500 hover:bg-gray-700 text-white py-1 px-2 rounded-full mr-4 sm:px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        <span>Back</span>
                    </a>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf

                        @include('users.partials.form')

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Add User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
