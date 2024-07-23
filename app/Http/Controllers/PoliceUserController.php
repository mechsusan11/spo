<?php

namespace App\Http\Controllers;

use App\Models\PoliceUser;
use App\Models\ReportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PoliceUserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function addPoliceUser(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string'],
                'sub_division' => ['required', 'integer'],
                'mobile' => ['required', 'numeric', 'digits_between:8,13'],
                'password' => ['required', 'min:8']
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
            $data['password'] = Hash::make($data['password']);
            $data['ip_address'] = json_encode($request->ips());
            $existinguser = PoliceUser::where('mobile', $request->mobile)->first();
            if (!$existinguser) {
                $user = PoliceUser::create($data);
                return response()->json([
                    "status" => true,
                    "message" => "Police user registered successfully",
                    "police_user" => [$user]
                ], 200);
            }
            return response()->json(['message' => 'Police user already exist'], 200);
        } catch (Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json([
                    'status' => false,
                    'message' => "validation error",
                    'errors' => $errors
                ], 422);
            }
            $credentials = $request->only(['username', 'password']);
            if (!Auth::guard('police_users')->attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => "Username & Password doesn't match"
                ]);
            }

            $user = PoliceUser::where('username', $request->username)->first();
            return response()->json([
                'status' => true,
                'message' => 'Police user successfully logged in',
                'token' => $user->createToken('policeUser-token', expiresAt: now()->addMonth())->plainTextToken,
                "userdata" => [$user]
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
                "token" => "",
                "userdata" => []
            ], 500);
        }
    }

    // web api below
    public function addPoliceUserUi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string'],
            'sub_division' => ['required', 'integer'],
            'mobile' => ['required', 'numeric', 'digits_between:8,13'],
            'password' => ['required', 'min:8']
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['ip_address'] = json_encode($request->ips());
        $existinguser = PoliceUser::where('mobile', $request->mobile)->first();
        if (!$existinguser) {
            $user = PoliceUser::create($data);
            return redirect()->route('admin.dashboard')
                ->with('status', 'Police user registered successfully');
        }
        return redirect()->route('admin.dashboard')
            ->with('status', 'Already a user');
    }

    public function getLoginPage()
    {
        return view('pages.admin');
    }

    public function getAuthenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            dd('validation error');
            return  redirect()
                ->back()
                ->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');
        if (Auth::guard('police_users')->attempt($credentials)) {
            if (Auth::guard('police_users')->user()->role == 'dsp') {
                $user = Auth::guard('police_users')->user();
                // dd(session()->all());
                Auth::loginUsingId(1);
                return redirect()->route('admin.dashboard', compact('user'));
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'You are not authorized to access this page!');
            }
        }
    }

    public function viewDashboard(Request $request)
    {
        $reports = ReportModel::all();
        return view('dashboard.main', compact('reports'));
    }

    public function policeUserList(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $policeUsers = PoliceUser::all();
        if (auth('sanctum')->user()) {
            return response()->json([
                "status" => true,
                "message" => "All police users retrieved successfully",
                "userdata" => [$policeUsers]
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Retrieved failed",
            "userdata" => []
        ]);
    }

    // web api
    public function policeUserById(Request $request, $id)
    {
        $policeUser = PoliceUser::find($id);
        if (auth('sanctum')->user()) {
            return response()->json([
                "status" => true,
                "message" => "police user retrieved for id: $id",
                "userdata" => [$policeUser]
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Retrieved failed",
            "userdata" => []
        ]);
    }

    public function logout()
    {
        Auth::guard('police_users')->logout();
        return redirect()->route('login.admin');
    }
}
