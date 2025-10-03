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

        $positionPermissions = [
            'view-any-position',
            'view-position',
            'create-position',
            'update-position',
            'delete-position',
        ];
        $termTemplatePermissions = [
            'view-any-term-template',
            'view-term-template',
            'create-term-template',
            'update-term-template',
            'delete-term-template',
        ];
        $companyPermissions = [
            'view-any-company',
            'view-company',
            'create-company',
            'update-company',
            'delete-company',
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

        $samplePermissions = [
            'view-any-sample',
            'view-sample',
            'create-sample',
            'update-sample',
            'delete-sample',

            'collecting-sample',
            'receiving-sample',
            'prepare-sample',
            'download-label-sample',
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
            'view-chart-quotation',

            'view-any-quotation',
            'view-quotation',
            'create-quotation',
            'update-quotation',
            'delete-quotation',

            'preview-quotation',
            'send-quotation',
            'download-quotation',
            'submit-quotation',
            'accept-quotation',
            'revise-quotation',
            'cancel-quotation',
        ];


        $labJobPermissions = [
            'view-chart-lab-job',

            'view-any-lab-job',
            'view-lab-job',
            'create-lab-job',
            'update-lab-job',
            'delete-lab-job',

            'preview-lab-job-task-letter', //0
            'download-lab-job-task-letter', //1
            'print-lab-job-task-letter', //2
            'start-lab-job', //3
            'complete-lab-job-sampling', //4
            'complete-lab-job-analysis', //5
            'complete-lab-job-validation', //6
            'generate-lab-job-report', //7
            'approve-lab-job-report', //8
            'send-lab-job-report', //9
            'abort-lab-job-report', //10
        ];
        $testResultPermissions = [
            'view-chart-test-result',

            'view-any-test-result',
            'view-test-result',
            'create-test-result',
            'update-test-result',
            'delete-test-result',

            'filling-test-result',
            'request-validate-test-result',
            'validate-test-result',
            'revision-needed-test-result',
            'reject-test-result'
        ];
        $specializationPermissions = [
            'view-any-specialization',
            'view-specialization',
            'create-specialization',
            'update-specialization',
            'delete-specialization',
        ];



        // Menggabungkan semua permissions ke dalam satu array untuk proses pembuatan permissions
        $allPermissions = array_merge(
            $userPermissions,
            $personelPermissions,
            $positionPermissions,
            $provincePermissions,
            $cityPermissions,
            $customerPermissions,
            $rolePermissions,
            $parameterPermissions,
            $regulationPermissions,
            $sampleMatricPermissions,
            $sampleTypePermissions,
            $samplePermissions,
            $testMethodPermissions,
            $testPackagePermissions,
            $quotationPermissions,
            $termTemplatePermissions,
            $companyPermissions,
            $labJobPermissions,
            $testResultPermissions,
            $specializationPermissions
        );

        // Membuat semua permissions
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Menyimpan roles ke dalam variabel
        $roles = [
            'superadmin' => Permission::all(),
            'customer' => Permission::all(),
            'admin' => Permission::all(),
            'sampling technician' => Permission::all(),
            'analyst' => Permission::all(),
            'technical manager' => Permission::all(),
            'laboratory head' => Permission::all(),
        ];

        // Membuat roles dan memberikan permissions
        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}
