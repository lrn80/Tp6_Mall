<?php
/*
 * 业务相关status的配置
 */

return [
    'success' => 1,
    'error' => 0,
    'not_login' => -1,
    'user_is_register' => -2,
    'action_not_found' => -3,
    'mysql' => [
        'table_normal' => 1, // 正常
        'table_pending' => 0, // 待审核
        'table_delete' => 99, // 删除
    ],

];