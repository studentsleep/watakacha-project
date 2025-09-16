<?php
// database/seeders/UserTypeSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
        $userTypes = [
            [
                'id' => 1,
                'name' => 'admin',
                'description' => 'ผู้ดูแลระบบ'
            ],
            [
                'id' => 2,
                'name' => 'member',
                'description' => 'สมาชิกทั่วไป'
            ],
            [
                'id' => 3,
                'name' => 'staff',
                'description' => 'พนักงาน'
            ]
        ];

        foreach ($userTypes as $userType) {
            UserType::updateOrCreate(
                ['id' => $userType['id']], 
                $userType
            );
        }
    }
}