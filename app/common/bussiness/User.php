<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\common\bussiness;

use app\common\lib\Str;
use app\common\lib\Time;
use \app\common\model\mysql\User as UserModel;
use think\Exception;

class User
{
    public $userObj = null;
    
    public function __construct()
    {
        $this->userObj = new UserModel();
    }

    public function login($data)
    {
//       $redisCode = cache(config('redis.code_pre') . $data['phone_number']);
//
//       if (empty($redisCode) || $redisCode = $data['code']) {
//           throw new Exception('验证码不正确', -1009);
//       }

       $user = $this->userObj->getUserByPhoneNumber($data['phone_number']);

       if (!$user) {
           $username = 'zx_' . $data['phone_number'];
           $userData = [
               'username' => $username,
               'phone_number' => $data['phone_number'],
               'type' => $data['type'],
               'status' => config('status.mysql.table_normal'),
           ];

        try {
            $this->userObj->save($userData);
            $userId = $this->userObj->id;
        } catch (\Exception $e) {
            throw new Exception('数据库内部异常！');
        }

       } else {
           try {
               $this->userObj->update( ['update_time' => time()],['phone_number' => $user['phone_number']]);
               $userId = $user->id;
               $username = $user->username;
           } catch (\Exception $e) {
               throw new Exception('数据库内部异常！');
           }
       }

       $token = Str::getLoginToken($data['phone_number']);

       $redisData = [
            'id' => $userId,
            'username' => $username,
       ];

       $res = cache(config('redis.token_pre') . $token, $redisData, Time::userLoginExpiresTime($data['type']));

       return $res ? ['token' => $token, 'username' => $username] : false;
    }

    public function getNormalUserById($id)
    {
        $user = $this->userObj->getUserById($id);
        if (!$user || $user->status != config('status.mysql.table_normal')) {
            return [];
        }

        return $user->toArray();
    }

    public function getNormalUserByUsername($username)
    {
        $user = $this->userObj->getUserByUsername($username);
        if (!$user || $user->status != config('status.mysql.table_normal')) {
            return [];
        }

        return $user->toArray();
    }

    public function update($id, $data)
    {
        $user = $this->getNormalUserById($data['username']);
        if ($user && $user['id'] != $id) {
            throw new Exception('该用户名已经存在');
        }

        return $this->userObj->updateById($id, $data);
    }
}