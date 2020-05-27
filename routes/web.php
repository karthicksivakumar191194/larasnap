<?php
//Note: Please do copy the contents to './web-publish.txt' file. Since 'web-publish.txt' will be used when publishing routes to local.


//Packges routes by default does not own 'web' middleware, so adding it manually here.

Route::group(['namespace' => '\LaraSnap\LaravelAdmin\Controller','prefix' => 'admin', 'middleware' => ['web', 'auth', 'check-userstatus'], 'roles' => '' ], function(){
	
    Route::group(['middleware' => ['check-roles'] ], function(){
        
        /** DASHBOARD ROUTES **/
        Route::get('/', 'DashboardController')->name('dashboard');
        /** DASHBOARD ROUTES **/
        
        /** USER ROUTES **/
        Route::group(['prefix' => 'users', 'exculde' => ['users.filter', 'users.store', 'users.update', 'users.bulkdestroy', 'users.assignrole_store']], function(){
            Route::get('/','UserController@index')->name('users.index');
            Route::post('/','UserController@index')->name('users.filter');
            Route::get('create','UserController@create')->name('users.create');
            Route::post('create','UserController@store')->name('users.store');
            Route::get('{user}/edit','UserController@edit')->name('users.edit');
            Route::put('{user}','UserController@update')->name('users.update');
            Route::get('{user}','UserController@show')->name('users.show');
            Route::delete('{user}','UserController@destroy')->name('users.destroy');
            Route::delete('/','UserController@bulkdestroy')->name('users.bulkdestroy');
            Route::get('{user}/roles','UserController@assignRoleCreate')->name('users.assignrole_create');
            Route::post('{user}/roles','UserController@assignRoleStore')->name('users.assignrole_store');
        });
        /** USER ROUTES **/
        
        /** ROLE ROUTES **/
        Route::group(['prefix' => 'roles', 'exculde' => ['roles.filter', 'roles.store', 'roles.update', 'roles.assignpermission_store', 'roles.assignscreen_store']], function(){
            Route::get('/','RoleController@index')->name('roles.index');
            Route::post('/','RoleController@index')->name('roles.filter');
            Route::get('create','RoleController@create')->name('roles.create');
            Route::post('create','RoleController@store')->name('roles.store');
            Route::get('{role}/edit','RoleController@edit')->name('roles.edit');
            Route::put('{role}','RoleController@update')->name('roles.update');
            Route::get('{role}','RoleController@show')->name('roles.show');
            Route::delete('{role}','RoleController@destroy')->name('roles.destroy');
            Route::get('{role}/permissions','RoleController@assignPermissionCreate')->name('roles.assignpermission_create');
            Route::post('{role}/permissions','RoleController@assignPermissionStore')->name('roles.assignpermission_store');
            Route::get('{role}/screens','RoleController@assignScreenCreate')->name('roles.assignscreen_create');
            Route::post('{role}/screens','RoleController@assignScreenStore')->name('roles.assignscreen_store');
        });
        /** ROLE ROUTES **/	
        
        /** PERMISSION ROUTES **/
        Route::group(['prefix' => 'permissions', 'exculde' => ['permissions.filter', 'permissions.store', 'permissions.update']], function(){
            Route::get('/','PermissionController@index')->name('permissions.index');
            Route::post('/','PermissionController@index')->name('permissions.filter');
            Route::get('create','PermissionController@create')->name('permissions.create');
            Route::post('create','PermissionController@store')->name('permissions.store');
            Route::get('{permission}/edit','PermissionController@edit')->name('permissions.edit');
            Route::put('{permission}','PermissionController@update')->name('permissions.update');
            Route::get('{permission}','PermissionController@show')->name('permissions.show');
            Route::delete('{permission}','PermissionController@destroy')->name('permissions.destroy');
        });
        /** PERMISSION ROUTES **/		
        
        /** SCREEN ROUTES **/
        Route::group(['prefix' => 'screens', 'exculde' => ['screens.filter', 'screens.store', 'screens.update', 'screens.assignrole_store']], function(){
            Route::get('/','ScreenController@index')->name('screens.index');
            Route::post('/','ScreenController@index')->name('screens.filter');
            Route::get('create','ScreenController@create')->name('screens.create');
            Route::post('create','ScreenController@store')->name('screens.store');
            Route::get('{screen}/edit','ScreenController@edit')->name('screens.edit');
            Route::put('{screen}','ScreenController@update')->name('screens.update');
            Route::get('{screen}','ScreenController@show')->name('screens.show');
            Route::delete('{screen}','ScreenController@destroy')->name('screens.destroy');
            Route::get('{screen}/roles','ScreenController@assignRoleCreate')->name('screens.assignrole_create');
            Route::post('{screen}/roles','ScreenController@assignRoleStore')->name('screens.assignrole_store');	
        });
        /** SCREEN ROUTES **/
    
        /** MENU ROUTES **/
        Route::group(['prefix' => 'menus', 'exculde' => ['menus.filter', 'menus.store', 'menus.update', 'menus.order', 'menus.item_store', 'menus.item_update', 'menus.item.destory']], function(){
            Route::get('/','MenuController@index')->name('menus.index');
            Route::post('/','MenuController@index')->name('menus.filter');
            Route::get('create','MenuController@create')->name('menus.create');
            Route::post('create','MenuController@store')->name('menus.store');
            Route::get('{menu}/edit','MenuController@edit')->name('menus.edit');
            Route::put('{menu}','MenuController@update')->name('menus.update');
            Route::get('{menu}','MenuController@show')->name('menus.show');
            Route::delete('{menu}','MenuController@destroy')->name('menus.destroy');
            Route::get('{menu}/builder','MenuController@builder')->name('menus.builder');
            Route::post('{menu}/order','MenuController@orderItem')->name('menus.order');
            Route::post('{menu}/item','MenuController@itemStore')->name('menus.item_store');
            Route::put('{menu}/item','MenuController@itemUpdate')->name('menus.item_update');
            Route::delete('{menu}/item', 'MenuController@itemDestroy')->name('menus.item.destory');
        });
        /** MENU ROUTES **/
        
        /** SETTING ROUTES **/
        Route::group(['prefix' => 'settings', 'exculde' => ['settings.store']], function(){
            Route::get('/','SiteSettingController@create')->name('settings.create');
            Route::post('/','SiteSettingController@store')->name('settings.store');
        });	
        /** SETTING ROUTES **/
            
        /** DOCUMENT ROUTES **/
        Route::get('guide','DocsController@index')->name('docs.index');
        Route::get('/icons','DocsController@icons')->name('docs.icons');
        
    });
    
     /** ERROR ROUTES **/
     Route::group(['prefix' => 'error'], function(){
          Route::get('/401','ErrorController@noPermission')->name('errors.401');		   
     });
     /** ERROR ROUTES **/
    
    
});
