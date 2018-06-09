<div class="d-inline text-danger c-pointer"  @click="toggleEvaluationFrame()">Application Evaluation</div>
<div class="card border-dark inline-card inline-evaluation" v-cloak v-show="showEvaluationFrame">
    <div class="card-header bg-warning">
        <ul class="nav justify-content-start">
            <li class="nav-item">
                <b>Application Evaluation</b>
            </li>
            <li class="nav-item mx-2">
                <b><span class="c-pointer text-danger" @click="toggleEvaluationFrame()">Close</span></b>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @foreach($applicationEvaluations as $evaluation)
                <li class="list-group-item">
                    <b>{{ $evaluation->evaluationParameter->name }}</b>
                    <div>
                        {{ $evaluation->evaluationOption->value }}
                        <br>
                        {{ $evaluation->comment }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>