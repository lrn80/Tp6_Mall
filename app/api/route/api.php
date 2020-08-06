<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */

use think\facade\Route;

Route::rule("smscode", "sms/code", "POST");
Route::resource('user', 'User');
Route::rule("lists", "mall.lists/index");
Route::rule("subcategory/:id", "category/sub");
Route::rule("detail/:id", "mall.detail/index");
Route::resource("order", "order.index");