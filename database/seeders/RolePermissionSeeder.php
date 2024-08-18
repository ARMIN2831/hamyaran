<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // پاک کردن کش برای جلوگیری از بروز خطا
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // تعریف پرمیشن‌ها
        $permissions = [

            //'create user' => 'ساخت کاربر',
            //'edit user' => 'ویرایش کاربر',
            //'delete user' => 'حذف کاربر',
            //'view user' => 'نمایش لیست کاربر',
//
            //'create institute' => 'ساخت موسسه',
            //'edit institute' => 'ویرایش موسسه',
            //'delete institute' => 'حذف موسسه',
            //'view institute' => 'نمایش لیست موسسه',
//
            //'create classStudent' => 'ساخت کلاس دانشجو',
            //'edit classStudent' => 'ویرایش کلاس دانشجو',
            //'delete classStudent' => 'حذف کلاس دانشجو',
            //'view classStudent' => 'نمایش لیست کلاس دانشجو',
//
            //'create activity' => 'ساخت فعالیت',
            //'edit activity' => 'ویرایش فعالیت',
            //'delete activity' => 'حذف فعالیت',
            //'view activity' => 'نمایش لیست فعالیت',
//
            //'create student' => 'ساخت دانشجو',
            //'edit student' => 'ویرایش دانشجو',
            //'delete student' => 'حذف دانشجو',
            //'view student' => 'نمایش لیست دانشجو',
//
            //'create classroom' => 'ساخت کلاس',
            //'edit classroom' => 'ویرایش کلاس',
            //'delete classroom' => 'حذف کلاس',
            //'view classroom' => 'نمایش لیست کلاس',
//
            //'create course' => 'ساخت دوره',
            //'edit course' => 'ویرایش دوره',
            //'delete course' => 'حذف دوره',
            //'view course' => 'نمایش لیست دوره',
//
            //'create convene' => 'ساخت مجتمع',
            //'edit convene' => 'ویرایش مجتمع',
            //'delete convene' => 'حذف مجتمع',
            //'view convene' => 'نمایش لیست مجتمع',
//
            //'create role' => 'ساخت نقش',
            //'edit role' => 'ویرایش نقش',
            //'delete role' => 'حذف نقش',
            //'view role' => 'نمایش لیست نقش',

            //'all user' => 'تمام کارمندان',
            //'some user' => 'کارمندان زیرمجموعه',
            //'one user' => 'هیچکدام',

            //'add student to class' => 'افزودن دانشجو به کلاس'

            //'setting db' => 'تنظیمات پایگاه داده',
            //'setting setdata' => 'تنظیمات ورودی اطلاعات',

            'manage ticket' => 'مدیریت تیکت ها'
        ];

        foreach ($permissions as $key => $permission) {
            Permission::firstOrCreate(['name' => $key, 'title' => $permission]);
        }
    }
}
