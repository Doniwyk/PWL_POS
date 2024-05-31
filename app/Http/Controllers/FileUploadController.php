<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    public function fileUpload()
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        $request->validate([
            'berkas' => 'required|file|image|max:500',
            'filename' => 'required|string' // Validate the filename input as a required string
        ]);

        $originalName = $request->berkas->getClientOriginalName();
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);

        // Use the custom filename from the input, and append the original file extension
        $customFileName = $request->input('filename') . '.' . $extension;

        $path = $request->berkas->move('gambar', $customFileName);
        $path = str_replace("\\", "/", $path); // Ensure the path uses forward slashes


        $pathBaru = asset('gambar/' . $customFileName);
        echo "Gambar berhasil di upload ke <a href='$pathBaru'>$customFileName</a>";
        echo "<br>";
        echo "<img src='$pathBaru' alt='Uploaded Image'>";
    }
}
