<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => '系統管理員，擁有所有權限。'],
            ['name' => 'security', 'description' => '安保人員，負責車輛出入管理。'],
            ['name' => 'accountant', 'description' => '會計人員，負責費用和報表。'],
            ['name' => 'user', 'description' => '普通註冊使用者。'],
        ];
        DB::table('roles')->insert($roles);
    }
}
