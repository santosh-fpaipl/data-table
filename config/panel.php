<?php

return [

    'sidelinks' => [
        0 => [
            'name' => 'Dashboard',
            'route' => 'home',
            'position' => 1,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
        1 => [
            'name' => 'Users',
            'route' => 'users.index',
            'position' => 2,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
        // 2 => [
        //     'name' => 'Profiles',
        //     'route' => 'profiles.index',
        //     'position' => 2,
        //     'root' => true,
        //     'parent_id' => null,
        //     'access' => 'user-role',
        // ],
        3 => [
            'name' => 'Categories',
            'route' => 'categories.index',
            'position' => 3,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
        4 => [
            'name' => 'Products',
            'route' => 'products.index',
            'position' => 4,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
        5 => [
            'name' => 'Orders',
            'route' => 'orders.index',
            'position' => 4,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
        6 => [
            'name' => 'Collections',
            'route' => 'collections.index',
            'position' => 3,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
    ],

    'userlinks' => [
        0 => [
            'name' => 'Dashboard',
            'route' => 'home',
            'position' => 1,
            'root' => true,
            'parent_id' => null,
        ],
        1 => [
            'name' => 'Update Password',
            'route' => 'web.user-password',
            'position' => 1,
            'root' => true,
            'parent_id' => null,
        ],
        2 => [
            'name' => 'Update Profile',
            'route' => 'web.user-profile-information',
            'position' => 1,
            'root' => true,
            'parent_id' => null,
        ],
       
    ],
];