<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CatalogController extends Controller
{
    /**
     * Get current catalog path (API for frontend)
     */
    public function getCatalogPath()
    {
        $path = SiteSetting::getCatalogPath();
        
        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::url($path)
        ]);
    }

    /**
     * Upload new catalog PDF (Admin only)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'catalog' => 'required|file|mimes:pdf|max:51200', // 50MB = 50 * 1024 KB
        ]);

        try {
            // Get old catalog path
            $oldPath = SiteSetting::getCatalogPath();

            // Upload new file to storage/app/public/catalogs/
            $file = $request->file('catalog');
            $filename = 'katalog_' . time() . '.pdf';
            $path = $file->storeAs('catalogs', $filename, 'public');

            // Delete old file if exists and not default
            if ($oldPath && $oldPath !== 'catalogs/katalog_shinta.pdf') {
                Storage::disk('public')->delete($oldPath);
            }

            // Update database
            SiteSetting::setCatalogPath($path);

            return redirect()->back()->with('success', 'Katalog berhasil diupload!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal upload katalog: ' . $e->getMessage());
        }
    }

    /**
     * Get current catalog info for admin dashboard
     */
    public function getInfo()
    {
        $path = SiteSetting::getCatalogPath();
        $fullPath = storage_path('app/public/' . $path);
        
        $info = [
            'exists' => file_exists($fullPath),
            'name' => basename($path),
            'path' => $path,
        ];

        if ($info['exists']) {
            $info['size'] = filesize($fullPath);
            $info['size_formatted'] = $this->formatBytes($info['size']);
            $info['updated_at'] = date('d M Y, H:i', filemtime($fullPath));
        }

        return $info;
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
