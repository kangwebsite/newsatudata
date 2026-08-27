<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileServices {

    public static function getSize($file)
    {
        $size = Storage::size($file);

        if ($size >= 1024 * 1024) {
            $size = round($size / 1024 / 1024, 2) . ' MB';
        } elseif ($size >= 1024) {
            $size = round($size / 1024, 2) . ' KB';
        } else {
            $size .= ' B';
        }

        return $size;
    }

    public static function getIcon(string $extension)
    {
        if (in_array($extension, ['XLSX', 'XLS'])) {
            $icon = 'ph ph-file-xls';
        }else if (in_array($extension, ['CSV'])) {
            $icon = 'ph ph-file-csv';
        }else if (in_array($extension, ['PDF'])) {
            $icon = 'ph ph-file-pdf';
        }else{
            $icon = 'ph ph-file-text';
        }

        return $icon;
    }
    
}