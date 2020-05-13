<?php

namespace LaraSnap\LaravelAdmin\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait Upload
{
    public function upload(UploadedFile $uploadedFile, $folder, $prefix = null, $id = null){
		$fileExtn = $uploadedFile->getClientOriginalExtension();
		if(!is_null($prefix) && !is_null($id)){
			$name = $prefix.'_'.$id;
		}else{
			$name = Str::random(25);
		}
		$filename = $name.'.'.$fileExtn;
		
		$uploadedFile->storeAs($folder, $filename);
		
		return $filename;
    }
}