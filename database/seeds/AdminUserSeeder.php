<?php
use Illuminate\Database\Seeder;
use \App\AdminUser;
use \App\User;

class AdminUserSeeder extends Seeder {
    public function run(){
        /**
         * 填充管理员账号数据
         */
        DB::table('admin_user')->truncate();
        $User = new User();
    }
}