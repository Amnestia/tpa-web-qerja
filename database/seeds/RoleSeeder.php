<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
          ['role'=>'admin','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
          ['role'=>'user','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
        ];

        \App\Role::insert($roles);
    }
}
