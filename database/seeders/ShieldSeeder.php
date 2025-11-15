<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_academic::scors","view_any_academic::scors","create_academic::scors","update_academic::scors","restore_academic::scors","restore_any_academic::scors","replicate_academic::scors","reorder_academic::scors","delete_academic::scors","delete_any_academic::scors","force_delete_academic::scors","force_delete_any_academic::scors","view_book","view_any_book","create_book","update_book","restore_book","restore_any_book","replicate_book","reorder_book","delete_book","delete_any_book","force_delete_book","force_delete_any_book","book:create_book","book:update_book","book:delete_book","book:pagination_book","book:detail_book","view_fitness::age::bracket","view_any_fitness::age::bracket","create_fitness::age::bracket","update_fitness::age::bracket","restore_fitness::age::bracket","restore_any_fitness::age::bracket","replicate_fitness::age::bracket","reorder_fitness::age::bracket","delete_fitness::age::bracket","delete_any_fitness::age::bracket","force_delete_fitness::age::bracket","force_delete_any_fitness::age::bracket","view_fitness::metric","view_any_fitness::metric","create_fitness::metric","update_fitness::metric","restore_fitness::metric","restore_any_fitness::metric","replicate_fitness::metric","reorder_fitness::metric","delete_fitness::metric","delete_any_fitness::metric","force_delete_fitness::metric","force_delete_any_fitness::metric","view_fitness::rule::set","view_any_fitness::rule::set","create_fitness::rule::set","update_fitness::rule::set","restore_fitness::rule::set","restore_any_fitness::rule::set","replicate_fitness::rule::set","reorder_fitness::rule::set","delete_fitness::rule::set","delete_any_fitness::rule::set","force_delete_fitness::rule::set","force_delete_any_fitness::rule::set","view_fitness::threshold","view_any_fitness::threshold","create_fitness::threshold","update_fitness::threshold","restore_fitness::threshold","restore_any_fitness::threshold","replicate_fitness::threshold","reorder_fitness::threshold","delete_fitness::threshold","delete_any_fitness::threshold","force_delete_fitness::threshold","force_delete_any_fitness::threshold","view_mahasiswa","view_any_mahasiswa","create_mahasiswa","update_mahasiswa","restore_mahasiswa","restore_any_mahasiswa","replicate_mahasiswa","reorder_mahasiswa","delete_mahasiswa","delete_any_mahasiswa","force_delete_mahasiswa","force_delete_any_mahasiswa","view_mahasiswa::semester","view_any_mahasiswa::semester","create_mahasiswa::semester","update_mahasiswa::semester","restore_mahasiswa::semester","restore_any_mahasiswa::semester","replicate_mahasiswa::semester","reorder_mahasiswa::semester","delete_mahasiswa::semester","delete_any_mahasiswa::semester","force_delete_mahasiswa::semester","force_delete_any_mahasiswa::semester","view_matakuliah","view_any_matakuliah","create_matakuliah","update_matakuliah","restore_matakuliah","restore_any_matakuliah","replicate_matakuliah","reorder_matakuliah","delete_matakuliah","delete_any_matakuliah","force_delete_matakuliah","force_delete_any_matakuliah","view_personality::assessment","view_any_personality::assessment","create_personality::assessment","update_personality::assessment","restore_personality::assessment","restore_any_personality::assessment","replicate_personality::assessment","reorder_personality::assessment","delete_personality::assessment","delete_any_personality::assessment","force_delete_personality::assessment","force_delete_any_personality::assessment","view_physical::test","view_any_physical::test","create_physical::test","update_physical::test","restore_physical::test","restore_any_physical::test","replicate_physical::test","reorder_physical::test","delete_physical::test","delete_any_physical::test","force_delete_physical::test","force_delete_any_physical::test","view_program::study","view_any_program::study","create_program::study","update_program::study","restore_program::study","restore_any_program::study","replicate_program::study","reorder_program::study","delete_program::study","delete_any_program::study","force_delete_program::study","force_delete_any_program::study","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_semester","view_any_semester","create_semester","update_semester","restore_semester","restore_any_semester","replicate_semester","reorder_semester","delete_semester","delete_any_semester","force_delete_semester","force_delete_any_semester","view_token","view_any_token","create_token","update_token","restore_token","restore_any_token","replicate_token","reorder_token","delete_token","delete_any_token","force_delete_token","force_delete_any_token","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_ManageSetting","page_Themes","page_MyProfilePage","widget_PhysicalTestStats","widget_TopStudentPerProdiAngkatan"]},{"name":"BaJas","guard_name":"web","permissions":["view_physical::test","view_any_physical::test","create_physical::test","update_physical::test","restore_physical::test","restore_any_physical::test","replicate_physical::test","reorder_physical::test","delete_physical::test","delete_any_physical::test","force_delete_physical::test","force_delete_any_physical::test"]},{"name":"pengaturan tabel nilai jasmani","guard_name":"web","permissions":["view_fitness::age::bracket","view_any_fitness::age::bracket","create_fitness::age::bracket","update_fitness::age::bracket","restore_fitness::age::bracket","restore_any_fitness::age::bracket","replicate_fitness::age::bracket","reorder_fitness::age::bracket","delete_fitness::age::bracket","delete_any_fitness::age::bracket","force_delete_fitness::age::bracket","force_delete_any_fitness::age::bracket","view_fitness::metric","view_any_fitness::metric","create_fitness::metric","update_fitness::metric","restore_fitness::metric","restore_any_fitness::metric","replicate_fitness::metric","reorder_fitness::metric","delete_fitness::metric","delete_any_fitness::metric","force_delete_fitness::metric","force_delete_any_fitness::metric","view_fitness::rule::set","view_any_fitness::rule::set","create_fitness::rule::set","update_fitness::rule::set","restore_fitness::rule::set","restore_any_fitness::rule::set","replicate_fitness::rule::set","reorder_fitness::rule::set","delete_fitness::rule::set","delete_any_fitness::rule::set","force_delete_fitness::rule::set","force_delete_any_fitness::rule::set","view_fitness::threshold","view_any_fitness::threshold","create_fitness::threshold","update_fitness::threshold","restore_fitness::threshold","restore_any_fitness::threshold","replicate_fitness::threshold","reorder_fitness::threshold","delete_fitness::threshold","delete_any_fitness::threshold","force_delete_fitness::threshold","force_delete_any_fitness::threshold"]},{"name":"prodi","guard_name":"web","permissions":["view_mahasiswa","view_any_mahasiswa","create_mahasiswa","update_mahasiswa","restore_mahasiswa","restore_any_mahasiswa","replicate_mahasiswa","reorder_mahasiswa","delete_mahasiswa","delete_any_mahasiswa","force_delete_mahasiswa","force_delete_any_mahasiswa","view_mahasiswa::semester","view_any_mahasiswa::semester","create_mahasiswa::semester","update_mahasiswa::semester","restore_mahasiswa::semester","restore_any_mahasiswa::semester","replicate_mahasiswa::semester","reorder_mahasiswa::semester","delete_mahasiswa::semester","delete_any_mahasiswa::semester","force_delete_mahasiswa::semester","force_delete_any_mahasiswa::semester","view_matakuliah","view_any_matakuliah","create_matakuliah","update_matakuliah","restore_matakuliah","restore_any_matakuliah","replicate_matakuliah","reorder_matakuliah","delete_matakuliah","delete_any_matakuliah","force_delete_matakuliah","force_delete_any_matakuliah","view_program::study","view_any_program::study","create_program::study","update_program::study","restore_program::study","restore_any_program::study","replicate_program::study","reorder_program::study","delete_program::study","delete_any_program::study","force_delete_program::study","force_delete_any_program::study"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
