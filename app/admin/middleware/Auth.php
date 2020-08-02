<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\admin\middleware;


class Auth
{
    public function handle($request, \Closure $next)
    {
//        // 前置中间件
//        if (empty(session(config('admin.session_admin'))) && ! preg_match('#login#', $request->pathinfo())) {
//            return redirect((string) url('login/index'));
//        }
        return $next($request);
        // 后置中间件
    }
}