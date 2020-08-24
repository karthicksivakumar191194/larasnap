<?php
use LaraSnap\LaravelAdmin\Models\Setting;
use LaraSnap\LaravelAdmin\Models\Category;

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

/**
 * Helper Desc  : Get Categories By Parent Category Slug.
 * Param1       : Parent Category Slug - Required
 * Param2       : Order By Column - Optional | Default - Label
 * Param3       : Order By Direction - Optional | Default - Asc
 * Return       : List of categories based on parent slug & arguments passed or null.
 */
if (!function_exists('getCategoriesByParentCategory')) {
    function getCategoriesByParentCategory($parentCategorySlug, $orderByColumn = 'label', $orderByDirection = 'asc'){
        $parentCategory = Category::where([['name', '=', $parentCategorySlug], ['is_parent', '=', 1], ['status', '=', 1]])
                    ->whereHas('childCategory', function ($q) use ($orderByColumn, $orderByDirection){
                            $q->where('status', 1)->orderBy($orderByColumn, $orderByDirection);
                      })
                    ->with('childCategory')  
                    ->first();
        return $parentCategory ? $parentCategory->childCategory : null;          
    }
}

/**
 * Helper Desc  : Check if user has role.
 * Param        : Role Name - Required
 */
if (!function_exists('userHasRole')) {
    function userHasRole($roleName){
        return auth()->user()->roles->contains('name', $roleName);
    }
}

/**
 * Helper Desc  : Set current list page URL in session.
 * Helper Info  : Make sure the 'param' passed here & on the 'getPreviousListPageURL' helper are same.
 * Usage        : Index - Method
 */
if (!function_exists('setCurrentListPageURL')) {
    function setCurrentListPageURL($module){
        $url = url()->full();
        //remove previously added 'list page' URL from session(from any module).
        app('request')->session()->forget('list_page');
        //add current 'list page' URL to session.
        app('request')->session()->put('list_page.'.$module, $url); 
    }
}

/**
 * Helper Desc  : Set current list page URL in session. 
 * Helper Info  : Make sure the 'param' passed here & on the 'setCurrentListPageURL' helper are same.
 * Usage        : Update - Method
 */
if (!function_exists('getPreviousListPageURL')) {
    function getPreviousListPageURL($module){
        //get previous added 'list page' URL from session.
        $prevPageURL = app('request')->session()->get('list_page.'.$module);
        
        return $prevPageURL;
    }
}

/**
 * Helper Desc  : Restrict data to prevent from accessing/deleting from backend.  - On development
 * Param1       : Module name. Module name should be added to config(larasnap.restrict) - Required
 * Param2       : Data name to restrict - Required
 */
if (!function_exists('restrictData')) {
    function restrictData($module, $name){
        $restrict = config('larasnap.restrict');
        if(isset($restrict) && !empty($restrict) && isset($restrict[$module]) && !empty($restrict[$module])){ 
			if(in_array($name, $restrict[$module])){
				return true;
			}
		}
		return false; 
    }
}