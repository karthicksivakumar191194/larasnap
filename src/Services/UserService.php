<?php

namespace LaraSnap\LaravelAdmin\Services;

use App\User;
use File;
use Illuminate\Support\Facades\Auth;
use LaraSnap\LaravelAdmin\Traits\Upload;
use LaraSnap\LaravelAdmin\Models\UserProfile;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Filters\UserFilters;
use Illuminate\Support\Facades\Storage;

class UserService{
	
	use Upload;

    private $filters;

    /**
     * Injecting UserFilters.
     */
    public function __construct(UserFilters $filters)
    {
        $this->filters = $filters;
    }
	
	public function index($filter_request){
		$entriesPerPage = setting('entries_per_page');

        //filter($filters) - pass only 2nd argument, 1st argument will be automatically injected to dynamic scope.  $filters - Needs to be a child class of \LaraSnap\LaravelAdmin\Filters\Filters
        $users = User::filter($this->filters, $filter_request)->paginate($entriesPerPage);
        //$users = User::filter($this->filters, $filter_request)->toSql(); dd($users);

		return $users;
	}

	// return filter request values
	public function filterValue($request){
		/*filter-array keys should be same as the filter-field name*/

		/*Declare filter variables*/
        $filters['sort_by']     = config('larasnap.module_list.user.sort_by')[0]['value'];
        $filters['user_role']   = 'all';
        $filters['user_status'] = 'all';
        $filters['search']      = null;

		/*If filter has values or if user accessing page via pagination, show filter values*/
		if($request->page || $request->sort_by || $request->user_role || $request->user_status || $request->search){
		    foreach($filters as $filter_key => $filter_def_value) {
                $filters[$filter_key] = $this->filterValueData($request, $filters, $filter_key);
            }
		}else{
		    //flush session values when accessing the page first time.
            foreach($filters as $filter_key => $filter_def_value) {
                $this->deleteFilterSessionData($request, $filter_key);
            }
        }

      /*  print_r($filters);
		var_dump($request->sort_by);
		var_dump($request->user_role);
		var_dump($request->user_status);
		var_dump($request->search); */
		return $filters;
	}
	
	/**
    * @param  request, filter default value, filter field name.
	**/
	public function filterValueData($request, $filters, $filter_type){
	    //check if request is present and not null
        //check if request is present and null - used on 'search'
        //session has value
        //default value
		if($request->filled($filter_type)) {
            $data = $request->{$filter_type};
            session(['user_' . $filter_type => $data]);
        }elseif($request->has($filter_type) && $request->{$filter_type} == '' ){
            session(['user_' . $filter_type => '']);
            $data = $filters[$filter_type];
        }elseif(session('user_'.$filter_type)){
			$data = session('user_'.$filter_type);
		}else{
			$data = $filters[$filter_type];
		}

		return $data;
	}

	public function deleteFilterSessionData($request, $filter_key){
            $request->session()->forget('user_'.$filter_key);
    }

	public function store($request){
		$data = $request->except('password');
        $data['password']   = bcrypt($request->password);
        $data['created_by'] = Auth::id();

        $user   = User::create($data);
		$userId = $user->id;
		$userProfile   = $user->userProfile()->create($data); 
		$userProfileId = $userProfile->id;
		
		/* handle if image uploaded */
		 if ($request->has('user_photo')) {
			$image = $request->file('user_photo');
			$folder = config('larasnap.uploads.user.path');
			
			$imgName = $this->upload($image, $folder, 'user', $userId);
			
			$userProfile  = Userprofile::find($userProfileId);
            $userProfile->user_photo  = $imgName;
            $userProfile->save();
		 }
		 
		/* Set default role as set in settings if registered from frontend. */
		$settingsDefaultRole = setting('default_user_role');
		if(isset($settingsDefaultRole) && !empty($settingsDefaultRole) && $settingsDefaultRole != 0){
			$role = Role::where('id', $settingsDefaultRole)->first();
			if($role){
				$user->assignRole($role->id);
			}
		}
		
		return $user;
	}

    public function update($request, $id, $user, $type = null){
	    /* handle if password updated*/
        if ($request->filled('password')) {
           $userData['password'] = bcrypt($request->password);
        }
        $userData['email'] = $request->email; 
        if(is_null($type)){
            $userData['status'] = $request->status;
        }
	    $user->update($userData);

        /* handle if image uploaded*/
        if ($request->has('user_photo')) {
           $image = $request->file('user_photo');
           $folder = config('larasnap.uploads.user.path');
           if ($user->userProfile && $user->userProfile->user_photo) {
               File::delete(storage_path() .'/app/' .$folder .'/'. $user->userProfile->user_photo);
           }
           $imgName = $this->upload($image, $folder, 'user', $id);
           $userProfileData['user_photo'] = $imgName;
        }
        
        $userProfile = Userprofile::where('user_id', $id)->first();
        
        $userProfileData['first_name'] = $request->first_name;
        $userProfileData['last_name']  = $request->last_name;
        $userProfileData['mobile_no']  = $request->mobile_no;
        $userProfileData['address']    = $request->address;
        $userProfileData['state']      = $request->state;
        $userProfileData['city']       = $request->city;
        $userProfileData['pincode']    = $request->pincode;
        
        if($userProfile){
            $user->userProfile()->update($userProfileData);
        }else{
            //If user is registered from frontend, on edit newly the user profile details.
            $userProfileData['user_id']    = $id;
            $user = Userprofile::create($userProfileData);
        }
        
        return $user;
    }

    public function destroy($id, $user){
        if ($user->userProfile && $user->userProfile->user_photo) {
            $folder = config('larasnap.uploads.user.path');
            File::delete(storage_path() .'/app/' .$folder .'/'. $user->userProfile->user_photo);
        }
        $user = $user->delete();

        return $user;
    }

	public function bulkDelete($idsToDelete){
	    $selectedUsers = User::whereIn('id', $idsToDelete)->get();
	    $imgArray = [];
	    foreach ($selectedUsers as $user){
            if ($user->userProfile && $user->userProfile->user_photo) {
                $folder = config('larasnap.uploads.user.path');
                $img = storage_path() .'/app/' .$folder .'/'. $user->userProfile->user_photo;
                array_push($imgArray, $img);
            }
        }
        File::delete($imgArray);

	    $users = User::whereIn('id', $idsToDelete)->delete();

	    return $users;
    }

    /*public function findOrFail($user_id){
		try {
			$user = User::findOrFail($user_id);
		}catch (ModelNotFoundException $exception) {
			throw new ModelNotFoundException('User not found by ID ' .$user_id);
		}
		
		return $user;
    }*/
	
	
}


/*
 * USER FILTER FLOW - USER CONTROLLER > USER SERVICE > USER MODEL(FILTER TRAIT) > USER FILTER
 * */