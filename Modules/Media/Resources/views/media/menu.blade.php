<ul class="nav nav-pills">
    <li>
        <a class="nav-item nav-link {{ Request::is('media*') ? 'active' : '' }}" href="{{ route('media.index')}}"><i class="fa fa-picture-o"></i>&nbsp;Media</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('Tag*') ? 'active' : '' }}" href="{{ route('media.Tag.index') }}"><i class="fa fa-tags"></i>&nbsp;Media Tags</a>
    </li>
</ul>
    