<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin SORAS',
            'email'    => 'admin@soras.test',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        $this->command->info('✅ AdminSeeder selesai!');
    }
}
