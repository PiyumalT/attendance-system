<nav x-data="{ open: false, menuOpen: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="font-bold text-xl text-indigo-700 tracking-wide mr-6">AttendancePro</a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex space-x-2 items-center">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Dashboard</a>

                @can('view own attendance')
                    <a href="{{ route('attendance.history') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('attendance.history') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">My Attendance</a>
                @endcan

                @can('view employee attendance')
                    <a href="{{ route('attendance.employees') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('attendance.employees') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Employee Attendance</a>
                @endcan

                @can('manage_users')
                    <a href="{{ route('users.index') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('users.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Manage Users</a>
                @endcan

                @can('manage_roles')
                    <a href="{{ route('roles.index') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('roles.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Manage Roles</a>
                @endcan

                @can('view_work_schedule')
                    <a href="{{ route('work-schedules.index') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('work-schedules.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Work Schedules</a>
                @endcan


                @can('manage_salary')
                    <a href="{{ route('salary-info.index') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('salary-info.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Salary Info</a>
                    <a href="{{ route('salary-report.index') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('salary-report.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Salary Report</a>
                @endcan

                @auth
                    <a href="{{ route('salary.my-report') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('salary.my-report') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">My Salary</a>
                @endauth

                <a href="{{ route('leaves.index') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('leaves.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">My Leaves</a>

                @can('manage_leaves')
                    <a href="{{ route('leaves.manage') }}" class="px-3 py-2 rounded transition font-medium {{ request()->routeIs('leaves.manage') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Manage Leaves</a>
                @endcan
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden md:flex md:items-center relative">
                <button @click="menuOpen = !menuOpen" class="text-sm text-gray-600 hover:text-gray-800 focus:outline-none">
                    {{ Auth::user()->name }}
                    <svg class="w-4 h-4 inline ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="menuOpen" @click.away="menuOpen = false" class="absolute right-0 mt-2 w-48 bg-white shadow-md rounded-md py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="md:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-600 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Nav -->
    <div x-show="open" class="md:hidden px-4 pb-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Dashboard</a>
        @can('view own attendance') <a href="{{ route('attendance.history') }}" class="block px-3 py-2 rounded {{ request()->routeIs('attendance.history') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">My Attendance</a> @endcan
        @can('view employee attendance') <a href="{{ route('attendance.employees') }}" class="block px-3 py-2 rounded {{ request()->routeIs('attendance.employees') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Employee Attendance</a> @endcan
        @can('manage_users') <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('users.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Manage Users</a> @endcan
        @can('manage_roles') <a href="{{ route('roles.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('roles.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Manage Roles</a> @endcan
        @can('view_work_schedule') <a href="{{ route('work-schedules.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('work-schedules.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Work Schedules</a> @endcan
        @can('manage_work_schedule') <a href="{{ route('work-schedules.create') }}" class="block px-3 py-2 rounded {{ request()->routeIs('work-schedules.create') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Create Schedule</a> @endcan
        @can('manage_salary')
            <a href="{{ route('salary-info.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('salary-info.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Salary Info</a>
            <a href="{{ route('salary-report.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('salary-report.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Salary Report</a>
        @endcan
        @auth <a href="{{ route('salary.my-report') }}" class="block px-3 py-2 rounded {{ request()->routeIs('salary.my-report') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">My Salary</a> @endauth
        <a href="{{ route('leaves.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('leaves.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">My Leaves</a>
        @can('manage_leaves') <a href="{{ route('leaves.manage') }}" class="block px-3 py-2 rounded {{ request()->routeIs('leaves.manage') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Manage Leaves</a> @endcan
        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded {{ request()->routeIs('profile.edit') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">Profile</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-red-50 hover:text-red-700">Logout</button>
        </form>
    </div>
</nav>
