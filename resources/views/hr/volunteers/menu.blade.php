@php
$menuItems = [
    [
        'name' => 'Projects',
        'route' => 'volunteer.opportunities'
    ],

    [
        'name' => 'Applications',
        'route' => 'volunteer.applications.index'
    ],

    [
        'name' => 'Reports',
        'route' => 'volunteers.reports'
    ],

    [
        'name' => 'Campaigns',
        'route' => 'volunteers.campaigns'
    ],
];

@endphp
<ul class="nav nav-pills">
    @foreach($menuItems as $item) 
        <li class="nav-item">
            <a class="nav-item nav-link {{ $requestRoute == $item['route'] ? 'active' : '' }}" href="{{ route($item['route']) }}"><i class="fa fa-list-ul"></i>&nbsp;{{$item['name']}}</a>
        </li>
    @endforeach
</ul>