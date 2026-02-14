<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('user_roles')->insert([
            [
            'title' => 'Admin',
            'permissions' => json_encode([
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Quotes"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Orders"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Cemetery"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Products"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Collaboration"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Production"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Installation"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Accounting"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Maintenance"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Department"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "Setting"
        ],
        [
            "mine"=> false,
            "read"=> true,
            "create"=> true,
            "delete"=> true,
            "update"=> true,
            "resource"=> "User"
        ]
            ]),
        ],
            [
                'title' => 'Supper Admin',
                'permissions' => json_encode([
                    [
                        "mine"=> false,
                        "read"=> true,
                        "create"=> true,
                        "delete"=> true,
                        "update"=> true,
                        "resource"=> "User"
                    ]
                ]),
            ],
            [
                'title' => 'Customer',
                'permissions' => json_encode([
                    [
                        "mine"=> false,
                        "read"=> true,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Customer Portal"
                    ]
                ]),
            ]
        ]);
    }
}
