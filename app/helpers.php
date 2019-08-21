<?php
// 创建密码
function create_password($str = 123456) {
    return md5( config('app.md5_add_str'). $str .config('app.md5_add_str'));
}
