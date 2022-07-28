<div class="d-flex justify-content-between">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold ml-0 pl-2 {{ $tab == 'Database Backups' ? 'active' : ''}}" href="{{ route('infrastructure.index') }}"><i class="fa fa-users"></i>&nbsp;Database Backups</a>
        </li>
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold {{ $tab == 'EC2 Instances' ? 'active' : ''}}" href="{{ route('infrastructure.get-instances') }}"><i class="fa fa-users"></i>&nbsp;EC2 Instances</a>
        </li>
    </ul>
    <div>
        <a target="_blank" href="https://ap-south-1.console.aws.amazon.com/console" class="btn btn-info text-white">AWS console</a>
    </div>
</div>
