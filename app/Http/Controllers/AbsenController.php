<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenRequest;
use App\Http\Requests\UpdateAbsenRequest;
use App\Models\Absen;
use App\Models\FingerPrintData;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AbsenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store','storeFinger','triggerDataPost');
    }

    public function index()
    {
        $title = "Absen";
        $description = "Detail Absen";
        $users = Absen::with('user', 'user.role')->orderBy('created_at', 'desc')->get();

        return view('admin.absens.index', compact('title', 'users', 'description'));
    }


    public function store(Request $request)
    {
        $fingerId = $request->query('finger_id');

        // Retrieve the user based on the finger ID
        $user = User::where('finger_id', $fingerId)->first();

        // If the user is not found
        if (!$user) {
            $existingFingerPrintData = FingerPrintData::first();
            if ($existingFingerPrintData) {
                $existingFingerPrintData->delete();
            }

            FingerPrintData::create([
                'finger_print_id' => $fingerId,
            ]);

            return response()->json(['message' => 'User not found, please contact admin to register your fingerprint.'], 200);
        }

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        // Check for existing attendance record for today
        $attendance = Absen::where('user_id', $user->id)
            ->where('attendance_date', $currentDate)
            ->first();

        // If attendance record exists
        if ($attendance) {
            // If the user has not checked out yet
            if (is_null($attendance->check_out)) {
                $checkOutStart = '16:00:00';
                $checkOutEnd = '23:59:59';

                // Validate check-out time
                if ($currentTime < $checkOutStart || $currentTime > $checkOutEnd) {
                    return response()->json(['message' => 'Check-out time must be between 16:00 and 24:00.'], 200);
                }

                // Update check-out and calculate total work time
                $attendance->check_out = $currentTime;
                $attendance->total_work_time = Carbon::parse($attendance->check_in)->diff($currentTime)->format('%H:%I:%S');

                // Set the status for check-out
                if ($currentTime < '16:00:00') {
                    $attendance->status_check_out = 'Early check-out';
                } else {
                    $attendance->status_check_out = 'On-time check-out';
                }

                $attendance->save();

                return response()->json([
                    'message' => 'Check-out recorded successfully',
                    'attendance' => $attendance
                ]);
            } else {
                return response()->json(['message' => 'User has already checked out for today'], 200);
            }
        } else {
            // No existing attendance record, handle check-in
            $checkInStart = '06:00:00';
            $checkInEnd = '12:00:00';

            // If current time is out of check-in range
            if ($currentTime < $checkInStart || $currentTime > $checkInEnd) {
                // Create attendance record indicating absence due to late check-in
                $statusCheckOut = null;
                if ($currentTime < '16:00:00') {
                    $statusCheckOut = 'Early check-out';
                } else {
                    $statusCheckOut = 'On-time check-out';
                }

                $attendance = Absen::create([
                    'user_id' => $user->id,
                    'attendance_date' => $currentDate,
                    'check_in' => null,
                    'check_out' => $currentTime,
                    'total_work_time' => '00:00:00',
                    'status_check_in' => 'Absent (checked-in late)',
                    'status_check_out' => $statusCheckOut,
                ]);


                return response()->json([
                    'message' => 'You have checked out because check-in time is after 12:00.',
                    'attendance' => $attendance
                ]);
            }

            // Record successful check-in
            $attendance = Absen::create([
                'user_id' => $user->id,
                'attendance_date' => $currentDate,
                'check_in' => $currentTime,
                'status_check_in' => null, // Initially null
            ]);



            // Update status if check-in is late
            if ($currentTime > '12:00:00') {
                $attendance->status_check_in = 'Late check-in';
                $attendance->save();
            } else {
                $attendance->status_check_in = 'On-time check-in';
                $attendance->save();
            }

            return response()->json([
                'message' => 'Check-in recorded successfully',
                'attendance' => $attendance
            ]);
        }
    }
    public function storeFinger(Request $request)
    {
        $fingerId = $request->query('finger_id');

        $user = User::where('finger_id', $fingerId)->first();

        if (!$user) {
            $existingFingerPrintData = FingerPrintData::first();
            if ($existingFingerPrintData) {
                $existingFingerPrintData->delete();
            }

            FingerPrintData::create([
                'finger_print_id' => $fingerId,
            ]);

            return response()->json(['message' => 'User not found, please contact admin to register your fingerprint.'], 200);
        }

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        $attendance = Absen::where('user_id', $user->id)
            ->where('attendance_date', $currentDate)
            ->first();

        if ($attendance) {
            $this->triggerDataPost($attendance?->user?->identification_number);
            return response()->json(['message' => 'User has already checked in for today'], 200);
        } else {
            $attendance = Absen::create([
                'user_id' => $user->id,
                'attendance_date' => $currentDate,
                'check_in' => $currentTime,
                'status_check_in' => null,
            ]);

            if ($currentTime > '12:00:00') {
                $attendance->status_check_in = 'Late Absen';
            } else {
                $attendance->status_check_in = 'On-time Absen';
            }

            $attendance->save();

            $this->triggerDataPost($attendance?->user?->identification_number);

            return response()->json([
                'message' => 'Absen recorded successfully',
                'attendance' => $attendance
            ]);
        }
    }


    function triggerDataPost($nim)
    {
        $client = new Client();

        $data = [
            'nim' => $nim,
            'datetime' => 1731652446,
        ];

        $apiUrl = 'https://a3b8-212-102-51-99.ngrok-free.app/api/v1/simakad-absen';

        try {
            $client->post($apiUrl, [
                'json' => $data,
                'timeout' => 0,
                'connect_timeout' => 0,
                'http_errors' => false,
            ]);
        } catch (\Exception $e) {
        }
    }
}
