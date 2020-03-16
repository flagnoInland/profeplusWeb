<?php

Route::get('/admin', array('before' => 'start', function () {   
    return View::make('admin.login');
}));

Route::get('/admin/login', 'AdminController@isAdmin');

Route::get('/admin/user/data', 'AdminController@getUserData');

Route::get('/admin/user/info', 'AdminController@getUserInfo');

Route::post('/admin/rol/new', 'AdminController@changeRole');

Route::get('/admin/logout', 'AdminController@logout');

Route::get('/admin/stats', 'AdminController@getStats');

Route::get('/admin/mail/log', 'AdminController@mailLog');

Route::get('/admin/{userId}', array('before' => 'logged', function ($userId) {   
    return View::make('admin.home', array('userId' => $userId));
}));