<div class="card border-dark inline-card inline-evaluation" v-cloak v-show="showEvaluationFrame">
    <div class="card-header bg-dark text-white">
        <ul class="nav justify-content-start">
            <li class="nav-item">
                <b>Application Evaluation</b>
            </li>
            <li class="nav-item mx-2">
                <b><span class="c-pointer text-danger" @click="toggleEvaluationFrame()">Close</span></b>
            </li>
        </ul>
    </div>
    <div class="card-body" id="application_evaluation_body">
    </div>
</div>