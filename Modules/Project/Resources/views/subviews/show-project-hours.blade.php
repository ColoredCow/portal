<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#project_hours">
        <h4>Project Hours</h4>
    </div>

    <div id="project_hours" class="collapse hide">
        <div class="mt-3 w-75 mx-auto">
            <effort-component project="{{  $project->id }}" cube_js_url="{{  config('constants.cube_js_url') }}" />
        </div>
    </div>
</div>