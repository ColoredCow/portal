<a href="#" data-trigger="resume"><i class="fa fa-file fa-2x"></i></a>
<div class="card border-dark inline-resume hidden">
    <div class="card-header bg-warning">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <b><a class="nav-link" href="{{ $resume }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Open in a New Tab</a></b>
            </li>
            <li class="nav-item">
                <b><a class="nav-link" href="#" data-trigger="resume">Close</a></b>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <iframe src="{{ $resume }}"></iframe>
    </div>
</div>