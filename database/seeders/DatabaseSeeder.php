<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user only — no fake volunteers
        User::firstOrCreate(
            ['email' => 'admin@emc.org'],
            [
                'name'               => 'مدير النظام',
                'password'           => Hash::make('password'),
                'role'               => 'super_admin',
                'status'             => 'active',
                'email_verified_at'  => now(),
            ]
        );

        // Core EMC departments
        $departments = [
            ['name' => 'البرامج والمسارات',            'slug' => 'programs',       'color' => '#2691C2', 'icon' => 'book-open'],
            ['name' => 'التسويق والإعلام',             'slug' => 'marketing',      'color' => '#EC943C', 'icon' => 'megaphone'],
            ['name' => 'التقنية والدعم الفني',         'slug' => 'technology',     'color' => '#22334A', 'icon' => 'code'],
            ['name' => 'الموارد البشرية',              'slug' => 'hr',             'color' => '#16A34A', 'icon' => 'users'],
            ['name' => 'الشراكات والعلاقات العامة',   'slug' => 'partnerships',   'color' => '#2691C2', 'icon' => 'handshake'],
            ['name' => 'المجتمع والصحة النفسية',       'slug' => 'community',      'color' => '#EC943C', 'icon' => 'heart'],
            ['name' => 'الجودة والحوكمة',              'slug' => 'quality',        'color' => '#22334A', 'icon' => 'shield-check'],
            ['name' => 'المالية',                       'slug' => 'finance',        'color' => '#16A34A', 'icon' => 'wallet'],
            ['name' => 'التشغيل والعمليات',            'slug' => 'operations',     'color' => '#2691C2', 'icon' => 'settings'],
        ];

        foreach ($departments as $i => $dept) {
            Department::firstOrCreate(
                ['slug' => $dept['slug']],
                array_merge($dept, ['is_active' => true, 'order_column' => $i + 1])
            );
        }
    }
}
