<?php

namespace Jatdung\DcatVditor\Controllers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VditorController extends Controller
{
    public function upload(Request $request)
    {
        $files = (array)$request->file('file');
        $dir = trim($request->get('dir'), '/');

        $disk = $this->disk();

        $succMap = [];
        foreach ($files as $file) {
            $newName = $this->generateNewName($file);

            $disk->putFileAs($dir, $file, $newName);

            $succMap[$file->getClientOriginalName()] = $disk->url("{$dir}/$newName");
        }

        return [
            'msg'  => "",
            'code' => 0,
            "data" => [
                "errFiles" => [],
                "succMap"  => $succMap
            ]
        ];
    }

    protected function generateNewName(UploadedFile $file)
    {
        return uniqid(md5($file->getClientOriginalName())) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|FilesystemAdapter
     */
    protected function disk()
    {
        $disk = request()->get('disk') ?: config('admin.upload.disk');

        return Storage::disk($disk);
    }
}
