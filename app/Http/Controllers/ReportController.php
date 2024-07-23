<?php

namespace App\Http\Controllers;

use App\Models\AppConfigModel;
use App\Models\NotificationModel;
use App\Models\ReportModel;
use App\Models\SubDivisionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ReportController extends Controller
{
    public function showImage($slug)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $relativePath = "public/uploads/images/" . $slug;
        if (!Storage::exists($relativePath)) {
            abort(404, 'Image not found');
        }
        $image = Storage::get($relativePath);
        $mimeType = Storage::mimeType($relativePath);
        return response($image, 200)->header('Content-Type', $mimeType);
    }

    public function showVideo($slug)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $relativePath = "public/uploads/videos/" . $slug;
        if (!Storage::exists($relativePath)) {
            abort(404, 'Image not found');
        }
        $image = Storage::get($relativePath);
        $mimeType = Storage::mimeType($relativePath);
        return response($image, 200)->header('Content-Type', $mimeType);
    }

    public function showAudio($slug)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $relativePath = "public/uploads/audios/" . $slug;
        if (!Storage::exists($relativePath)) {
            abort(404, 'Image not found');
        }
        $image = Storage::get($relativePath);
        $mimeType = Storage::mimeType($relativePath);
        return response($image, 200)->header('Content-Type', $mimeType);
    }

    public function addReport(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['public'])) {
            abort(403, 'Session expired! please login again.');
        }

        try {
            $validator = Validator::make($request->all(), [
                'report_type' => 'required|integer|exists:report_type_master,id',
                'sub_division' => 'required|string|exists:sub_division_master,id',
                'incident_address' => 'required|string|max:255',
                'current_latitude' => 'nullable|numeric|between:-90,90',
                'current_longitude' => 'nullable|numeric|between:-180,180',
                'incident_latitude' => 'nullable|numeric|between:-90,90',
                'incident_longitude' => 'nullable|numeric|between:-180,180',
                'police_assigned' => 'nullable|string|max:255',
                'report_details' => 'nullable|string',
                'incident_details' => 'nullable|string',
                'incident_date_time' => 'required|date',
                'intel' => 'nullable|boolean',
                'FIR_register' => 'nullable|boolean',
                'FIR_register_number' => 'nullable|string|max:255',
                'accused_arrested' => 'nullable|boolean',
                'property_ceased' => 'nullable|boolean',
                'image_path.*' => 'nullable|file|mimes:jpeg,jpg,png|max:10240', // max 10MB per image
                'audio_path' => 'nullable|file|max:51200', // max 50MB
                'video_path' => 'nullable|file|mimes:mp4,mov,avi|max:81920', // max 80MB
                'investigation_latitude' => 'nullable|numeric|between:-90,90',
                'investigation_longitude' => 'nullable|numeric|between:-180,180'
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $currentDate = (int)Carbon::now()->format('Ymd');

            // Retrieve the latest report for the current date
            $lastReport = ReportModel::where('report_id', 'LIKE', "{$currentDate}%")
                ->orderBy('report_id', 'desc')
                ->first();

            // Determine the next incrementing number
            $nextNumber = $lastReport ? ((int)substr($lastReport->report_id, 8)) + 1 : 1;

            // Combine the date and incrementing number to form the report_id
            $reportId = $currentDate . sprintf('%02d', $nextNumber);

            $data = new ReportModel();
            $data->report_id = $reportId;
            $data->user_id = auth('sanctum')->user()->id;
            $data->report_type = $request->report_type;
            $data->sub_division = $request->sub_division;
            $data->incident_address = $request->incident_address;
            $data->current_latitude = $request->current_latitude;
            $data->current_longitude = $request->current_longitude;
            $data->incident_latitude = $request->incident_latitude;
            $data->incident_longitude = $request->incident_longitude;
            $data->police_assigned = $request->police_assigned;
            $data->report_details = $request->report_details;
            $data->incident_details = $request->incident_details;
            $data->incident_date_time = $request->incident_date_time;
            $data->intel = $request->intel;
            $data->FIR_register = $request->FIR_register;
            $data->FIR_register_number = $request->FIR_register_number;
            $data->accused_arrested = $request->accused_arrested;
            $data->property_ceased = $request->property_ceased;
            $data->investigation_latitude = $request->investigation_latitude;
            $data->investigation_longitude = $request->investigation_longitude;

            if ($request->hasFile('image_path')) {
                $files = $request->file('image_path');
                $imagePath = [];
                foreach ($files as $file) {
                    $filename = $filename = 'image_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('uploads/images', $filename, 'public');
                    $imagePath[] = $filename;
                    // Limit to 3 images
                    if (count($imagePath) >= 3) {
                        break;
                    }
                }
                $data->image_path = json_encode($imagePath);
            }

            if ($request->hasFile('audio_path')) {
                $file = $request->file('audio_path');
                $filename = 'audio_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/audios', $filename, 'public');
                $data->audio_path = $filename;
            }

            if ($request->hasFile('video_path')) {
                $file = $request->file('video_path');
                $filename = 'video_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/videos', $filename, 'public');
                $data->video_path = $filename;
            }

            $message = AppConfigModel::find($id = 1);
            if (auth('sanctum')->user()) {
                $data->save();

                if ($data->save()) {
                    $police_user = DB::table('police_users')
                        ->where('sub_division', $data->sub_division)
                        ->count();
                    if ($police_user != 0) {
                        $notifications = [
                            [
                                'police_id' => 1,
                                'report_id' => $data->id,
                                // 'status' => 1,
                                'notify_type' => 'new_report',
                                'sub_division_id' => 9
                            ],
                            [
                                'police_id' => $police_user->id,
                                'report_id' => $data->id,
                                // 'status' => 1,
                                'notify_type' => 'new_report',
                                'sub_division_id' => $data->sub_division
                            ]
                        ];
                    } else {
                        $notifications = [
                            [
                                'police_id' => 1,
                                'report_id' => $data->id,
                                // 'status' => 1,
                                'notify_type' => 'new_report',
                                'sub_division_id' => 9
                            ]
                        ];
                    }
                    NotificationModel::insert($notifications);
                    return response()->json([
                        "status" => true,
                        "message" => $message->success_message
                    ], 200);
                }
            }
            return response()->json([
                "status" => false,
                "message" => "Report not saved, attempt failed!"
            ], 400);
        } catch (Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function reportById(Request $request, $id)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $police_id = $user->id;
        $deleted = NotificationModel::where('police_id', $police_id)
            ->where('report_id', $id)
            ->delete();

        // $report = ReportModel::find($id);
        $report = ReportModel::with(['reportType', 'subDivision'])->find($id);
        if ($report) {
            $imagePaths = json_decode($report->image_path, true);
            if (is_array($imagePaths)) {
                $fullImagePaths = array_map(function ($path) {
                    return 'api/image-file/' . $path;
                }, $imagePaths);
                $report->image_path = $fullImagePaths;
            }
            $report->image_path = $fullImagePaths;
            $report->audio_path = 'api/audio-file/' . $report->audio_path;
            $report->video_path = 'api/video-file/' . $report->video_path;
        }
        if (auth('sanctum')->user()) {
            return response()->json([
                'status' => true,
                'message' => 'successfully retrieved and deleted the respective row in notififcation table' . $deleted,
                'data' => $report
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Retrieval failed',
            'data' => $report
        ], 402);
    }


    public function dashboardCount(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        // Get filter parameters from the request
        $filterType = $request->query('filterType');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Initialize the query
        $query = ReportModel::query();

        if ($user->role == 'sp') {
            $query = ReportModel::with(['reportType', 'subDivision'])
                ->where('sub_division_mismatch', 0)
                ->orderBy('report_id', 'desc');
        }

        $query = ReportModel::with(['reportType', 'subDivision'])
            ->where('sub_division', $user->sub_division)
            ->where('sub_division_mismatch', 0)
            ->orderBy('report_id', 'desc');

        if ($filterType) {
            // Apply filters if they are present
            switch ($filterType) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;

                case 'this_week':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    break;

                case 'last_week':
                    $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
                    $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();
                    $query->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek]);
                    break;

                case 'this_month':
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();
                    $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                    break;

                case 'last_month':
                    $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
                    $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
                    $query->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
                    break;

                case 'custom':
                    if ($startDate && $endDate) {
                        $startDate = Carbon::parse($startDate)->startOfDay();
                        $endDate = Carbon::parse($endDate)->endOfDay();
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    } else {
                        return response()->json(['error' => 'Invalid or missing date parameters for custom filter'], 400);
                    }
                    break;

                default:
                    // If no valid filter type is provided, return an error
                    return response()->json(['error' => 'Invalid filter type'], 400);
            }
        }

        // Total filtered report count
        $totalFilteredReportCount = $query->count();

        // Open report count (where 'intel' is null)
        $openReportCount = (clone $query)->whereNull('intel')->count();

        // Closed report count (where 'intel' is 0 or 1)
        $closeReportCount = (clone $query)->whereIn('intel', [0, 1])->count();

        $totalReportCount = ReportModel::all()->count();

        if ($query) {
            return response()->json([
                "status" => true,
                "data" => [
                    "total_filtered_report_count" => $totalFilteredReportCount,
                    "open_report_count" => $openReportCount,
                    "closed_report_count" => $closeReportCount,
                    "total_report_count" => $totalReportCount
                ]
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "data" => []
            ], 404);
        }
    }

    public function reportList(Request $request)
    {
        // Authenticate user and check roles
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        // Get filter type, date parameters, and pagination parameters from the request
        $filterType = $request->query('filterType');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $limit = $request->query('limit', 10); // Default limit to 10 if not provided
        $page = $request->query('page', 1); // Default page to 1 if not provided
        $report_type = $request->query('report_type');
        $sub_division = $request->query('sub_division');
        $FIR_register = $request->query('FIR_register');
        $accused_arrested = $request->query('accused_arrested');
        $property_ceased = $request->query('property_ceased');
        $intel = $request->query('intel');
        $offset = ($page - 1) * $limit;

        // Initialize reports query with relationships and initial conditions
        // if (ReportModel::where('sub_division', $user->sub_division)) {
        //     dd(ReportModel::where('sub_division', $user->sub_division));
        // }
        if ($user->role == 'sp') {
            $reportsQuery = ReportModel::with(['reportType', 'subDivision'])
                ->where('sub_division_mismatch', 0)
                ->orderBy('report_id', 'desc');
        }

        $reportsQuery = ReportModel::with(['reportType', 'subDivision'])
            ->where('sub_division', $user->sub_division)
            ->where('sub_division_mismatch', 0)
            ->orderBy('report_id', 'desc');

        // dd($reportsQuery->count());

        // Apply date filters based on filter type
        if ($filterType) {
            switch ($filterType) {
                case 'today':
                    $reportsQuery->whereDate('created_at', Carbon::today());
                    break;

                case 'this_week':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $reportsQuery->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    break;

                case 'last_week':
                    $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
                    $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();
                    $reportsQuery->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek]);
                    break;

                case 'this_month':
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();
                    $reportsQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                    break;

                case 'last_month':
                    $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
                    $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
                    $reportsQuery->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
                    break;

                case 'custom':
                    if ($startDate && $endDate) {
                        $startDate = Carbon::parse($startDate)->startOfDay();
                        $endDate = Carbon::parse($endDate)->endOfDay();
                        $reportsQuery->whereBetween('created_at', [$startDate, $endDate]);
                    } else {
                        return response()->json(['error' => 'Invalid or missing date parameters for custom filter'], 400);
                    }
                    break;

                default:
                    // If no valid filter type is provided, return an error
                    return response()->json(['error' => 'Invalid filter type'], 400);
            }
        }

        if ($report_type) {
            $reportsQuery->where('report_type', $report_type);
        }

        if ($sub_division) {
            $reportsQuery->where('sub_division', $sub_division);
        }

        if ($FIR_register) {
            $reportsQuery->where('FIR_register', $FIR_register);
        }

        if ($accused_arrested) {
            $reportsQuery->where('accused_arrested', $accused_arrested);
        }

        if ($property_ceased) {
            $reportsQuery->where('property_ceased', $property_ceased);
        }

        if ($intel == 'null') {
            $reportsQuery->whereNull('intel');
        }
        if ($intel == 'closed') {
            $reportsQuery->whereIn('intel', [0, 1]);
        }

        // Get the total count of filtered reports before applying limit and offset
        $totalFilteredReportCount = $reportsQuery->count();

        // Apply limit and offset for pagination
        $reports = $reportsQuery->skip($offset)->take($limit)->get();

        // Get police_id
        $police_id = $user->id;

        // Mark new and updated reports
        $reports = $reports->map(function ($report) use ($police_id) {
            $report->new_report = 0;
            $report->updated_report = 0;
            $new = NotificationModel::where('police_id', $police_id)
                ->where('report_id', $report->id)->where('notify_type', 'new_report')->count();
            $update = NotificationModel::where('police_id', $police_id)
                ->where('report_id', $report->id)->where('notify_type', 'updated_report')->count();
            if ($new != 0) {
                $report->new_report = 1;
            }
            if ($update != 0) {
                $report->updated_report = 1;
            }
            return $report;
        });

        // Calculate total pages
        $totalPages = ceil($totalFilteredReportCount / $limit);

        // Return the response
        return response()->json([
            'status' => true,
            'message' => 'Successfully listed all the reports',
            'data' => $reports,
            'total_pages' => $totalPages,
            'total_count' => $totalFilteredReportCount,
            // 'current_page' => $page
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $updateStatus = ReportModel::find($id);
        $police_id = auth('sanctum')->user()->id;

        $deleted = NotificationModel::where('police_id', $police_id)
            ->where('report_id', $id)
            ->delete();
        // dd($police_id);

        if ($request->has('report_details')) {
            $updateStatus->report_details = $request->report_details;
        }
        if ($request->has('police_assigned')) {
            $updateStatus->police_assigned = $request->police_assigned;
        }
        if ($request->has('intel')) {
            $updateStatus->intel = $request->intel;
        }
        if ($request->has('FIR_register')) {
            $updateStatus->FIR_register = $request->FIR_register;
        }
        if ($request->has('FIR_register_number')) {
            $updateStatus->FIR_register_number = $request->FIR_register_number;
        }
        if ($request->has('accused_arrested')) {
            $updateStatus->accused_arrested = $request->accused_arrested;
        }
        if ($request->has('property_ceased')) {
            $updateStatus->property_ceased = $request->property_ceased;
        }
        if ($request->has('sub_division_mismatch')) {
            $updateStatus->sub_division_mismatch = $request->sub_division_mismatch;
        }
        if ($request->has('investigation_details')) {
            $updateStatus->investigation_details = $request->investigation_details;
        }
        if ($request->has('investigation_latitude')) {
            $updateStatus->investigation_latitude = $request->investigation_latitude;
        }
        if ($request->has('investigation_longitude')) {
            $updateStatus->investigation_longitude = $request->investigation_longitude;
        }
        //dd($request->hasFile('police_image_path'));
        if ($request->hasFile('investigation_image_path')) {
            $files = $request->file('investigation_image_path');
            $imagePath = [];
            foreach ($files as $file) {
                $filename = 'image_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('police_uploads/images', $filename, 'public');
                $imagePath[] = $filename;
                // Limit to 3 images
                if (count($imagePath) >= 3) {
                    break;
                }
            }
            $updateStatus->investigation_image_path = json_encode($imagePath);
        }

        if ($request->hasFile('investigation_video_path')) {
            $file = $request->file('investigation_video_path');
            $filename = 'video_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('police_uploads/videos', $filename, 'public');
            $updateStatus->investigation_video_path = $filename;
        }

        $message = AppConfigModel::find($id = 2);
        if (auth('sanctum')->user()) {
            if ($updateStatus->investigation_date_time == null) {
                $updateStatus->investigation_date_time = now();
            }
            $updateStatus->save();
            if ($updateStatus->save()) {
                $notifications = [
                    [
                        'police_id' => $police_id,
                        'report_id' => $updateStatus->id,
                        // 'status' => 1,
                        'notify_type' => 'updated_report',
                        'sub_division_id' => $updateStatus->sub_division
                    ]
                ];
                NotificationModel::insert($notifications);
                return response()->json([
                    "status" => true,
                    "message" => $message->success_message . " and deleted update notification row"
                ], 200);
            }

            return response()->json([
                "status" => false,
                "message" => "Report not updated, attempt failed!"
            ], 500);
        }
    }

    public function getAppConfigMessage()
    {
        $messages = AppConfigModel::all();
        return view('pages.appConfig', compact('messages'));
    }

    public function showReport(Request $request, $id)
    {
        $report = ReportModel::with(['reportType', 'subDivision'])->find($id);
        if ($report) {
            $imagePaths = json_decode($report->image_path, true);
            if (is_array($imagePaths)) {
                $fullImagePaths = array_map(function ($path) {
                    return $path;
                }, $imagePaths);
                $report->image_path = $fullImagePaths;
            }
            $report->image_path = $fullImagePaths;
            $report->audio_path = $report->audio_path;
            $report->video_path = $report->video_path;
        }
        return view('pages.reportView', compact('report'));
    }

    public function getSubDivMismatchList()
    {
        $reports = ReportModel::where('sub_division_mismatch', 1)->get();
        return view('pages.subDivMismatch', compact('reports'));
    }

    public function getSubDivMismatchView($id)
    {
        $report = ReportModel::findorfail($id);
        $subDivisions = SubDivisionModel::all();
        return view('pages.subDivMismatchView', compact('report', 'subDivisions'));
    }

    public function updateSubDivision(Request $request)
    {
        $reportId = $request->input('report_id');
        $subDivisionId = $request->input('sub_division');

        $report = ReportModel::find($reportId);
        if ($report) {
            $report->sub_division = $subDivisionId;
            $report->sub_division_mismatch = 0; // Assuming this is the desired behavior
            $report->save();
            return redirect()->route('reports.subdivmismatchlist')->with('success', 'Sub Division updated successfully.');
        }
        return redirect()->back()->with('error', 'Report not found.');
    }

    public function updatePoliceAssets(Request $request, $id)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, ['sp', 'dsp'])) {
            abort(403, 'Session expired! please login again.');
        }

        $updateStatus = ReportModel::find($id);

        if ($request->hasFile('investigation_image_path')) {
            $files = $request->file('investigation_image_path');
            $imagePath = [];
            foreach ($files as $file) {
                $filename = 'image_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('police_uploads/images', $filename, 'public');
                $imagePath[] = $filename;
                // Limit to 3 images
                if (count($imagePath) >= 3) {
                    break;
                }
            }
            $updateStatus->investigation_image_path = json_encode($imagePath);
        }

        if ($request->hasFile('investigation_video_path')) {
            $file = $request->file('investigation_video_path');
            $filename = 'video_' . time() . '_' . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('police_uploads/videos', $filename, 'public');
            $updateStatus->investigation_video_path = $filename;
        }

        // dd($updateStatus);
        $updateStatus->save();
        if ($updateStatus) {
            return response()->json([
                'status' => true,
                'data' => [$updateStatus]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => []
            ]);
        }
    }
}
