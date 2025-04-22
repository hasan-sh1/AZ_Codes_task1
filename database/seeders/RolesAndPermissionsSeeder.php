<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // تأكد من استيراد موديل المستخدم الخاص بك

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إعادة تعيين الأدوار والصلاحيات المخزنة مؤقتًا
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء صلاحيات
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
      

        // إنشاء أدوار وربطها بالصلاحيات الموجودة
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // يمكن للمسؤول فعل كل شيء

        // Rename variable for clarity
        $userRole = Role::create(['name' => 'user']); 
        $userRole->givePermissionTo(['edit articles', 'publish articles']);
        // أضف المزيد من الأدوار حسب الحاجة

        // --- ربط الأدوار بالمستخدمين ---
        // عادةً ما يتم هذا في seeder آخر (مثل UserSeeder) أو يدويًا.
        // مثال: ابحث عن مستخدم معين وقم بتعيين دور له
        // $user = User::where('email', 'admin@example.com')->first();
        // if ($user) {
        //     $user->assignRole('admin');
        // }

        // مثال: إنشاء مستخدم مسؤول افتراضي إذا لم يكن موجودًا
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'], // ابحث عن المستخدم بهذا البريد الإلكتروني
            [ // إذا لم يكن موجودًا، قم بإنشائه بهذه البيانات
                'name' => 'Admin User',
                'password' => bcrypt('123456') // استخدم كلمة مرور آمنة!
            ]
            
        );
        $adminUser->assignRole($adminRole); // قم بتعيين دور المسؤول للمستخدم

        // إنشاء مستخدم عادي افتراضي إذا لم يكن موجودًا
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'], // ابحث عن المستخدم بهذا البريد الإلكتروني
            [ // إذا لم يكن موجودًا، قم بإنشائه بهذه البيانات
                'name' => 'Regular User',
                'password' => bcrypt('123456') // استخدم كلمة مرور آمنة!
            ]
        );
        $regularUser->assignRole($userRole); // قم بتعيين دور المستخدم العادي
    }
}
