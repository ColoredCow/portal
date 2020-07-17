<div class="card border-dark bg-theme-white inline-card inline-evaluation" v-cloak v-show="showEvaluationFrame">
    <div class="card-header bg-dark text-white">
        <ul class="nav justify-content-start">
            <li class="nav-item">
                <b>Application Evaluation</b>
            </li>
            <li class="nav-item mx-2">
               <a href="{{ route('hr.evaluation') }}" class="c-pointer text-primary text-decoration-none">
                    <span>Edit</span>
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item mx-2 ml-auto">
                <span class="c-pointer text-white fz-22" @click="toggleEvaluationFrame()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
            </li>
        </ul>
    </div>
    <div class="card-body" id="application_evaluation_body">
    </div>
</div>
