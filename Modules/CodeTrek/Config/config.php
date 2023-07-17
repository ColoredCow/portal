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
        'introductory-call' => [
            'label' => 'Introductory Call',
            'slug'  => 'introductory-call',
            'class' => 'badge badge-warning'
        ],
        'preparatory' => [
            'label' => 'Preparatory',
            'slug'  => 'preparatory',
            'class' => 'badge badge-info'
        ],
        'level-1' =>[
            'label' =>'Level-1',
            'slug'  =>'level-1',
            'class' => 'badge badge-primary'
        ],
        'level-2' =>[
            'label' =>'Level-2',
            'slug'  =>'level-2',
            'class' => 'badge badge-secondary'
        ],
        'level-3'   =>[
            'label' =>'Level-3',
            'slug'  =>'level-3',
            'class' => 'badge badge-dark'
        ],
        'onboarded'   =>[
            'label' =>'Onboarded',
            'slug'  =>'onboarded',
            'class' => 'badge badge-success'
        ],
    ],
    'domain' => [
        'engineering' => [
            'label' => 'Engineering',
            'slug' => 'engineering',
        ],
        'design' => [
            'label' => 'Design',
            'slug' => 'design',
        ],
    ]
];
