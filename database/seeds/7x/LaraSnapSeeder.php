<?php

use Illuminate\Database\Seeder;
use LaraSnap\LaravelAdmin\Models\User;
use LaraSnap\LaravelAdmin\Models\UserProfile;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Models\RoleScreen;
use LaraSnap\LaravelAdmin\Models\Module;
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

        //Module
        Module::whereIn('label', ['Dashboard', 'User Management', 'Role Management', 'Permission Management', 'Screen Management', 'Module Management', 'Menu Management', 'Category Management', 'Settings', 'Documentation'])->delete();
        
        $module1 = new Module;
        $module1->label = 'Dashboard';
        $module1->save();
        
        $module2 = new Module;
        $module2->label = 'User Management';
        $module2->save();
        
        $module3 = new Module;
        $module3->label = 'Role Management';
        $module3->save();
        
        $module4 = new Module;
        $module4->label = 'Permission Management';
        $module4->save();
        
        $module5 = new Module;
        $module5->label = 'Screen Management';
        $module5->save();
        
        $module6 = new Module;
        $module6->label = 'Module Management';
        $module6->save();
        
        $module7 = new Module;
        $module7->label = 'Menu Management';
        $module7->save();  

        $module8 = new Module;
        $module8->label = 'Category Management';
        $module8->save(); 
        
        $module9 = new Module;
        $module9->label = 'Settings';
        $module9->save(); 

        $module10 = new Module;
        $module10->label = 'Documentation';
        $module10->save();         
        
        //Screen Seed & Role Screen Mapping Seed
        Screen::whereIn('name', ['dashboard', 'users.index', 'users.create', 'users.edit', 'users.show', 'users.destroy', 'users.assignrole_create', 'roles.index', 'roles.create', 'roles.edit', 'roles.destroy', 'roles.assignpermission_create', 'roles.assignscreen_create', 'permissions.index', 'permissions.create', 'permissions.edit', 'permissions.destroy', 'screens.index', 'screens.create', 'screens.edit', 'screens.destroy', 'screens.assignrole_create', 'modules.index', 'modules.create', 'modules.edit','modules.destroy', 'menus.index', 'menus.create', 'menus.edit', 'menus.destroy', 'menus.builder', 'settings.create', 'docs.index', 'docs.icons'])->delete();
        
        RoleScreen::where('role_id', $role->id)->delete();
        
        $screens = [
            ['name' => 'dashboard','label' => 'Dashboard', 'module_id' => $module1->id],
            ['name' => 'users.index','label' => 'User List', 'module_id' => $module2->id],
            ['name' => 'users.create','label' => 'User Create', 'module_id' => $module2->id],
            ['name' => 'users.edit','label' => 'User Edit', 'module_id' => $module2->id],
            ['name' => 'users.show','label' => 'User Show', 'module_id' => $module2->id],
            ['name' => 'users.destroy','label' => 'User Delete', 'module_id' => $module2->id],
            ['name' => 'users.assignrole_create','label' => 'User Assign Role', 'module_id' => $module2->id],
            ['name' => 'roles.index','label' => 'Role List', 'module_id' => $module3->id],
            ['name' => 'roles.create','label' => 'Role Create', 'module_id' => $module3->id],
            ['name' => 'roles.edit','label' => 'Role Edit', 'module_id' => $module3->id],
            ['name' => 'roles.destroy','label' => 'Role Delete', 'module_id' => $module3->id],
            ['name' => 'roles.assignpermission_create','label' => 'Role Assign Permission', 'module_id' => $module3->id],
            ['name' => 'roles.assignscreen_create','label' => 'Role Assign Screen', 'module_id' => $module3->id],
            ['name' => 'permissions.index','label' => 'Permission List', 'module_id' => $module4->id],
            ['name' => 'permissions.create','label' => 'Permission Create', 'module_id' => $module4->id],
            ['name' => 'permissions.edit','label' => 'Permission Edit', 'module_id' => $module4->id],
            ['name' => 'permissions.destroy','label' => 'Permission Delete', 'module_id' => $module4->id],
            ['name' => 'screens.index','label' => 'Screen List', 'module_id' => $module5->id],
            ['name' => 'screens.create','label' => 'Screen Create', 'module_id' => $module5->id],
            ['name' => 'screens.edit','label' => 'Screen Edit', 'module_id' => $module5->id],
            ['name' => 'screens.destroy','label' => 'Screen Delete', 'module_id' => $module5->id],
            ['name' => 'screens.assignrole_create','label' => 'Screen Assign Role', 'module_id' => $module5->id],
            ['name' => 'modules.index','label' => 'Module List', 'module_id' => $module6->id],
            ['name' => 'modules.create','label' => 'Module Create', 'module_id' => $module6->id],
            ['name' => 'modules.edit','label' => 'Module Edit', 'module_id' => $module6->id],
            ['name' => 'modules.destroy','label' => 'Module Delete', 'module_id' => $module6->id],
            ['name' => 'menus.index','label' => 'Menu List', 'module_id' => $module7->id],
            ['name' => 'menus.create','label' => 'Menu Create', 'module_id' => $module7->id],
            ['name' => 'menus.edit','label' => 'Menu Edit', 'module_id' => $module7->id],
            ['name' => 'menus.destroy','label' => 'Menu Delete', 'module_id' => $module7->id],
            ['name' => 'menus.builder','label' => 'Menu-Builder', 'module_id' => $module7->id],
            ['name' => 'p_categories.index','label' => 'Parent Category List', 'module_id' => $module8->id],
            ['name' => 'p_categories.create','label' => 'Parent Category Create', 'module_id' => $module8->id],
            ['name' => 'p_categories.edit','label' => 'Parent Category Edit', 'module_id' => $module8->id],
            ['name' => 'p_categories.destroy','label' => 'Parent Category Delete', 'module_id' => $module8->id],
            ['name' => 'categories.index','label' => 'Category List', 'module_id' => $module8->id],
            ['name' => 'categories.create','label' => 'Category Create', 'module_id' => $module8->id],
            ['name' => 'categories.edit','label' => 'Category Edit', 'module_id' => $module8->id],
            ['name' => 'categories.destroy','label' => 'Category Delete', 'module_id' => $module8->id],
            ['name' => 'settings.create','label' => 'Settings', 'module_id' => $module9->id],
            ['name' => 'docs.index','label' => 'Document', 'module_id' => $module10->id],
            ['name' => 'docs.icons','label' => 'Icons', 'module_id' => $module10->id],
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
            $menuItem3->icon   = "fa-lock";
            $menuItem3->order  = 3;
            $menuItem3->target = "_self";
            $menuItem3->route  = "roles.index";

            $menuItem4 = new MenuItem;
            $menuItem4->title  = "Permissions Management";
            $menuItem4->icon   = "fa-lock";
            $menuItem4->order  = 4;
            $menuItem4->target = "_self";
            $menuItem4->route  = "permissions.index";

            $menuItem5 = new MenuItem;
            $menuItem5->title  = "Screens Management";
            $menuItem5->icon   = "fa-desktop";
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
            $menuItem7->title  = "Category Management";
            $menuItem7->icon   = "fa-list";
            $menuItem7->order  = 7;
            $menuItem7->target = "_self";
            $menuItem7->route  = "p_categories.index";
            
            $menuItem8 = new MenuItem;
            $menuItem8->title  = "Settings";
            $menuItem8->icon   = "fa-wrench";
            $menuItem8->order  = 8;
            $menuItem8->target = "_self";
            $menuItem8->route  = "settings.create";
            
            $menuItem9 = new MenuItem;
            $menuItem9->title  = "User Guide";
            $menuItem9->icon   = "fa-book";
            $menuItem9->order  = 9;
            $menuItem9->target = "_self";
            $menuItem9->route  = "docs.index";
            
            $menu = $menu->items()->saveMany([$menuItem1, $menuItem2, $menuItem3, $menuItem4, $menuItem5, $menuItem6, $menuItem7, $menuItem8, $menuItem9]);
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
            ['name' => 'default_user_role','value' => '0'],
        ];
        Setting::insert($settings);
    }
}
