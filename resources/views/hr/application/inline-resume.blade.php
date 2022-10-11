<span class="c-pointer text-primary" @click="toggleResumeFrame()">
    <i class="fa fa-file fa-2x"></i></span>
<div class="card shadow inline-card inline-resume" id="sliding_resume" v-cloak v-show="showResumeFrame">
    <div class="card-header py-1">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <i class="c-pointer text-primary fa fa-flag fz-18" aria-hidden="true" data-toggle="modal"
                    data-target="#responseModal"></i>
            </li>
            <li class="nav-item">
                <a class="nav-link py-0" href="{{ $resume }}#zoom=100" target="_blank">
                    <i class="fa fa-external-link fz-18" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item">
                <span class="c-pointer text-primary" @click="toggleResumeFrame()">
                    <i class="fa fa-times fz-20" aria-hidden="true"></i>
                </span>
            </li>
        </ul>
    </div>
    <div class="card-body p-0">
        <iframe src="{{ $resume }}#zoom=80"></iframe>
    </div>
</div>
