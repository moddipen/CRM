<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'admin'], function () {

	Route::get('/', 'Auth\LoginController@showLoginForm')->name('admin.login');
    
    Route::group(['middleware' => ['permission:login']], function () {
        Route::post('login', 'Auth\LoginController@login');
    });
	
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
	Route::post('register', 'Auth\RegisterController@register');

});

//Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth'],'prefix' => 'admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logout', 'Auth\LoginController@logout');
    
    // Routes For Users 

    Route::group(['middleware' => ['permission:view-user']], function () {
        Route::get('/user','UsersController@index')->name('user.index');
    });
    Route::group(['middleware' => ['permission:create-user']], function () {
        Route::get('create/user','UsersController@create')->name('user.create');
    });

    Route::post('store/user','UsersController@store')->name('user.store');

    Route::group(['middleware' => ['permission:edit-user']],function (){
        Route::get('edit/user/{id}','UsersController@edit')->name('user.edit');
    });

    Route::put('update/user/{id}','UsersController@update')->name('user.update');
    Route::delete('delete/user/{id}','UsersController@delete')->name('user.delete');
    
    // Routes For Permission

    Route::group(['middleware' => ['permission:view-permission']], function () {
        Route::get('/permission','PermissionController@index')->name('permission.index');
    });
    Route::group(['middleware' => ['permission:create-permission']], function () {
        Route::get('create/permission','PermissionController@create')->name('permission.create');
    });
    
    Route::post('store/permission','PermissionController@store')->name('permission.store');

    Route::group(['middleware' => ['permission:create-permission']], function () {
        Route::get('edit/permission/{id}','PermissionController@edit')->name('permission.edit');
    });
    
    Route::put('update/permission/{id}','PermissionController@update')->name('permission.update');
    Route::delete('delete/permission/{id}','PermissionController@delete')->name('permission.delete');

    // Routes For Role  

    Route::group(['middleware' => ['permission:view-role']], function () {
        Route::get('role','RoleController@index')->name('role');
    });
    Route::group(['middleware' => ['permission:create-role']], function () {
        Route::get('create/role','RoleController@create')->name('role.create');
    });
    
    Route::post('store/role','RoleController@store')->name('role.store');
    Route::group(['middleware' => ['permission:edit-role']], function () {
        Route::get('edit/role/{id}','RoleController@edit')->name('role.edit');
    });
    
    Route::put('update/role/{id}','RoleController@update')->name('role.update');
    Route::delete('delete/role/{id}','RoleController@delete')->name('role.delete');

    //Route For General Leaves

    Route::group(['middleware' => ['permission:view-general-leave']], function () {
        Route::get('general/leaves','LeaveController@index')->name('general.leave.index');
    });
    Route::group(['middleware' => ['permission:create-general-leave']],function(){
         Route::get('create/general/leave','LeaveController@create')->name('general.leave.create');
    });
   
    Route::post('store/general/leave','LeaveController@store')->name('general.leave.store');

    Route::group(['middleware' => ['permission:edit-general-leave']],function(){
        Route::get('edit/general/leave/{id}','LeaveController@edit')->name('general.leave.edit');
    });

    
    Route::put('update/general/leave/{id}','LeaveController@update')->name('general.leave.update');
    Route::delete('delete/general/leave/{id}','LeaveController@delete')->name('general.leave.delete');

    Route::post('general/leave/sent','LeaveController@sendLeave')->name('general.leave.sendLeave');

    Route::group(['middleware' => ['permission:show-general-leave']],function(){
        Route::get('/view/general-leave/{id}','LeaveController@showGeneralLeave')->name('general.leave.show');
    });
    //Route For Employee Leaves
    
    Route::group(['middleware' => ['permission:view-employee-leave']],function(){
        Route::get('employee/leaves','EmployeeLeaveController@index')->name('employee.leave.index');
    });
    Route::group(['middleware' => ['permission:create-employee-leave']],function(){
        Route::get('create/employee/leave','EmployeeLeaveController@create')->name('employee.leave.create');
    });
    
    Route::post('store/employee/leave','EmployeeLeaveController@store')->name('employee.leave.store');
    Route::group(['middleware' => ['permission:edit-employee-leave']],function(){
        Route::get('edit/employee/leave/{id}','EmployeeLeaveController@edit')->name('employee.leave.edit');
    });
    
    Route::put('update/employee/leave/{id}','EmployeeLeaveController@update')->name('employee.leave.update');
    Route::delete('delete/employee/leave/{id}','EmployeeLeaveController@delete')->name('employee.leave.delete'); 

    Route::get('/applyForLeave','EmployeeLeaveController@applyForLeave')->name('applyForLeave');
    Route::post('/post-leave','EmployeeLeaveController@leaveDetails')->name('post-leave');

    Route::group(['middleware' => ['permission:show-employee-leave']],function(){
        Route::get('/view/employee-leave/{id}','EmployeeLeaveController@showLeave')->name('employee.leave.view');
    });
   
    Route::get('approveMail/employee-leave/{id}','EmployeeLeaveController@approveMail')->name('employeeLeave.approve');
    Route::get('deniedMail/employee-leave/{id}','EmployeeLeaveController@deniedMail')->name('employeeLeave.denied');
    Route::post('postDenied/employee-leave','EmployeeLeaveController@postDenied2')->name('post-employeeleave-denied');
    
    // Routes For Error Report
    Route::group(['middleware' => ['permission:view-error']],function(){
        Route::get('/error','ErrorController@index')->name('error.index');
    });
    Route::group(['middleware' => ['permission:create-error']],function(){
        Route::get('create/error','ErrorController@create')->name('error.create');
    }); 
    
    Route::post('store/error','ErrorController@store')->name('error.store');

    Route::group(['middleware'=>['permission:edit-error']],function(){
        Route::get('edit/error/{id}','ErrorController@edit')->name('error.edit');
    });

    
    Route::put('update/error/{id}','ErrorController@update')->name('error.update');
    Route::delete('delete/error/{id}','ErrorController@delete')->name('error.delete');
    Route::group(['middleware'=>['permission:show-error-view']],function(){
        Route::get('view/error/{id}','ErrorController@view')->name('error.view');
    });
    
    Route::put('fix/error/{id}','ErrorController@errorFix')->name('error.fix');


    //Routes For Ticket 

    Route::group(['middleware'=>['permission:view-ticket']],function(){
        Route::get('/ticket','TicketController@index')->name('ticket.index');
    });

    Route::group(['middleware'=>['permission:create-ticket']],function(){
        Route::get('/create/ticket','TicketController@create')->name('ticket.create');
    });

    Route::post('store/ticket','TicketController@store')->name('ticket.store');

    Route::group(['middleware'=>['permission:edit-ticket']],function(){
        Route::get('edit/ticket/{id}','TicketController@edit')->name('ticket.edit');
    }); 

    Route::put('update/ticket/{id}','TicketController@update')->name('ticket.update');
    Route::delete('delete/ticket/{id}','TicketController@delete')->name('ticket.delete');

    Route::group(['middleware'=>['permission:show-ticket']],function(){
        Route::get('show/ticket/{id}','TicketController@showTicket')->name('ticket.view');
    }); 
    Route::get('approveMail/ticket/{id}','TicketController@approveMail')->name('ticket.approve');
    Route::get('deniedMail/ticket/{id}','TicketController@deniedMail')->name('ticket.denied');
    Route::post('postDenied/ticket','TicketController@postDenied')->name('post-ticket-denied');

    // Route For Change Password And Account Setting

    Route::get('/changePassword','UsersController@changePassword')->name('changePassword'); 
    Route::post('/updatePassword','UsersController@updatePassword')->name('password.update');
    Route::get('/profile','UsersController@profile')->name('profile');
    Route::post('profile/store','UsersController@storeProfile')->name('profile.store');
    Route::post('profileImg/remove','UsersController@removeImg')->name('profileImg.remove');
    
    Route::group(['middleware'=>['permission:show-user']],function(){
        Route::get('show/user/{id}','UsersController@viewUser')->name('user.show');
    });
});
Route::group(['middleware' => ['auth']],function(){
    Route::get('admin/get/user','UsersController@getData')->name('get.user');
    Route::get('admin/get/permission','PermissionController@getData')->name('get.permission');
    Route::get('admin/get/role','RoleController@getData')->name('get.role');
    Route::get('admin/get/general/leave','LeaveController@getData')->name('get.general.leave');
    Route::get('admin/get/employee/leave','EmployeeLeaveController@getData')->name('get.employee.leave');
    Route::get('admin/get/errorReport','ErrorController@getData')->name('get.errorReport');
    Route::get('admin/get/ticket','TicketController@getData')->name('get.ticket');
    Route::get('admin/tickets','DashboardController@getTicketData')->name('get.ticket.dashboard');

});

//  Routes For Aprrove and Denied Option 

Route::get('/approve/{id}','EmployeeLeaveController@approveLeave')->name('approve-leave');
Route::get('/denied-view/{id}','EmployeeLeaveController@deniedLeave')->name('denied-leave');
Route::post('/post/denied','EmployeeLeaveController@postDenied')->name('post-denied-leave');
Route::get('/admin/forgot-password','UsersController@forgotPassword')->name('password.request');
Route::post('/admin/send-password','UsersController@sendPassword')->name('send.password');
Route::get('/reset-password/{id}','UsersController@resetPassword')->name('reset.password');
Route::put('/update-password/{id}','UsersController@setPassword')->name('update.password');