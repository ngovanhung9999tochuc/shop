<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait StorageImageTrait
{

    public function storageTraitUpload($request, $fileName, $foderName,$product_id)
    {

        if ($request->hasFile($fileName)) {
            $file = $request->$fileName;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $filePath = $request->file($fileName)->storeAs('public/' . $foderName . '/' . $product_id, $fileNameHash);
            return [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($filePath)
            ];
        }
        return null;
    }

    public function storageTraitUploadMutiple($file, $foderName,$product_id)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/' . $foderName . '/' . $product_id, $fileNameHash);
        return [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($filePath)
        ];
    }
}
