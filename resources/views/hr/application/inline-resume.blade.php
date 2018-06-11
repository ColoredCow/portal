<span class="c-pointer text-primary" @click="toggleResumeFrame()"><i class="fa fa-file fa-2x"></i></span>
<div class="card border-dark inline-card inline-resume" id="sliding_resume" v-cloak v-show="showResumeFrame">
    <div class="card-header bg-warning">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <b><a class="nav-link py-0" href="{{ $resume }}#zoom=100" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Open in a New Tab</a></b>
            </li>
            <li class="nav-item">
                <b><span class="c-pointer text-primary" @click="toggleResumeFrame()">Close</span></b>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <iframe src="{{ $resume }}#zoom=50"></iframe>
    </div>
</div>