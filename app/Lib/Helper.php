<?php

namespace App\Lib;
use Intervention\Image\Facades\Image;
/**
*
*/
class Helper
{

	public static function checkExtensionImageBase64($imgdata){
		 $f = finfo_open();
		 $imagetype = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
		 return '.jpg';
	}
	public static function uploadPhoto($foto, $path, $resize=1000, $name=null) {
			// kalo ada foto
			$decoded = base64_decode($foto);
			// cek extension
			$ext = Helper::checkExtensionImageBase64($decoded);
			// set picture name
			if($name != null)
				$pictName = $name.$ext;
			else
				$pictName = uniqid().''.time().''.$ext;
			// path
			$upload = $path.$pictName;
			$img    = Image::make($decoded);
			$width  = $img->width();
			$height = $img->height();
			if($width > 1000){
					$img->resize(1000, null, function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
					});
			}
			$img->resize($resize, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			if ($img->save($upload)) {
					$result = [
						'status' => 'success',
						'path'  => $upload,
						'image_name' => $pictName
					];
			}
			else {
				$result = [
					'status' => 'fail'
				];
			}
			return $result;
	}
}
