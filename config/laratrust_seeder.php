<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [
            'guru' => 'c,r,u,d',
            'siswa' => 'c,r,u,d',
            'kelas' => 'c,r,u,d',
            'pelajaran' => 'c,r,u,d',
            'nilai' => 'c,r,u,d',
            'rapor' => 'c,r,u,d',
            'user' => 'c,r,u,d',
            'role' => 'c,r,u,d',
            'permission' => 'c,r,u,d',
            'menu' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'wali_kelas' => [
            'guru' => 'c,r,u,d',
            'siswa' => 'c,r,u,d',
            'kelas' => 'c,r,u,d',
            'pelajaran' => 'c,r,u,d',
            'nilai' => 'c,r,u,d',
            'rapor' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'guru' => [
            'guru' => 'c,r,u,d',
            'siswa' => 'c,r,u,d',
            'kelas' => 'c,r,u,d',
            'pelajaran' => 'c,r,u,d',
            'nilai' => 'c,r,u,d',
            'rapor' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'siswa' => [
            'guru' => 'r',
            'siswa' => 'r',
            'kelas' => 'r',
            'pelajaran' => 'r',
            'nilai' => 'r',
            'rapor' => 'r',
            'profile' => 'r,u'
        ],
        'orang_tua' => [
            'guru' => 'r',
            'siswa' => 'r',
            'kelas' => 'r',
            'pelajaran' => 'r',
            'nilai' => 'r',
            'rapor' => 'r',
            'profile' => 'r,u'
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
