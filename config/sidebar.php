<?php

return [
    'admin' => [
        [
            'items' => [
                [
                    'name' => 'Dashboard',
                    'url' => '/admin/dashboard',
                    'icon' => 'element-11'
                ]
            ]
        ],
        [
            'group' => 'MANAGE',
            'items' => [
                [
                    'name' => 'Customer',
                    'icon' => 'profile-user',
                    'sub' => [
                        [
                            'name' => 'Add New Contact',
                            'url' => '/customer/add',
                            'icon' => 'add-item'
                        ],
                        [
                            'name' => 'List Contact',
                            'url' => '/#',
                            'icon' => 'address-book'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
