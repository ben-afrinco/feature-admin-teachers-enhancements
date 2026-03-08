<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('model_label', 'like', "%{$search}%")
                  ->orWhere('model_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->get('per_page', 20);
        $logs = $query->paginate($perPage)->withQueryString();

        // Get unique fields for filters
        $modelTypes = ActivityLog::distinct()->pluck('model_type')->filter()->values();
        $actions = ActivityLog::distinct()->pluck('action')->filter()->values();

        return view('admin-panel.activity-log', compact('logs', 'modelTypes', 'actions'));
    }

    /**
     * Display the specified activity log (for AJAX/Modal).
     */
    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        
        // Prepare diff arrays if both old and new values exist
        $diff = [];
        if ($log->old_values && $log->new_values) {
            foreach ($log->new_values as $key => $newValue) {
                $oldValue = $log->old_values[$key] ?? null;
                if ($oldValue !== $newValue) {
                    $diff[$key] = [
                        'old' => $oldValue,
                        'new' => $newValue
                    ];
                }
            }
        }

        return response()->json([
            'log' => $log,
            'diff' => $diff
        ]);
    }
}
