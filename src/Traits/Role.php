<?php

namespace LaraSnap\LaravelAdmin\Traits;

use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Models\Role as RoleModel;

trait Role{
	
	/**
    * A user may have multiple roles | get roles mapped to user.
    */
    public function roles(){
        return $this->belongsToMany(RoleModel::class, 'role_user');
    }
	
	/**
    * A route(screen) can accessed by multiple roles | get roles mapped to route(screens).
    */	
	public function getRequiredRoleForRoute($routename){
		$screenRoles = Screen::where('name', $routename)->has('roles')->first();
		return $screenRoles;
	}

	/**
    * Check if user can access the route(screen).
    */	
	public function hasRole($screen_roles){
	 /* If a screen has not added on the backend for managing the ROLES or if screen doesn't has any role mapped -
	 RESTRICT USERS FROM ACCESSING THE SCREEN*/
		if(!$screen_roles){
			//return true;
			return false;
		}else{
			//Check if user has any of the role mapped to the screen. | User mapped to Role & Screen mapped to Role
			foreach($screen_roles->roles as $role){
				if($this->roles->contains('id', $role->id)){
					return true;
				}
			}
			return false;
		}
	}

	public function assignRole($role){
        return $this->roles()->save(RoleModel::whereId($role)->firstOrFail());
    }
	
	public function getAllRoles(){
		$roles = RoleModel::select('id', 'name', 'label')->get();
        $roles = $roles->pluck('id', 'label');
		
		return $roles;
	}
}


/* hasRole logic
- get all role mapped to the screen
- check if user has that role
*/