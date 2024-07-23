<?php

namespace App\Http\Controllers;

use App\Models\SubDivisionModel;
use Illuminate\Http\Request;

class SubDivisionController extends Controller
{
    public function getSubDivisions()
    {
        // dd(Auth::police_users());
        $sub_divisions = SubDivisionModel::orderBy('order', 'asc')->get();
        return view('pages.subDivision', compact('sub_divisions'));
    }
    public function sub_divisions()
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['public', 'sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }
        $sub_divisions = SubDivisionModel::orderBy('order', 'asc')->get();

        if (auth('sanctum')->user()) {
            return response()->json([
                "status" => true,
                "message" => "Successfully retrieved sub divisions",
                "data" => $sub_divisions
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Retrieval failed",
            "data" => []
        ]);
    }
    public function addSubdivisions(Request $request)
    {
        $token = $request->session()->token();
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $subdivision = SubDivisionModel::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subdivision added successfully!',
            'data' => $subdivision,
            '_token' => $token
        ], 201);
    }
}
