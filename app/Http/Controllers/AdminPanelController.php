<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\AdminPanelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * AdminPanelController - Dynamic CRUD controller for all registered resources.
 * Provides listing, create, update, delete, soft delete/restore, bulk actions,
 * inline editing, duplication, import/export, and advanced filtering.
 */
class AdminPanelController extends Controller
{
    /**
     * Dashboard - Advanced statistics overview.
     */
    public function dashboard()
    {
        $resources = AdminPanelService::getResources();
        $stats = [];

        foreach ($resources as $slug => $config) {
            if ($slug === 'activity-log') continue;
            $modelClass = $config['model'];
            $query = $modelClass::query();

            // Count with soft deletes if supported
            $total = $query->count();
            $trashed = 0;
            if (method_exists(new $modelClass, 'trashed') || in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($modelClass))) {
                $trashed = $modelClass::onlyTrashed()->count();
            }

            // Recent (last 7 days)
            $recent = 0;
            if (Schema::hasColumn((new $modelClass)->getTable(), 'created_at')) {
                $recent = $modelClass::where('created_at', '>=', now()->subDays(7))->count();
            }

            $stats[$slug] = [
                'label_ar' => $config['label_ar'],
                'label_en' => $config['label_en'],
                'icon'     => $config['icon'],
                'total'    => $total,
                'trashed'  => $trashed,
                'recent'   => $recent,
            ];
        }

        // Chart data - registrations per day (last 30 days)
        $chartData = DB::table('user')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent activity
        $recentActivity = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        $nav = AdminPanelService::getSidebarNav();

