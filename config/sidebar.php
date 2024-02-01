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
                            'name' => 'prepaid.refill-account',
                            'title' => 'Refill Account',
                            'url' => '/admin/prepaid/refill-account',
                            'icon' => 'dollar',
                        ],
                        [
                            'name' => 'prepaid.user.create',
                            'title' => 'Recharge Account',
                            'url' => '/admin/prepaid/user/add',
                            'icon' => 'dollar',
                        ],
                        // [
                        //     'name' => 'prepaid.refill-balance',
                        //     'title' => 'Refill Balance',
                        //     'url' => '/admin/prepaid/refill-balance',
                        //     'icon' => 'wallet',
                        // ],
                    ],
                ],
            ],
        ],
        [
            'items' => [
                [
                    'name' => 'service',
                    'title' => 'Services',
                    'icon' => 'cube-2',
                    'sub' => [
                        [
                            'name' => 'service.hotspot',
                            'title' => 'Hotspot Plans',
                            'url' => '/admin/service/hotspot',
                            'icon' => 'tech-wifi',
                        ],
                        [
                            'name' => 'service.pppoe',
                            'title' => 'PPPoE Plans',
                            'url' => '/admin/service/pppoe',
                            'icon' => 'router',
                        ],
                        [
                            'name' => 'service.bandwidth',
                            'title' => 'Bandwidth Plans',
                            'url' => '/admin/service/bandwidth',
                            'icon' => 'filter',
                        ],
                        // [
                        //     'name' => 'service.balance',
                        //     'title' => 'Balance Plans',
                        //     'url' => '/admin/service/balance',
                        //     'icon' => 'wallet',
                        // ],
                    ],
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
                            'url' => '/admin/network/router',
                        ],

                        [
                            'name' => 'network.pool',
                            'title' => 'IP Pool',
                            'icon' => 'devices',
                            'url' => '/admin/network/pool',
                        ],
                    ],
                ],
            ],
        ],
        [
            'group' => 'SYSTEM',
            'items' => [
                [
                    'name' => 'report',
                    'title' => 'Reports',
                    'icon' => 'notepad',
                    'sub' => [
                        [
                            'name' => 'report.daily',
                            'title' => 'Daily Reports',
                            'url' => '/admin/report/daily',
                            'icon' => 'tablet-book',
                        ],
                        [
                            'name' => 'report.period',
                            'title' => 'Period Reports',
                            'url' => '/admin/report/period',
                            'icon' => 'filter-tablet',
                        ],
                        [
                            'name' => 'report.activation',
                            'title' => 'Activation History',
                            'url' => '/admin/report/activation',
                            'icon' => 'questionnaire-tablet',
                        ],
                    ],
                ],
            ],

        ],
    ],
    'customer' => [
        [
            'items' => [
                [
                    'name' => 'dashboard',
                    'title' => 'Dashboard',
                    'url' => '/dashboard',
                    'icon' => 'element-11',
                ],
                [
                    'name' => 'voucher',
                    'title' => 'Voucher',
                    'icon' => 'note',
                ],
                [
                    'name' => 'package',
                    'title' => 'Buy Package',
                    'icon' => 'handcart',
                ],
                [
                    'name' => 'history.order',
                    'title' => 'Order History',
                    'icon' => 'document',
                ],
                [
                    'name' => 'history.activation',
                    'title' => 'Activation History',
                    'icon' => 'questionnaire-tablet',
                ],
            ],
        ],
    ],
];
