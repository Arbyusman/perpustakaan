<?php

namespace App\Http\Controllers;

use App\Models\FingerPrintData;
use App\Models\User;
use Illuminate\Http\Request;

class FingerPrintDataController extends Controller
{
    public function CreateFingerPrint(Request $request)
    {
        $validatedData = $request->validate([
            'finger_print_id' => 'required|string|max:255',
        ]);

        $existingFingerPrintData = FingerPrintData::first();

        if ($existingFingerPrintData) {
            $existingFingerPrintData->delete();
        }

        // return response()->json($request);
        // echo($request);

        FingerPrintData::create([
            'finger_print_id' => $validatedData['finger_print_id'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Biodata and fingerprint saved successfully!',
        ]);
    }
    public function GetFingerPrint(Request $request)
    {
        $fingerPrint = FingerPrintData::first();
        if (empty($fingerPrint)) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user = User::where('finger_id', $fingerPrint->finger_print_id)->first();
        if (!$user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Biodata and fingerprint saved successfully!',
                'data' => $fingerPrint->finger_print_id,
            ], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
