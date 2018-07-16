@php
$menuItems = [
    [
        'name' => 'Projects',
        'route' => 'volunteer.opportunities'
    ],

    [
        'name' => 'Applications',
        'route' => ['volunteer.applications.index', 'applications.volunteer.edit']
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
            @if(is_array($item['route']))
                <a class="nav-item nav-link {{ ( in_array($requestRoute, $item['route'] ) ) ? 'active' : '' }}" href="{{ route($item['route'][0]) }}">
                    <i class="fa fa-list-ul"></i>&nbsp;{{$item['name']}}
                </a>
            @else
                <a class="nav-item nav-link {{ $requestRoute == $item['route'] ? 'active' : '' }}" href="{{ route($item['route']) }}">
                    <i class="fa fa-list-ul"></i>&nbsp;
                    {{$item['name']}}
                </a>
            @endif
        </li>
    @endforeach
</ul>