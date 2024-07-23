<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function addUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'numeric', 'digits_between:8,15'],
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json([
                    'status' => false,
                    'message' => "validation error",
                    'errors' => $errors
                ], 422);
            }

            $data = $request->all();
            $data['ip_address'] = json_encode($request->ips());

            $existingUser = User::where('mobile', $request->mobile)->first();
            if (!$existingUser) {
                $user = User::create($data);
            }

            $user = User::where('mobile', $request->mobile)->first();
            if ($user->OTP_counter > 3 && $user->last_OTP_date_time->diffInHours(now()) < 8) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP limit exceeded. Try after sometime.'
                ], 400);
            }

            //write OTP sending code below
            $otp = 111111;
            $user->OTP = $otp;
            $user->save();
            //OTP sending code ends

            return response()->json(['status' => true, 'message' => 'OTP sent successfully'], 200);
        } catch (Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                "status" => true,
                "message" => "User logged out successfully"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid token",
            ]);
        }
    }

    public function OTPVerify(Request $request)
    {
        $rules = [
            'otp' => 'required|numeric',
            'mobile' => 'required|digits:10'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $clientOtp = $request->otp;
        $clientMobile = $request->mobile;
        $user = User::where('mobile', $clientMobile)->first();

        if ($user) {
            $otp = $user->OTP;
            $mobile = $user->mobile;
        } else {
            return response()->json(['status' => false, 'message' => 'Mobile number not found'], 404);
        }

        if ($otp == $clientOtp && $mobile == $clientMobile) {
            $user->OTP_counter = 0;
            $user->last_OTP_date_time = null;
            $user->OTP = null;
            $user->save();
            $user_detail = [
                'id' => $user->id,
                'mobile' => $user->mobile,
                'name' => $user->name
            ];
            return response()->json([
                "status" => true,
                "message" => "OTP verified successfully",
                "token" => $user->createToken('user-token', expiresAt: now()->addMonth())->plainTextToken,
                "userdata" => $user_detail
            ], 200);
        } else {
            if ($user->OTP_counter == 0) {
                $user->last_OTP_date_time = now();
            }
            $user->increment('OTP_counter');
            $user->save();
            return response()->json(['status' => false, 'message' => "Invalid OTP"], 400);
        }
    }
}
