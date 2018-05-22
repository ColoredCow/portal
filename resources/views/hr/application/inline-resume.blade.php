<span class="c-pointer text-primary" @click="toggleResume()"><i class="fa fa-file fa-2x"></i></span>
<div class="card border-dark inline-resume" id="sliding_resume" v-bind:class="{ hidden: isHidden }">
    <div class="card-header bg-warning">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <b><a class="nav-link py-0" href="{{ $resume }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Open in a New Tab</a></b>
            </li>
            <li class="nav-item">
                <b><span class="c-pointer text-primary" href="#" @click="toggleResume()">Close</span></b>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <iframe src="{{ $resume }}"></iframe>
    </div>
</div>