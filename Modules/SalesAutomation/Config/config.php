<?php

return [
    'name' => 'SalesAutomation',
    'tabs' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'route' => 'salesautomation.index',
            'active' => ['salesautomation.index'],
        ],
        'sales-area' => [
            'label' => 'Sales Area',
            'route' => 'sales-area.index',
            'active' => ['sales-area.index', 'sales-area.create', 'sales-area.edit'],
        ],
        'client-database' => [
            'label' => 'Client Database',
            'route' => '',
            'active' => [],
        ],
        'settings' => [
            'label' => 'Settings',
            'route' => 'sales-characteristic.index',
            'active' => ['sales-characteristic.index', 'sales-characteristic.create', 'sales-characteristic.edit'],
        ],
    ],
    'sales-area' => [
        'paginate' => 10,
    ],
    'sales-characteristic' => [
        'paginate' => 10,
        'types' => [
            'int' => 'Numeric',
            'float' => 'Decimal',
            'text' => 'Text',
        ],
    ],
];
