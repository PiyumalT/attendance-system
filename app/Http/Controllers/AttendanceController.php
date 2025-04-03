<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function showAttendanceForm()
    {
        $user = Auth::user();
        
        // Assume you have shift start times from backend or config
        $shiftStart = '09:00 AM'; // Example shift start time

        $statusMessage = 'on time'; // This can be dynamically determined
        $isLate = false;
        $isShortLeave = false;

        // Logic to determine whether the user is late or on short leave
        $currentTime = now()->format('H:i');
        if ($currentTime > $shiftStart) {
            $isLate = true;
            $statusMessage = 'late';
        }

        return view('attendance.attendance-form', compact('statusMessage', 'isLate', 'isShortLeave', 'shiftStart'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'sign_type' => 'required|in:in,out',
            'notes' => 'nullable|string|max:255',
        ]);

        // Get the currently authenticated user
        $userId = Auth::id();
        
        if ($request->sign_type == 'in') {
            // Create sign-in record
            Attendance::create([
                'user_id' => $userId,
                'sign_type' => 'in',
                'notes' => $request->notes,
                'status' => 'present',  // Can be dynamic based on shift time logic
            ]);
        } elseif ($request->sign_type == 'out') {
            // Find corresponding sign-in record and create sign-out
            $signIn = Attendance::where('user_id', $userId)
                                ->where('sign_type', 'in')
                                ->whereNull('sign_out_id')
                                ->latest()
                                ->first();

            if ($signIn) {
                $signIn->update([
                    'status' => 'completed', // Or any other logic for status
                ]);

                Attendance::create([
                    'user_id' => $userId,
                    'sign_type' => 'out',
                    'notes' => $request->notes,
                    'status' => 'completed',  // Can be dynamic based on logic
                    'sign_in_id' => $signIn->id,  // Link the sign-out to the sign-in
                ]);
            }
        }

        return redirect()->route('attendance.form')->with('success', 'Attendance recorded successfully.');
    }
}
