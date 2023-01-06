<div class="card border-dark bg-theme-white inline-card inline-evaluation" v-cloak v-show="showEvaluationFrame">
    <div class="card-header bg-dark text-white">
        <ul class="nav justify-content-start d-flex align-items-end">
            <li class="nav-item">
                <strong id="roundName"></strong>
            </li>
            <li class="nav-item mx-1 ml-auto">
                <a href="{{ route('hr.evaluation') }}" class="c-pointer text-white text-decoration-none" target="_blank"
                    title="Edit parameters">
                    <i class="fa fa-pencil-square-o fz-20" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item mx-2">
                <span class="c-pointer text-white" @click="toggleEvaluationFrame()" title="close">
                    <i class="fa fa-times fz-22" aria-hidden="true"></i>
                </span>
            </li>
        </ul>
    </div>
    <div class="card-body" id="application_evaluation_body">
    </div>
</div>
