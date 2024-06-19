<div id="stages_app">
    <div class="card-header d-flex mb-4 c-pointer" data-toggle="collapse" data-target="#project-stages">
        <h4>Project Stages</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>
    <div class="collapse" id="project-stages">
        <div class="mt-4">
            <form id="stage-form" v-on:submit.prevent="submitForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3 fz-16 font-weight-bold align-items-center">
                            <div class="col-1">S. No.</div>
                            <div class="col-2">Stage Name</div>
                            <div class="col-4">Comment</div>
                            <div class="col-2">Start Date</div>
                            <div class="col-2">End Date</div>
                            <div class="col-1">Status</div>
                        </div>
                    </div>
                    <div class="card-body" v-for="(stage, index) in stages" :key="index">
                        <div class="row bg-theme-gray-lightest py-2 mx-0">
                            <div class="col-1">@{{ index + 1 }}</div>
                            <div class="col-2">
                                <input type="text" v-model="stage.stage_name" @input="markStageAsUpdated(stage)" class="form-control fz-16" required>
                            </div>
                            <div class="col-4">
                                <textarea v-model="stage.comments" @input="markStageAsUpdated(stage)" class="form-control h-100"></textarea>
                            </div>
                            <div class="col-2">
                                <input type="date" :value="formattedDate(stage.created_at)" class="form-control fz-16" disabled>
                            </div>
                            <div class="col-2">
                                <input type="date" :value="formattedDate(stage.end_date)" class="form-control fz-16" disabled>
                            </div>
                            <div class="col-1">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" @input="markStageAsUpdated(stage)" v-model="stage.status" :true-value="'completed'" :false-value="'pending'" :id="'cbtest-19-' + index" />
                                    <label :for="'cbtest-19-' + index" class="check-box"></label>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" @click="deleteStage(stage)" class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mx-0">
                        <div class="col">
                            <button type="button" @click="addStage" class="btn btn-success"><span class="pr-2"><i class="fa fa-plus"></i></span>Add another stage</button>
                        </div>
                    </div>
                    <div class="row mt-3 mx-0 bg-theme-mud-light py-3">
                        <div class="col-6">
                            <input type="hidden" name="project_id" :value="projectId">
                            <button type="submit" class="btn btn-primary w-100" :disabled="submitButton">Save</button>
                        </div>
                        <div class="col-6">
                            <div :class="{'d-none': !loaderVisible, 'text-center z-index-1 left-0 position-absolute': true}" id="preloader">
                                <div class="spinner-border position-relative">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>