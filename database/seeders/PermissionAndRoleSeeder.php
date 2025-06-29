<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyimpan permissions ke dalam variabel
        $userPermissions = [
            'view-any-user',
            'view-user',
            'create-user',
            'update-user',
            'delete-user',
        ];

        $rolePermissions = [
            'view-any-role',
            'view-role',
            'create-role',
            'update-role',
            'delete-role',
        ];

        $provincePermissions = [
            'view-any-province',
            'view-province',
            'create-province',
            'update-province',
            'delete-province',
        ];

        $cityPermissions = [
            'view-any-city',
            'view-city',
            'create-city',
            'update-city',
            'delete-city',
        ];

        $customerPermissions = [
            'view-any-customer',
            'view-customer',
            'create-customer',
            'update-customer',
            'delete-customer',
        ];

        $personelPermissions = [
            'view-any-personel',
            'view-personel',
            'create-personel',
            'update-personel',
            'delete-personel',
        ];

        $parameterPermissions = [
            'view-any-parameter',
            'view-parameter',
            'create-parameter',
            'update-parameter',
            'delete-parameter',
        ];

        $regulationPermissions = [
            'view-any-regulation',
            'view-regulation',
            'create-regulation',
            'update-regulation',
            'delete-regulation',
        ];
        $sampleMatricPermissions = [
            'view-any-sample-matric',
            'view-sample-matric',
            'create-sample-matric',
            'update-sample-matric',
            'delete-sample-matric',
        ];
        $sampleTypePermissions = [
            'view-any-sample-type',
            'view-sample-type',
            'create-sample-type',
            'update-sample-type',
            'delete-sample-type',
        ];
        $testMethodPermissions = [
            'view-any-test-method',
            'view-test-method',
            'create-test-method',
            'update-test-method',
            'delete-test-method',
        ];
        $testPackagePermissions = [
            'view-any-test-package',
            'view-test-package',
            'create-test-package',
            'update-test-package',
            'delete-test-package',
        ];
        $quotationPermissions = [
            'view-any-quotation',
            'view-quotation',
            'create-quotation',
            'update-quotation',
            'delete-quotation',
        ];




        // Menggabungkan semua permissions ke dalam satu array untuk proses pembuatan permissions
        $allPermissions = array_merge(
            $userPermissions,
            $personelPermissions,
            $provincePermissions,
            $cityPermissions,
            $customerPermissions,
            $rolePermissions,
            $parameterPermissions,
            $regulationPermissions,
            $sampleMatricPermissions,
            $sampleTypePermissions,
            $testMethodPermissions,
            $testPackagePermissions,
            $quotationPermissions
        );

        // Membuat semua permissions
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Menyimpan roles ke dalam variabel
        $roles = [
            'superadmin' => Permission::all(),
            'admin' => Permission::all(),
            'customer' => Permission::all(),
        ];

        // Membuat roles dan memberikan permissions
        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}
