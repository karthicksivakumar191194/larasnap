<?php
use LaraSnap\LaravelAdmin\Models\Setting;

/**
 * Helper Desc  : Show image or default image.
 * Helper Info  : Make sure their is a "default" image on the folder on every folder where you upload the images, so the default
                  image will be used if the user does not uploads the image.
 * Helper Usage : imageOrDefault('user.png' , 'user-default-image.png', 'storage/app/public/upload/user/profile')
 * Return       : Image
 */
if (! function_exists('imageOrDefault')) { 
	function imageOrDefault($img_name, $def_img_name, $folder_path, $class = null){
		if(!empty($img_name)){
			$img = $img_name;
		}else{
			$img = $def_img_name;
		}
		$img_src = asset($folder_path).'/'.$img;
		
		return "<a href='$img_src' class='$class' target='_blank'><img src='$img_src'></a>";
	}
}

/**
 * Helper Desc  : Get Setting value.
 * Return       : Setting Value or no value if wrong 'setting name' is passed as argument.
 */
if (! function_exists('setting')) {
    function setting($name){
        return Setting::where('name', $name)->pluck('value')->first();
    }
}

/**
 * Helper Desc  : Get Public Storage Link URL.
 * Return       : Storage Link.
 * Comment      : Run 'php artisan storage:link' which creates a symbolic link, connects "public/storage" to "storage/app/public"
 */
if (! function_exists('storageUrl')) {
    function storageUrl($path){
            return asset(Storage::url($path));
    }
}

/**
 * Helper Desc  : Display Menu.
 */
if (!function_exists('menu')) {
    function menu($menuName, $type = null, $design = null){
        $menu = new LaraSnap\LaravelAdmin\Models\Menu;
		return $menu->display($menuName, $type, $design);
    }
}

/**
 * Helper Desc  : Encrypt Value.
 */
if(!function_exists('larasnapEncrypt')) {
    function larasnapEncrypt($value){
        return base64_encode($value);
    }
}

/**
 * Helper Desc  : Decrypt Value.
 */
if(!function_exists('larasnapDecrypt')) {
    function larasnapDecrypt($value){
        return base64_decode($value);
    }    
}
