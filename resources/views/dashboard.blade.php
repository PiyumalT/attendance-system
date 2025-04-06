<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-lg font-semibold">
                    👋 Hello {{ auth()->user()->name }}, you're logged in!
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @can('manage_users')
                    <a href="{{ route('users.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 transition text-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8zm0 0v1m0 4h.01"></path>
                        </svg>
                        <span class="font-semibold">Manage Users</span>
                    </a>
                @endcan

                @can('mark_attendance')
                    <a href="{{ route('attendance.create') }}"
                       class="bg-green-600 hover:bg-green-700 transition text-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 16h4v4m0 0h4m-4 0v-4m-4 0h-4m0 0H8m0 0V8m0 8V8m0 8h4m4 0h4"></path>
                        </svg>
                        <span class="font-semibold">Mark Attendance</span>
                    </a>
                @endcan

                @canany(['view_attendance', 'mark_attendance'])
                    <a href="{{ route('attendance.view') }}"
                       class="bg-yellow-600 hover:bg-yellow-700 transition text-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-semibold">View Attendance</span>
                    </a>
                @endcan

                @can('manage_roles')
                    <a href="{{ route('attendance.create') }}"
                       class="bg-purple-600 hover:bg-purple-700 transition text-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 4v16m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                        <span class="font-semibold">Manage Roles</span>
                    </a>
                @endcan



            </div>

        </div>
    </div>
</x-app-layout>
