<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Storage;
use App\UploadedFile;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function handleUpload(Request $request){

        // if($request->hasFile('file')){
            $file = $request->file('file');
            $allowedFileTypes = config('app.allowedFileTypes');
            $maxFileSize = config('app.maxFileSize');
            $rules = [
                'file' => 'required|mimes:'.$allowedFileTypes.'|max:'.$maxFileSize
            ];
            $this->validate($request, $rules);
            $fileName = $file->getClientOriginalName();
            $destinationPath = config('app.fileDestinationPath').'/'.$fileName;
            $uploaded = Storage::put($destinationPath, file_get_contents($file->getRealPath()));

            if($uploaded){
                UploadedFile::create([
                    'filename' => $fileName
                ]);
            }
        // }

        return redirect()->to('/upload');
    }

    public function upload(){
        $directory = config('app.fileDestinationPath');
        // $files = Storage::files($directory);
        $files = UploadedFile::all();
        return view('files.upload')->with(array('files' => $files));
    }

    public function deleteFile($id){
        $file = UploadedFile::find($id);
        Storage::delete(config('app.fileDestinationPath').'/'.$file->filename);
        $file->delete();
        return redirect()->to('/upload');
    }
}
