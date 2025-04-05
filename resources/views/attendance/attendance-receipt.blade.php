<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Receipt') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-center mb-4">Attendance Details</h3>

            <div class="mb-4">
                <p><strong>Shift Start Time:</strong> {{ $shiftStart ?? 'Not Available' }}</p>
                
                <!-- Ensure that timestamp is a Carbon instance before using toIso8601String -->
                <p><strong>Sign In Time:</strong> 
                    <span id="sign-in-time" data-time="{{ \Carbon\Carbon::parse($signIn->timestamp)->toIso8601String() }}"></span>
                </p>
                <p><strong>Sign In Status:</strong> {{ ucfirst($signIn->status) }}</p>

                @if ($signOut)
                    <p><strong>Scheduled Sign Out Time:</strong> {{ $shiftEnd ?? 'Not Available' }}</p>
                    <p><strong>Actual Sign Out Time:</strong> 
                        <span id="sign-out-time" data-time="{{ \Carbon\Carbon::parse($signOut->timestamp)->toIso8601String() }}"></span>
                    </p>
                    <p><strong>Sign Out Status:</strong> {{ ucfirst($signOut->status) }}</p>
                    @if ($signOut->status == 'over_time')
                        <p><strong>Overtime:</strong> Yes</p>
                    @endif
                @endif
            </div>

            <div class="flex justify-center">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Convert the UTC time to the local user's timezone
            const signInTimeElement = document.getElementById('sign-in-time');
            const signOutTimeElement = document.getElementById('sign-out-time');

            if (signInTimeElement) {
                const signInTime = new Date(signInTimeElement.dataset.time);
                // Format the date and time to format dd/mm/yyyy hh:mm:ss
                signInTimeElement.textContent = signInTime.toLocaleString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }

            if (signOutTimeElement) {
                const signOutTime = new Date(signOutTimeElement.dataset.time);
                // Format the date and time to format dd/mm/yyyy hh:mm:ss
                signOutTimeElement.textContent = signOutTime.toLocaleString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }
        });
    </script>
</x-app-layout>
