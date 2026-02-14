<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       /* \DB::table('user_roles')->insert([[
            'title' => 'Admin',
        ],[
            'title' => 'User',
        ],[
            'title' => 'Guest',
        ]]);*/

        $userRoles = [
            ['title'=> 'Manager'],
            ['title'=> 'Client'],
            ['title'=> 'Sales Person'],
            ['title'=> 'Production']
        ];

        $allPermissions = [
            [
                'title' => '',
                'permissions' => [
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Quotes"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Orders"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Cemetery"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Products"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Collaboration"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Production"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Installation"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Accounting"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Maintenance"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Department"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "Setting"
                    ],
                    [
                        "mine"=> false,
                        "read"=> false,
                        "create"=> false,
                        "delete"=> false,
                        "update"=> false,
                        "resource"=> "User"
                    ]
                ],
            ],
        ];

        foreach ($userRoles as $key => $values){

            $newPermission = null;
            $onlyAllowedPermission = null;

            $newPermission = $allPermissions;

            $newPermission[0]['title'] = $values['title'];

            $iteratePermission = $newPermission[0]['permissions'];
            $keySalesP = 0;
            $keyClient = 0 ;
            foreach ($iteratePermission as $key2 => $values2 ){

                if ( ($values['title'] == 'Sales Person' && $values2['resource'] == 'Orders') || ($values['title'] == 'Sales Person' && $values2['resource'] == 'Quotes') || ($values['title'] == 'Sales Person' && $values2['resource'] == 'Collaboration') || ($values['title'] == 'Sales Person' && $values2['resource'] == 'Production') || ($values['title'] == 'Sales Person' && $values2['resource'] == 'Installation') ){

                    $onlyAllowedPermission[0]['permissions'][$keySalesP]['mine'] = true;
                    $onlyAllowedPermission[0]['permissions'][$keySalesP]['read'] = true;
                    $onlyAllowedPermission[0]['permissions'][$keySalesP]['create'] = true;
                    $onlyAllowedPermission[0]['permissions'][$keySalesP]['update'] = true;
                    $onlyAllowedPermission[0]['permissions'][$keySalesP]['resource'] = $values2['resource'];

                    $keySalesP++;
                }

                if ( ($values['title'] == 'Manager' && $values2['resource'] != 'Setting') && ($values['title'] == 'Manager' && $values2['resource'] != 'User') ){

                    $onlyAllowedPermission[0]['permissions'][$key2]['mine'] = true;
                    $onlyAllowedPermission[0]['permissions'][$key2]['read'] = true;
                    $onlyAllowedPermission[0]['permissions'][$key2]['create'] = true;
                    $onlyAllowedPermission[0]['permissions'][$key2]['delete'] = true;
                    $onlyAllowedPermission[0]['permissions'][$key2]['update'] = true;
                    $onlyAllowedPermission[0]['permissions'][$key2]['resource'] = $values2['resource'];

                }


                if ( ($values['title'] == 'Client' && $values2['resource'] == 'Orders') || ($values['title'] == 'Client' && $values2['resource'] == 'Collaboration') ){

                    $onlyAllowedPermission[0]['permissions'][$keyClient]['mine'] = true;
                    $onlyAllowedPermission[0]['permissions'][$keyClient]['read'] = true;
                    $onlyAllowedPermission[0]['permissions'][$keyClient]['resource'] = $values2['resource'];
                    $keyClient++;

                }

            }

            $insertPermission = null;
            if (isset($onlyAllowedPermission[0]['permissions']) && !empty($onlyAllowedPermission[0]['permissions'])){
                $insertPermission[$key]['title'] = $values['title'];
                $insertPermission[$key]['permissions'] = json_encode($onlyAllowedPermission[0]['permissions']);
                \DB::table('user_roles')->insert($insertPermission);
            }

        }

    }
}
