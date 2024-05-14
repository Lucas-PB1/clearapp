<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    public function summernoteFiles(Request $request)
    {
        $files = $request->except('_token');
        $urls = [];

        foreach ($files as $key => $file) {
            $filePath = $this->storeFile($file, $key);
            array_push($urls, $filePath);
        }

        return $urls;
    }

    private function storeFile($file, $key)
    {
        $storagePath = 'summernote-files/temporarios';
        $fileName = $this->generateFileName($file, $key);
        $file->storeAs($storagePath, $fileName, 'public');
        return '/storage/' . $storagePath . '/' . $fileName;
    }

    private function generateFileName($file, $key)
    {
        return "temp-" . time() . $key . '.' . $file->getClientOriginalExtension();
    }

}
