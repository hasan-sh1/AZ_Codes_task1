<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // استدعاء seeder الأدوار والصلاحيات
        $this->call([
            RolesAndPermissionsSeeder::class,
            // يمكنك إضافة seeders أخرى هنا
            // UserSeeder::class,
        ]);
    }
}
