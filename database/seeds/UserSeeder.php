<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users=[
          ['name'=>'admin','email'=>'admin@workhard.com','password'=>bcrypt("admin"),'verified'=>'1','role_id'=>'1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
          ['name'=>'user','email'=>'user@workhard.com','password'=>bcrypt("user"),'verified'=>'1','role_id'=>'2','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
          ['name'=>'Verniy','email'=>'verniy@hibiki.com','password'=>bcrypt("verniy"),'verified'=>'1','role_id'=>'2','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
          ['name'=>'Hibiki','email'=>'hibiki@verniy.com','password'=>bcrypt("hibiki"),'verified'=>'1','role_id'=>'2','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
          ['name'=>'Amnestia','email'=>'haha.tpa.web@gmail.com','password'=>bcrypt("amnestia"),'verified'=>'0','role_id'=>'2','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
        ];

        \App\User::insert($users);
    }
}
