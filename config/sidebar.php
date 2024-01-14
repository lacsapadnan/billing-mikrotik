<?php

return [
    'admin' => [
        [
            'items' => [
                [
                    'name' => 'dashboard',
                    'title' => 'Dashboard',
                    'url' => '/admin/dashboard',
                    'icon' => 'element-11'
                ]
            ]
        ],
        [
            'group' => 'MANAGE',
            'items' => [
                [
                    'name' => 'customer',
                    'title' => 'Customer',
                    'icon' => 'profile-user',
                    'sub' => [
                        [
                            'name' => 'Add New Contact',
                            'url' => '/admin/customer/add',
                            'icon' => 'add-item'
                        ],
                        [
                            'name' => 'List Contact',
                            'url' => '/admin/customer',
                            'icon' => 'address-book'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
