<?php

return [
    'admin' => [
        [
            'items' => [
                [
                    'name' => 'dashboard',
                    'title' => 'Dashboard',
                    'url' => '/admin/dashboard',
                    'icon' => 'element-11',
                ],
            ],
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
                            'name' => 'customer.create',
                            'title' => 'Add New Contact',
                            'url' => '/admin/customer/create',
                            'icon' => 'add-item',
                        ],
                        [
                            'name' => 'customer.index',
                            'title' => 'List Contact',
                            'url' => '/admin/customer',
                            'icon' => 'address-book',
                        ],
                    ],
                ],
            ],
        ],
        [
            'items' => [
                [
                    'name' => 'prepaid',
                    'title' => 'Prepaid',
                    'icon' => 'bill',
                    'sub' => [
                        [
                            'name' => 'prepaid.user',
                            'title' => 'Prepaid Users',
                            'url' => '/admin/prepaid/user',
                            'icon' => 'people',
                        ],
                        [
                            'name' => 'prepaid.voucher',
                            'title' => 'Prepaid Vouchers',
                            'url' => '/admin/prepaid/voucher',
                            'icon' => 'discount',
                        ],
                        [
                            'name' => 'prepaid.refill',
                            'title' => 'Refill Account',
                            'url' => '/admin/prepaid/refill',
                            'icon' => 'dollar',
                        ],
                        [
                            'name' => 'prepaid.recharge',
                            'title' => 'Recharge Account',
                            'url' => '/admin/prepaid/recharge',
                            'icon' => 'dollar',
                        ],
                        [
                            'name' => 'prepaid.refill-balance',
                            'title' => 'Refill Balance',
                            'url' => '/admin/prepaid/refill-balance',
                            'icon' => 'wallet',
                        ],
                    ],
                ],
            ],
        ],
        [
            'items' => [
                [
                    'name' => 'service',
                    'title' => 'Services',
                    'icon' => 'box',
                ],
            ],
        ],
        [
            'items' => [
                [
                    'name' => 'network',
                    'title' => 'Network',
                    'icon' => 'technology-4',
                    'sub' => [
                        [
                            'name' => 'network.router',
                            'title' => 'Routers',
                            'icon' => 'router',
                        ],

                        [
                            'name' => 'network.pool',
                            'title' => 'IP Pool',
                            'icon' => 'devices',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
