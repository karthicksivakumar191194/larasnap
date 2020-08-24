<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaraSnap\LaravelAdmin\Models\Setting;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Requests\SettingRequest;
use LaraSnap\LaravelAdmin\Services\SettingService;

class SiteSettingController extends Controller
{
    private $settingService;

    /**
     * Injecting UserService.
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }
    /**
     * Show the form for adding/editing the settings.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        setCurrentListPageURL('settings');
        $settings = Setting::all();

        $setting_db_values = [];
        foreach ($settings as $setting){
            $setting_db_values[$setting->name] = $setting->value;
        }
        
        $roles = Role::select('id', 'label')->get();

        return view('larasnap::settings.create', compact('setting_db_values', 'roles'));
    }
	
	 /**
     * Store/Update the settings in the storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SettingRequest $request)
    {
	    $settingNames            = config('larasnap.site_settings');
	    $settingAttachementNames = config('larasnap.site_settings_attachemnt');

	    //if 'site_settings_attachemnt' not defined in config file, set array empty
        if(!isset($settingAttachementNames)){
            $settingAttachementNames = [];
        }

	    if(isset($settingNames) && !empty($settingNames)){
	        foreach ($settingNames as $name){
	            //dynamically applying PHP object property name
                if(in_array ($name, $settingAttachementNames)){
                    $this->settingService->storeAttachement($name, $request->{$name}, $request);
                }else {
                    $this->settingService->store($name, $request->{$name});
                }
            }

            return redirect()->route('settings.create')->withSuccess('Settings successfully updated.');
        }else{
	        //site_setting value is empty or not defined
            return redirect()->route('settings.create')->withError('Before proceeding, please add the settings name to the config file.');
        }

	}
}
