<?php
use Illuminate\Database\Seeder;
use \App\AdminUser;
use \App\User;

class AdminUserSeeder extends Seeder {
    public function run(){
        /**
         * ������Ա�˺�����
         */
        DB::table('admin_user')->truncate();
        $User = new User();
    }
}