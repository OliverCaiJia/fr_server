<?php

use Illuminate\Database\Seeder;
use App\Models\Orm\AdminUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminUser::create([
            'name' => 'root',
            'email' => 'root@zhijie.com',
            'password' => bcrypt('root')
        ]);
    }
}
