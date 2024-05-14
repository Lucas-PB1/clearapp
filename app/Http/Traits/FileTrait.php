<?php

namespace App\Http\Traits;

use App\Models\CMS\Archives;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

trait FileTrait
{
    protected function isValidExtension(UploadedFile $file, $validExtensions)
    {
        return in_array($file->getClientOriginalExtension(), $validExtensions);
    }

    protected function generateFileName(UploadedFile $file)
    {
        return time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    }


    protected function convertToWebP($filePath, $quality = 80)
    {
        $filePath = 'public/' . $filePath;
        $image = Image::make(Storage::get($filePath));

        if ($image->width() > 2000 || $image->height() > 2000) {
            $image->resize(2000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $webpFilePath = preg_replace('/\.\w+$/', '.webp', $filePath);
        $image->save(Storage::path($webpFilePath), $quality, 'webp');

        $image->destroy();

        return $webpFilePath;
    }

    protected function generateSizes($file, $sizes)
    {
        $imagePaths = [];

        foreach ($sizes as $size) {
            $pathinfo = pathinfo($file);
            $newFilePath = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . "_{$size}." . $pathinfo['extension'];

            Image::make(Storage::get($file))
                ->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(Storage::path($newFilePath));

            $imagePaths[] = $newFilePath;
        }

        return $imagePaths;
    }

    public function uploadFileWithDetails(
        UploadedFile $file,
        $folder,
        $table,
        $referenceId,
        $desc = null,
        $title = null,
        $destaque = false,
        $validExtensions = ['jpeg', 'png', 'jpg', 'gif'],
        $webpQuality = 80,
        $sizes = [200, 400, 800]
    ) {
        if (!$this->isValidExtension($file, $validExtensions))
            return null;

        $fileName = $this->generateFileName($file);
        $filePath = $file->storeAs($folder, $fileName, 'public');

        $webpFilePath = $this->convertToWebP($filePath, $webpQuality);

        $attributes = [
            'desc' => $desc ?? ' ',
            'path' => $webpFilePath,
            'name' => pathinfo($fileName, PATHINFO_FILENAME),
            'title' => $title ?? pathinfo($fileName, PATHINFO_FILENAME),
            'extension' => 'webp',
            'reference_id' => $referenceId,
            'table' => $table,
            'highlight' => $destaque
        ];

        if ($destaque)
            Archives::where('table', $table)->where('reference_id', $referenceId)->delete();

        // Crie o registro na tabela archives
        Archives::create($attributes);

        $imagePaths = $this->generateSizes($webpFilePath, $sizes);

        return [
            'original' => $webpFilePath,
            'sizes' => $imagePaths,
        ];
    }

    public function fileSaveDestaque($request, $id, $name, $table)
    {
        if ($request->hasFile($name)) {
            $file = $request->file($name);
            $this->uploadFileWithDetails($file, "$table/$id/images", $table, $id, 'Imagem de destaque', null, true);
        }
    }

    public function getFile($path)
    {
        return File::get($path);
    }

    /**
     * Cria um arquivo com as informaçẽos que você deseja.
     *
     * @param $path
     * @param $context
     * @return bool
     */
    public function createfile($path, $context): bool
    {
        if ($repository = fopen($path, "a")) {
            fwrite($repository, trim($context));
            fclose($repository);
            return true;
        }
        ;
        return false;
    }
}
