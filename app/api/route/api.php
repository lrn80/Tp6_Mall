<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */

use think\facade\Route;

Route::rule('smscode', 'sms/code', 'POST');
Route::resource('user', 'User');