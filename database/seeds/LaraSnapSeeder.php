<?php

use Illuminate\Database\Seeder;
use LaraSnap\LaravelAdmin\Models\User;
use LaraSnap\LaravelAdmin\Models\UserProfile;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Models\RoleScreen;
use LaraSnap\LaravelAdmin\Models\Menu;
use LaraSnap\LaravelAdmin\Models\MenuItem;
use LaraSnap\LaravelAdmin\Models\Setting;

class LaraSnapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User Seed 
        $user = User::where('email', 'admin@admin.com')->first();
        if(!$user){
            $user = new User;
            $user->email = 'admin@admin.com';
            $user->password = bcrypt('password');
            $user->status = 1;
            $user->created_by = 0;
            $user->save();
            
            $userProfile = new UserProfile;
            $userProfile->first_name = 'Super';
            $userProfile->last_name = 'Admin';
            $userProfile->mobile_no = 9876543210;
            $userProfile->address = 'Test Address';
            $userProfile->state = 'Test State';
            $userProfile->city = 'Test State';
            $userProfile->pincode = 98765;
            $user->userProfile()->save($userProfile); 
        }
        
        //Role Seed
        $role = Role::where('name', 'super-admin')->first();
        if(!$role){
            $role = new Role;
            $role->name = 'super-admin';
            $role->label = 'Super Admin';
            $role->save();
        }
        
        //User Role Mapping Seed
        $user->roles()->detach();
        $user->assignRole($role->id);
        
        //Screen Seed & Role Screen Mapping Seed
        Screen::whereIn('name', ['dashboard', 'users.index', 'users.create', 'users.edit', 'users.show', 'users.destroy', 'users.assignrole_create', 'roles.index', 'roles.create', 'roles.edit', 'roles.show', 'roles.destroy', 'roles.assignpermission_create', 'roles.assignscreen_create', 'permissions.index', 'permissions.create', 'permissions.edit', 'permissions.show', 'permissions.destroy', 'screens.index', 'screens.create', 'screens.edit', 'screens.show', 'screens.destroy', 'screens.assignrole_create', 'menus.index', 'menus.create', 'menus.edit', 'menus.show', 'menus.destroy', 'menus.builder', 'docs.index' ])->delete();
        
        RoleScreen::where('role_id', $role->id)->delete();
        
        $screens = [
            ['name' => 'dashboard','label' => 'Dashboard'],
            ['name' => 'users.index','label' => 'User List'],
            ['name' => 'users.create','label' => 'User Create'],
            ['name' => 'users.edit','label' => 'User Edit'],
            ['name' => 'users.show','label' => 'User Show'],
            ['name' => 'users.destroy','label' => 'User Delete'],
            ['name' => 'users.assignrole_create','label' => 'User Assign Role'],
            ['name' => 'roles.index','label' => 'Role List'],
            ['name' => 'roles.create','label' => 'Role Create'],
            ['name' => 'roles.edit','label' => 'Role Edit'],
            ['name' => 'roles.show','label' => 'Role Show'],
            ['name' => 'roles.destroy','label' => 'Role Delete'],
            ['name' => 'roles.assignpermission_create','label' => 'Role Assign Permission'],
            ['name' => 'roles.assignscreen_create','label' => 'Role Assign Screen'],
            ['name' => 'permissions.index','label' => 'Permission List'],
            ['name' => 'permissions.create','label' => 'Permission Create'],
            ['name' => 'permissions.edit','label' => 'Permission Edit'],
            ['name' => 'permissions.show','label' => 'Permission Show'],
            ['name' => 'permissions.destroy','label' => 'Permission Delete'],
            ['name' => 'screens.index','label' => 'Screen List'],
            ['name' => 'screens.create','label' => 'Screen Create'],
            ['name' => 'screens.edit','label' => 'Screen Edit'],
            ['name' => 'screens.show','label' => 'Screen Show'],
            ['name' => 'screens.destroy','label' => 'Screen Delete'],
            ['name' => 'screens.assignrole_create','label' => 'Screen Assign Role'],
            ['name' => 'menus.index','label' => 'Menu List'],
            ['name' => 'menus.create','label' => 'Menu Create'],
            ['name' => 'menus.edit','label' => 'Menu Edit'],
            ['name' => 'menus.show','label' => 'Menu Show'],
            ['name' => 'menus.destroy','label' => 'Menu Delete'],
            ['name' => 'menus.builder','label' => 'Menu-Builder'],
            ['name' => 'docs.index','label' => 'Document'],
        ];
        
        foreach ($screens as $screen){
                $newScreen = Screen::create($screen);
                $role->assignScreen($newScreen->id);
        }      

        //Menu Seed 
        $menu = Menu::where('name', 'admin')->first();
        if(!$menu){
            $menu = new Menu;
            $menu->name  = 'admin';
            $menu->label = 'Admin';
            $menu->save();
            
            $menuItem1 = new MenuItem;
            $menuItem1->title  = "Dashboard";
            $menuItem1->icon   = "fa-home";
            $menuItem1->order  = 1;
            $menuItem1->target = "_self";
            $menuItem1->route  = "dashboard";
 
            $menuItem2 = new MenuItem;
            $menuItem2->title  = "User Management";
            $menuItem2->icon   = "fa-users";
            $menuItem2->order  = 2;
            $menuItem2->target = "_self";
            $menuItem2->route  = "users.index";

            $menuItem3 = new MenuItem;
            $menuItem3->title  = "Roles Management";
            $menuItem3->icon   = null;
            $menuItem3->order  = 3;
            $menuItem3->target = "_self";
            $menuItem3->route  = "roles.index";

            $menuItem4 = new MenuItem;
            $menuItem4->title  = "Permissions Management";
            $menuItem4->icon   = null;
            $menuItem4->order  = 4;
            $menuItem4->target = "_self";
            $menuItem4->route  = "permissions.index";

            $menuItem5 = new MenuItem;
            $menuItem5->title  = "Screens Management";
            $menuItem5->icon   = null;
            $menuItem5->order  = 5;
            $menuItem5->target = "_self"; 
            $menuItem5->route  = "screens.index";            

            $menuItem6 = new MenuItem;
            $menuItem6->title  = "Menu Management";
            $menuItem6->icon   = "fa-list";
            $menuItem6->order  = 6;
            $menuItem6->target = "_self";
            $menuItem6->route  = "menus.index";

            $menuItem7 = new MenuItem;
            $menuItem7->title  = "Site Settings";
            $menuItem7->icon   = "fa-wrench";
            $menuItem7->order  = 7;
            $menuItem7->target = "_self";
            $menuItem7->route  = "settings.create";
            
            $menuItem8 = new MenuItem;
            $menuItem8->title  = "User Guide";
            $menuItem8->icon   = "fa-book";
            $menuItem8->order  = 8;
            $menuItem8->target = "_self";
            $menuItem8->route  = "docs.index";
            
            $menu = $menu->items()->saveMany([$menuItem1, $menuItem2, $menuItem3, $menuItem4, $menuItem5, $menuItem6, $menuItem7, $menuItem8]);
        }
        
        //Setting Seed
        Setting::whereIn('name', ['site_name', 'site_logo', 'admin_email', 'date_format', 'date_time_format', 'time_format', 'entries_per_page'])->delete();
        
        $settings = [
            ['name' => 'site_name','value' => 'LaraSnap'],
            ['name' => 'site_logo','value' => ''],
            ['name' => 'admin_email','value' => 'admin@larasnap.com'],
            ['name' => 'date_format','value' => 'd/m/Y'],
            ['name' => 'date_time_format','value' => 'd/m/Y  h:i A'],
            ['name' => 'time_format','value' => 'h:i:s A'],
            ['name' => 'entries_per_page','value' => '10'],
        ];
        Setting::insert($settings);
    }
}
