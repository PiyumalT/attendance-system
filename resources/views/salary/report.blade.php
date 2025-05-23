<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Salary Report</h2>
    </x-slot>

    <div class="p-4 max-w-6xl mx-auto">
        <form method="GET" class="flex items-end gap-4 mb-6">
            <div>
                <label>User</label>
                <select name="user_id" class="border rounded p-2 w-48">
                    <option value="">-- Select --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Month</label>
                <input type="month" name="month" value="{{ $selectedMonth }}" class="border rounded p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">View</button>
        </form>

        @if($calendarData)
            <div class="grid grid-cols-7 gap-4 text-center border rounded p-4 bg-white mb-6">
                @foreach($calendarData as $date => $data)
                    @php
                        $isToday = \Carbon\Carbon::parse($date)->isToday();
                        $isFuture = \Carbon\Carbon::parse($date)->isFuture();
                        $bgClass = match(true) {
                            $isToday => 'bg-blue-100',
                            $data['status'] === 'Present' => 'bg-green-50',
                            $data['status'] === 'Leave' => 'bg-yellow-100',
                            $data['status'] === 'Absent' => 'bg-red-100',
                            $isFuture => 'bg-gray-100',
                            default => 'bg-white',
                        };
                        $statusTextClass = match(true) {
                            $isToday => 'text-blue-600',
                            $data['status'] === 'Present' => 'text-green-600',
                            $data['status'] === 'Leave' => 'text-yellow-600',
                            $data['status'] === 'Absent' => 'text-red-600',
                            $isFuture => 'text-gray-600',
                            default => 'text-gray-600',
                        };
                    @endphp
                    <div class="p-2 border rounded shadow {{ $bgClass }}">
                        <strong>{{ \Carbon\Carbon::parse($date)->format('d M D') }}</strong><br>
                        @if($data['status'] === 'Present')
                            Worked: {{ $data['worked_hours'] }}h<br>
                            @if($data['ot_hours'] > 0)
                                OT: {{ $data['ot_hours'] }}h<br>
                            @endif
                        @endif
                        <span class="text-sm text-gray-600">Status:
                            <span class="{{ $statusTextClass }}">
                                {{ $isFuture ? 'Future' : $data['status'] }}
                            </span>
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-4">Salary Summary - {{ $summary['month'] }}</h3>
                <ul class="space-y-2 text-gray-700">
                    <li><strong>Basic Salary:</strong> Rs. {{ number_format($summary['basic_salary'], 2) }}</li>
                    <li><strong>Worked Hours:</strong> {{ $summary['worked_hours'] }} hrs</li>
                    <li><strong>Overtime Hours:</strong> {{ $summary['ot_hours'] }} hrs</li>
                    <li><strong>Absent Days:</strong> {{ $summary['absent_days'] }}</li>
                    <li><strong>OT Pay:</strong> Rs. {{ number_format($summary['ot_pay'], 2) }}</li>
                    <li><strong>Absent Deduction:</strong> Rs. {{ number_format($summary['absent_deduction'], 2) }}</li>
                    <li><strong>Late Deduction:</strong> Rs. {{ number_format($summary['late_deduction'], 2) }}</li>
                    <li><strong>EPF Deduction:</strong> Rs. {{ number_format($summary['epf_deduction'], 2) }}</li>
                    <li><strong>Final Salary :</strong>
                        <span class="text-green-700 font-bold">Rs. {{ number_format($summary['total_pay'], 2) }}</span>
                    </li>
                </ul>

                {{-- <div class="mt-6">
                    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded">Download PDF</a>
                </div> --}}

                <div class="mt-6">
                    <form method="POST" action="{{ route('salary.email.user') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $selectedUserId }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Send Paysheet Email
                        </button>
                    </form>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>
