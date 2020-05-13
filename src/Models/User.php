<?php

namespace LaraSnap\LaravelAdmin\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use LaraSnap\LaravelAdmin\Traits\Role;
use LaraSnap\LaravelAdmin\Traits\Filter;

class User extends Authenticatable{

	use Role, Filter;

    public function userProfile(){
        return $this->hasOne('LaraSnap\LaravelAdmin\Models\UserProfile');
    }
	
	public function getFullNameAttribute(){
		return $this->userProfile ? ucwords($this->userProfile->first_name.' '.$this->userProfile->last_name) : '- NA -';
	}
	
	public function getStatusInfoAttribute(){
		return $this->status == 1 ? 'Active' : 'InActive';
	}

    public function getAvatarAttribute(){ 
        $folder = config('larasnap.uploads.user.path');
        $userDefAvatar = config('larasnap.uploads.user.default_avatar');     
        $larasnapDefAvatar = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiM3NDVFQzU7fQoJLnN0MXtmaWxsOiNGRkZGRkY7fQo8L3N0eWxlPjxjaXJjbGUgY2xhc3M9InN0MCIgY3g9IjI1NiIgY3k9IjI1NiIgcj0iMjUwIi8+PGc+PGNpcmNsZSBjbGFzcz0ic3QxIiBjeD0iMjU2IiBjeT0iMTk4LjgiIHI9IjUxLjQiLz48cGF0aCBjbGFzcz0ic3QxIiBkPSJNMjk0LjcsMjc1LjFoLTc3LjRjLTI4LjEsMC01MC44LDIyLjctNTAuOCw1MC44djM4LjdoMTc5di0zOC43QzM0NS41LDI5Ny45LDMyMi43LDI3NS4xLDI5NC43LDI3NS4xeiIvPjwvZz48L3N2Zz4=';
        
        $userUploadPathUrl = storageUrl($folder); //fetches based on 'php artisan storage:link'
        
        $isUserDefAvartarExists = file_exists(storage_path() .'/app/' . $folder .'/'. $userDefAvatar);
        
        if($this->userProfile && $this->userProfile->user_photo){
            $avatarUrl = $userUploadPathUrl.'/'.$this->userProfile->user_photo;
        }elseif($isUserDefAvartarExists){
            $avatarUrl = $userUploadPathUrl.'/'.$userDefAvatar;
        }else{
            $avatarUrl = $larasnapDefAvatar;
        }
        
        return $avatarUrl;
    }

    /* public function getAvatarAttribute($value){
          return $value ?? - NA -;
    } */
	
}