        return view('admin-panel.dashboard', compact('stats', 'chartData', 'recentActivity', 'nav'));
    }

    /**
     * Resource listing with filters, sorting, and pagination.
     */
    public function index(Request $request, string $resource)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $modelClass = $config['model'];
        $pk = $config['primaryKey'];
        $query = $modelClass::query();

        // Include trashed records if requested
        $showTrashed = $request->input('trashed', false);
        if ($showTrashed && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($modelClass))) {
            if ($showTrashed === 'only') {
                $query = $modelClass::onlyTrashed();
            } else {
                $query = $modelClass::withTrashed();
            }
        }

        // Eager load relations for display columns
        $eagerLoad = [];
        foreach ($config['columns'] as $col => $colConfig) {
            if (isset($colConfig['relation'])) {
                $eagerLoad[] = explode('.', $colConfig['relation'])[0];
            }
        }
        if (!empty($eagerLoad)) {
            $query->with(array_unique($eagerLoad));
        }

        // Text search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search, $config) {
                foreach ($config['columns'] as $col => $colConfig) {
                    if (!empty($colConfig['searchable'])) {
                        $q->orWhere($col, 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        // Advanced filters
        if ($filters = $request->input('filters')) {
            foreach ($filters as $field => $value) {
                if (empty($value) && $value !== '0') continue;

                $filterConfig = $config['filters'][$field] ?? null;
                if (!$filterConfig) continue;

                if ($filterConfig['type'] === 'date_range') {
                    if (!empty($value['from'])) {
                        $query->where($field, '>=', $value['from']);
                    }
                    if (!empty($value['to'])) {
                        $query->where($field, '<=', $value['to'] . ' 23:59:59');
                    }
                } elseif ($filterConfig['type'] === 'boolean') {
                    $query->where($field, $value ? 1 : 0);
                } elseif ($filterConfig['type'] === 'relation_select') {
                    $query->where($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }

        // Sorting
        $sortBy = $request->input('sort', $pk);
        $sortDir = $request->input('dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Pagination
        $perPage = $request->input('per_page', 25);
        $records = $query->paginate($perPage)->appends($request->query());

        // Get relation options for filter dropdowns
        $filterOptions = $this->getFilterOptions($config);

        $nav = AdminPanelService::getSidebarNav();

        return view('admin-panel.resource', compact('config', 'resource', 'records', 'nav', 'filterOptions'));
    }

    /**
     * Store a new record.
     */
    public function store(Request $request, string $resource)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config || !empty($config['readonly'])) abort(403);

        $modelClass = $config['model'];
        $data = $request->only(array_keys($config['formFields']));

        // Hash password if present
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $record = $modelClass::create($data);

        // Log activity
        $this->logActivity('create', $modelClass, $record->{$config['primaryKey']}, $this->getRecordLabel($record, $config), null, $data);

        return response()->json(['success' => true, 'message' => 'تم الإنشاء بنجاح', 'record' => $record]);
    }

    /**
     * Update a record (full or inline).
     */
    public function update(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config || !empty($config['readonly'])) abort(403);

        $modelClass = $config['model'];
        $record = $modelClass::findOrFail($id);

        $data = $request->only(array_keys($config['formFields'] ?: $config['columns']));
        $oldValues = $record->only(array_keys($data));

        // Hash password if updated
        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $record->update($data);

        // Log changes
        $changedFields = array_keys(array_diff_assoc($data, $oldValues));
        if (!empty($changedFields)) {
            $this->logActivity('update', $modelClass, $id, $this->getRecordLabel($record, $config), $oldValues, $data, $changedFields);
        }

        return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح', 'record' => $record->fresh()]);
    }

    /**
     * Inline edit a single field.
     */
    public function inlineUpdate(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config || !empty($config['readonly'])) abort(403);

        $field = $request->input('field');
        $value = $request->input('value');

        // Verify the field is editable
        $colConfig = $config['columns'][$field] ?? null;
        if (!$colConfig || empty($colConfig['editable'])) {
            return response()->json(['success' => false, 'message' => 'هذا الحقل غير قابل للتعديل'], 403);
        }

        $modelClass = $config['model'];
        $record = $modelClass::findOrFail($id);
        $oldValue = $record->$field;
        $record->$field = $value;
        $record->save();

        $this->logActivity('update', $modelClass, $id, $this->getRecordLabel($record, $config), [$field => $oldValue], [$field => $value], [$field]);

        return response()->json(['success' => true, 'message' => 'تم التحديث', 'value' => $record->$field]);
    }

    /**
     * Soft delete a record.
     */
    public function destroy(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config || !empty($config['readonly'])) abort(403);

        $modelClass = $config['model'];
        $record = $modelClass::findOrFail($id);
        $label = $this->getRecordLabel($record, $config);

        $record->delete(); // Soft delete if SoftDeletes trait used

        $this->logActivity('delete', $modelClass, $id, $label);

        return response()->json(['success' => true, 'message' => 'تم الحذف بنجاح']);
    }

    /**
     * Restore a soft-deleted record.
     */
    public function restore(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $modelClass = $config['model'];
        $record = $modelClass::onlyTrashed()->findOrFail($id);
        $record->restore();

        $this->logActivity('restore', $modelClass, $id, $this->getRecordLabel($record, $config));

        return response()->json(['success' => true, 'message' => 'تم الاستعادة بنجاح']);
    }

    /**
     * Force delete a record permanently.
     */
    public function forceDelete(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $modelClass = $config['model'];
        $record = $modelClass::withTrashed()->findOrFail($id);
        $label = $this->getRecordLabel($record, $config);

        $record->forceDelete();

        $this->logActivity('force_delete', $modelClass, $id, $label);

        return response()->json(['success' => true, 'message' => 'تم الحذف النهائي']);
    }

    /**
     * Duplicate a record (optionally with relations).
     */
    public function duplicate(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config || !empty($config['readonly'])) abort(403);

        $modelClass = $config['model'];
        $record = $modelClass::findOrFail($id);
        $pk = $config['primaryKey'];

        // Clone main record
        $newRecord = $record->replicate();
        $newRecord->save();

        // Optionally duplicate relations
        if ($request->input('with_relations') && !empty($config['relations'])) {
            foreach ($config['relations'] as $relation) {
                if (method_exists($record, $relation)) {
                    try {
                        $related = $record->$relation;
                        if ($related instanceof \Illuminate\Database\Eloquent\Collection) {
                            foreach ($related as $relItem) {
                                $newRelItem = $relItem->replicate();
                                // Set the foreign key to the new record
                                $foreignKey = $record->$relation()->getForeignKeyName();
                                $newRelItem->$foreignKey = $newRecord->$pk;
                                $newRelItem->save();
                            }
                        }
                    } catch (\Exception $e) {
                        // Skip relations that can't be duplicated
                    }
                }
            }
        }

        $this->logActivity('create', $modelClass, $newRecord->$pk, 'نسخة من: ' . $this->getRecordLabel($record, $config));

        return response()->json(['success' => true, 'message' => 'تم النسخ بنجاح', 'new_id' => $newRecord->$pk]);
    }

    /**
     * Bulk actions: delete, restore, force_delete.
     */
    public function bulkAction(Request $request, string $resource)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $action = $request->input('action');
        $ids = $request->input('ids', []);
        $modelClass = $config['model'];

        $count = 0;
        switch ($action) {
            case 'delete':
                $count = $modelClass::whereIn($config['primaryKey'], $ids)->delete();
                break;
            case 'restore':
                $count = $modelClass::onlyTrashed()->whereIn($config['primaryKey'], $ids)->restore();
                break;
            case 'force_delete':
                $count = $modelClass::withTrashed()->whereIn($config['primaryKey'], $ids)->forceDelete();
                break;
        }

        $this->logActivity($action, $modelClass, null, "إجراء جماعي على {$count} سجل", null, ['ids' => $ids]);

        return response()->json(['success' => true, 'message' => "تم تنفيذ العملية على {$count} سجل"]);
    }

    /**
     * Export records to CSV.
     */
    public function export(Request $request, string $resource)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $modelClass = $config['model'];
        $records = $modelClass::all();

        $columns = array_keys($config['columns']);
        $headerAr = array_column($config['columns'], 'label_ar');

        $csv = implode(',', $headerAr) . "\n";
        foreach ($records as $record) {
            $row = [];
            foreach ($columns as $col) {
                $val = $record->$col ?? '';
                $row[] = '"' . str_replace('"', '""', $val) . '"';
            }
            $csv .= implode(',', $row) . "\n";
        }

        $this->logActivity('export', $modelClass, null, "تصدير {$records->count()} سجل");

        $filename = $resource . '_' . date('Y-m-d_His') . '.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Import records from CSV.
     */
    public function import(Request $request, string $resource)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config || !empty($config['readonly'])) abort(403);

        $request->validate(['file' => 'required|file|mimes:csv,txt|max:5120']);

        $modelClass = $config['model'];
        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());
        $lines = array_filter(explode("\n", $content));

        if (count($lines) < 2) {
            return response()->json(['success' => false, 'message' => 'الملف فارغ'], 422);
        }

        // Skip header row
        $formFields = array_keys($config['formFields']);
        $imported = 0;
        $errors = [];

        for ($i = 1; $i < count($lines); $i++) {
            $values = str_getcsv($lines[$i]);
            if (count($values) < count($formFields)) continue;

            $data = [];
            foreach ($formFields as $index => $field) {
                $data[$field] = $values[$index] ?? null;
            }

            try {
                if (isset($data['password'])) {
                    $data['password'] = bcrypt($data['password']);
                }
                $modelClass::create($data);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "صف {$i}: " . $e->getMessage();
            }
        }

        $this->logActivity('import', $modelClass, null, "استيراد {$imported} سجل");

        return response()->json([
            'success' => true,
            'message' => "تم استيراد {$imported} سجل بنجاح",
            'errors'  => $errors,
        ]);
    }

    /**
     * Get relation options for dropdowns.
     */
    public function getRelationOptions(Request $request, string $resource, string $field)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $formField = $config['formFields'][$field] ?? $config['filters'][$field] ?? null;
        if (!$formField || $formField['type'] !== 'relation_select') abort(404);

        $relatedConfig = AdminPanelService::getResource($formField['relation_model']);
        if (!$relatedConfig) abort(404);

        $relatedModel = $relatedConfig['model'];
        $displayField = $formField['display'] ?? $relatedConfig['primaryKey'];

        $options = $relatedModel::select([$relatedConfig['primaryKey'], $displayField])
            ->orderBy($displayField)
            ->limit(500)
            ->get()
            ->map(fn ($item) => ['id' => $item->{$relatedConfig['primaryKey']}, 'label' => $item->$displayField]);

        return response()->json($options);
    }

    /**
     * Get a single record details (for modals).
     */
    public function show(Request $request, string $resource, $id)
    {
        $config = AdminPanelService::getResource($resource);
        if (!$config) abort(404);

        $modelClass = $config['model'];
        $eagerLoad = $config['relations'] ?? [];
        $record = $modelClass::with($eagerLoad)->findOrFail($id);

        return response()->json(['record' => $record, 'config' => $config]);
    }

    // ─── Private Helpers ──────────────────────────────────────────────

    /**
     * Log an admin panel activity.
     */
    private function logActivity(string $action, string $modelClass, $modelId, string $label, $oldValues = null, $newValues = null, $changedFields = null): void
    {
        ActivityLog::create([
            'user_id'        => session('user_id'),
            'action'         => $action,
            'model_type'     => class_basename($modelClass),
            'model_id'       => $modelId,
            'model_label'    => Str::limit($label, 250),
            'old_values'     => $oldValues ? json_encode($oldValues) : null,
            'new_values'     => $newValues ? json_encode($newValues) : null,
            'changed_fields' => $changedFields ? json_encode($changedFields) : null,
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);
    }

    /**
     * Get a human-readable label for a record.
     */
    private function getRecordLabel($record, array $config): string
    {
        // Try common label fields
        foreach (['full_name', 'name', 'title', 'test_name', 'classes_name', 'topic', 'question_text', 'optione_text', 'email'] as $field) {
            if ($record->$field ?? false) {
                return $record->$field;
            }
        }
        return "#{$record->{$config['primaryKey']}}";
    }

    /**
     * Build filter options for relation-based filters.
     */
    private function getFilterOptions(array $config): array
    {
        $options = [];
        foreach ($config['filters'] as $field => $filterConfig) {
            if ($filterConfig['type'] === 'relation_select') {
                $relatedConfig = AdminPanelService::getResource($filterConfig['relation_model']);
                if ($relatedConfig) {
                    $relatedModel = $relatedConfig['model'];
                    $displayField = $filterConfig['display'] ?? $relatedConfig['primaryKey'];
                    $options[$field] = $relatedModel::select([$relatedConfig['primaryKey'], $displayField])
                        ->orderBy($displayField)
                        ->limit(500)
                        ->get()
                        ->map(fn ($item) => ['id' => $item->{$relatedConfig['primaryKey']}, 'label' => $item->$displayField]);
                }
            }
        }
        return $options;
    }
}
