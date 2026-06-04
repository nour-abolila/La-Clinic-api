<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   // لازم امنع التكرار في حالة تشغيل السييدر أكتر من مرة
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'System',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );
    }
}
