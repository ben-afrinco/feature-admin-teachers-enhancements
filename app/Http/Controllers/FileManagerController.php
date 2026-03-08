<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\AdminPanelService;

/**
 * FileManagerController - File management with upload, preview, and organization.
 */
class FileManagerController extends Controller
{
    /**
     * Show file manager interface.
     */
    public function index(Request $request)
    {
        $nav = AdminPanelService::getSidebarNav();
        $path = $request->input('path', '');
        $disk = 'public';

        $directories = Storage::disk($disk)->directories($path);
        $files = Storage::disk($disk)->files($path);

        $items = [];

        foreach ($directories as $dir) {
            $items[] = [
                'name'      => basename($dir),
                'path'      => $dir,
                'type'      => 'directory',
                'size'      => null,
                'modified'  => Storage::disk($disk)->lastModified($dir),
                'url'       => null,
            ];
        }

        foreach ($files as $file) {
            $items[] = [
                'name'      => basename($file),
                'path'      => $file,
                'type'      => 'file',
                'extension' => pathinfo($file, PATHINFO_EXTENSION),
                'size'      => Storage::disk($disk)->size($file),
                'modified'  => Storage::disk($disk)->lastModified($file),
                'url'       => Storage::disk($disk)->url($file),
                'mime'      => $this->getMimeType(pathinfo($file, PATHINFO_EXTENSION)),
            ];
        }

        // Build breadcrumbs
        $breadcrumbs = [];
        if ($path) {
            $parts = explode('/', $path);
            $current = '';
            foreach ($parts as $part) {
                $current .= ($current ? '/' : '') . $part;
                $breadcrumbs[] = ['name' => $part, 'path' => $current];
            }
        }

        return view('admin-panel.file-manager', compact('nav', 'items', 'path', 'breadcrumbs'));
    }

    /**
     * Upload files.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'files'   => 'required|array',
            'files.*' => 'file|max:20480',
            'path'    => 'nullable|string',
        ]);

        $path = $request->input('path', '');
        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $stored = $file->storeAs($path, $name, 'public');
            $uploaded[] = $stored;
        }

        return response()->json(['success' => true, 'message' => 'تم الرفع بنجاح', 'files' => $uploaded]);
    }

    /**
     * Create a new directory.
     */
    public function createDirectory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100', 'path' => 'nullable|string']);

        $fullPath = ($request->path ? $request->path . '/' : '') . Str::slug($request->name);
        Storage::disk('public')->makeDirectory($fullPath);

        return response()->json(['success' => true, 'message' => 'تم إنشاء المجلد']);
    }

    /**
     * Delete a file or directory.
     */
    public function delete(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $path = $request->path;
        $disk = 'public';

        if (Storage::disk($disk)->exists($path)) {
            if (Str::endsWith($path, '/') || Storage::disk($disk)->directories($path)) {
                Storage::disk($disk)->deleteDirectory($path);
            } else {
                Storage::disk($disk)->delete($path);
            }
            return response()->json(['success' => true, 'message' => 'تم الحذف']);
        }

        // Try as directory
        Storage::disk($disk)->deleteDirectory($path);
        return response()->json(['success' => true, 'message' => 'تم الحذف']);
    }

    /**
     * Rename file or directory.
     */
    public function rename(Request $request)
    {
        $request->validate(['old_path' => 'required|string', 'new_name' => 'required|string|max:100']);

        $dir = dirname($request->old_path);
        $ext = pathinfo($request->old_path, PATHINFO_EXTENSION);
        $newName = Str::slug($request->new_name) . ($ext ? '.' . $ext : '');
        $newPath = ($dir !== '.' ? $dir . '/' : '') . $newName;

        Storage::disk('public')->move($request->old_path, $newPath);

        return response()->json(['success' => true, 'message' => 'تم إعادة التسمية', 'new_path' => $newPath]);
    }

    /**
     * Determine MIME type from extension for preview support.
     */
    private function getMimeType(string $ext): string
    {
        $map = [
            'jpg' => 'image', 'jpeg' => 'image', 'png' => 'image', 'gif' => 'image', 'svg' => 'image', 'webp' => 'image',
            'mp4' => 'video', 'webm' => 'video', 'ogg' => 'video',
            'mp3' => 'audio', 'wav' => 'audio', 'aac' => 'audio',
            'pdf' => 'pdf',
            'doc' => 'document', 'docx' => 'document', 'xls' => 'document', 'xlsx' => 'document',
            'csv' => 'text', 'txt' => 'text', 'json' => 'text', 'xml' => 'text',
        ];
        return $map[strtolower($ext)] ?? 'other';
    }
}
