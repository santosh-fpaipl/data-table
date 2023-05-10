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
            'name' => 'Categories',
            'route' => 'categories.index',
            'position' => 2,
            'root' => true,
            'parent_id' => null,
            'access' => 'user-role',
        ],
        2 => [
            'name' => 'Items',
            'route' => 'items.index',
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