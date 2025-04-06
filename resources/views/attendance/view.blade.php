<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Attendance') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <!-- Filters -->
        <form method="GET" action="{{ route('attendance.view') }}" class="mb-6 bg-white p-4 rounded shadow flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex flex-col">
                <label for="from_date" class="text-sm font-medium text-gray-600">From Date</label>
                <input type="date" name="from_date" id="from_date" class="border rounded px-3 py-2" value="{{ request('from_date') }}">
            </div>
            <div class="flex flex-col">
                <label for="to_date" class="text-sm font-medium text-gray-600">To Date</label>
                <input type="date" name="to_date" id="to_date" class="border rounded px-3 py-2" value="{{ request('to_date') }}">
            </div>
            @can('view_attendance')
                <div class="flex flex-col flex-grow">
                    <label for="search" class="text-sm font-medium text-gray-600">Search User</label>
                    <input type="text" name="search" id="search" class="border rounded px-3 py-2" placeholder="Name or Email" value="{{ request('search') }}">
                </div>
            @endcan
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
            </div>
        </form>

        <!-- Attendance Table -->
        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full text-sm text-left border border-gray-300 border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Name</th>
                        <th class="px-4 py-2 border border-gray-300">Email</th>
                        <th class="px-4 py-2 border border-gray-300">Sign In Time</th>
                        <th class="px-4 py-2 border border-gray-300">Sign In Status</th>
                        <th class="px-4 py-2 border border-gray-300">Sign Out Time</th>
                        <th class="px-4 py-2 border border-gray-300">Sign Out Status</th>
                        <th class="px-4 py-2 border border-gray-300">Notes</th>
                        <th class="px-4 py-2 border border-gray-300">Worked Time</th>
                        <th class="px-4 py-2 border border-gray-300">Overtime</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalWorked = 0;
                        $totalOvertime = 0;
                    @endphp

                    @forelse ($attendances as $record)
                        @php
                            $workedMins = $record['worked_mins'] ?? 0;
                            $overtimeMins = $record['overtime'] ?? 0;
                            $totalWorked += $workedMins;
                            $totalOvertime += $overtimeMins;
                        @endphp
                        <tr class="border-b">
                            <td class="px-4 py-2 border border-gray-300">{{ $record['user_name'] }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $record['user_email'] }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                <span class="datetime" data-datetime="{{ \Carbon\Carbon::parse($record['sign_in_time'])->toIso8601String() }}"></span>
                            </td>
                            <td class="px-4 py-2 border border-gray-300">{{ ucfirst($record['sign_in_status']) }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                @if ($record['sign_out_time'])
                                    <span class="datetime" data-datetime="{{ \Carbon\Carbon::parse($record['sign_out_time'])->toIso8601String() }}"></span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 border border-gray-300">{{ ucfirst($record['sign_out_status'] ?? '-') }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $record['notes'] ?? '-' }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ floor($workedMins / 60) . 'h ' . ($workedMins % 60) . 'm' }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $overtimeMins ? floor($overtimeMins / 60) . 'h ' . ($overtimeMins % 60) . 'm' : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500 border border-gray-300">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-100 font-semibold">
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-right border border-gray-300">Total</td>
                        <td class="px-4 py-2 border border-gray-300">{{ floor($totalWorked / 60) . 'h ' . ($totalWorked % 60) . 'm' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $totalOvertime > 0 ? floor($totalOvertime / 60) . 'h ' . ($totalOvertime % 60) . 'm' : '-' }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.datetime');

            elements.forEach(el => {
                const utcTime = el.getAttribute('data-datetime');
                if (utcTime) {
                    const localDate = new Date(utcTime);
                    // el.textContent = localDate.toLocaleString();  format date and time dd/mm/yyyy hh:mm:ss
                    el.textContent = localDate.toLocaleString('en-GB', { timeZone: 'UTC' });
                    el.textContent = el.textContent.replace(',', ''); // Remove the comma between date and time
                    el.textContent = el.textContent.replace(' ', ' '); // Replace space with space
                } else {
                    el.textContent = '-';

                }
            });
        });
    </script>


    
</x-app-layout>
