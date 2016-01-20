<?php
use Illuminate\Database\Seeder;
use \App\AdminUser;
use \App\User;

class FookUserSeeder extends Seeder {
    public function run(){
        /**
         * ������Ա�˺�����
         */
        DB::table('user')->truncate();
        DB::table('admin_user')->truncate();
        $User = new User();
        $User->user_name = "admin";
        $User->user_nickname = "FOOKLOOK";
        $User->user_email = "xiashuo.he@foxmail.com";
        $User->login_ip = '127.0.0.1';
        $User->user_password = crypt('hx2602966');
        $User->save();
        $AdminUser = new AdminUser();
        $AdminUser->auto_user_id = $User->id;
        $AdminUser->user_id = $User->id;
        $AdminUser->user_power = 7;
        $AdminUser->created_time = \Carbon\Carbon::now();
        $AdminUser->save();
    }
}