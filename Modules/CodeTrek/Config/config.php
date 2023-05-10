<?php

return [
    'name' => 'CodeTrek',
    'status' => [
        'active' =>[
            'label' => 'Active',
            'slug'  => 'active'
        ],
        'inactive' =>[
            'label' => 'Inactive',
            'slug'  => 'inactive'
        ],
        'completed' =>[
            'label' => 'Completed',
            'slug'  => 'completed'
        ],
    ],
    'rounds' =>[
        'preparatory' => [
            'label' => 'Preparatory',
            'slug' => 'Preparatory',
            'class' => 'badge badge-primary'
        ],
        'level-1' =>[
            'label' =>'Level-1',
            'slug'  =>'level-1',
            'class' => 'badge badge-secondary'
        ],
        'level-2' =>[
            'label' =>'Level-2',
            'slug'  =>'level-2',
            'class' => 'badge badge-warning'
        ],
        'level-3'   =>[
            'label' =>'Level-3',
            'slug'  =>'level-3',
            'class' => 'badge badge-success'
        ],
        'onboard'   =>[
            'label' =>'Onboarded',
            'slug'  =>'onboarded',
            'class' => 'badge badge-info'
        ],
    ]
];
