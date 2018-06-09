<div class="d-inline text-danger c-pointer font-weight-bold m-5"  @click="toggleEvaluationFrame()">Evaluation</div>
<div class="card border-dark inline-card inline-evaluation" v-cloak v-show="showEvaluationFrame">
    <div class="card-header bg-warning">
        <ul class="nav justify-content-start">
            <li class="nav-item">
                <b><span class="c-pointer text-primary" @click="toggleEvaluationFrame()">Close</span></b>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="form-row">
            @foreach($applicationEvaluations as $evaluation)
                <div class="form-group col-md-10 offset-md-1">
                    <b>{{ $evaluation->evaluationParameter->name }}</b>
                    <div>
                        {{ $evaluation->evaluationOption->value }}
                        <br>
                        {{ $evaluation->comment }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>