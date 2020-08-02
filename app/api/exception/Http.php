<?php
/**
 * User: ruoning
 * Date: 2020/7/30
 * motto: 知行合一!
 */
namespace app\admin\exception\Http;

use think\exception\Handle;
use think\Response;
use Throwable;

/**
 * Class Http
 * @package app\admin\exception\Http
 */
class Http extends Handle
{
    public $httpSatus = 500;

    /**
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        if (method_exists($e, 'getStatusCode')) {
            $httpStatusCode = $e->getStatusCode();
        } else {
            $httpStatusCode = $this->httpSatus;
        }

        return show(config('status.error'), $e->getMessage(), [], $httpStatusCode);
    }
}