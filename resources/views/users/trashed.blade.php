<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Trashed Users') }}
            </h2>
            <a type="button" href="{{ route('users.create') }}"
               class="text-white bg-blue-500 hover:bg-blue-700 border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add
                User</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$loop->index + 1}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$user->fullname}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->username}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->email}}
                                </td>
                                <td class="px-6 py-4 flex justify-center">

                                    <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                          class="inline bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-2"
                                          onsubmit="return confirm('Are you sure you want to restore this user?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger">Restore</button>
                                    </form>

                                    <form action="{{ route('users.delete', $user->id) }}" method="POST"
                                          class="inline bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full mr-2"
                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" colspan="5"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                    No trashed user found!
                                </th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="m-2">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
