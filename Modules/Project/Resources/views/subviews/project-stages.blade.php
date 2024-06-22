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
                            <div class="col-2">Start Date</div>
                            <div class="col-2">End Date</div>
                            <div class="col-2">Status</div>
                            <div class="col-2">Comment</div>
                            <div class="col-1">Action</div>
                        </div>
                    </div>
                    <div class="card-body px-1" v-for="(stage, index) in stages" :key="index">
                        <div class="row bg-theme-gray-lightest py-2 mx-0">
                            <div class="col-1">@{{ index + 1 }}</div>
                            <div class="col-2">
                                <input type="text" v-model="stage.stage_name" @input="markStageAsUpdated(stage)" class="form-control fz-16" required :disabled="!isEditing(index)">
                            </div>
                            <div class="col-2">
                                <input type="date" :value="formattedDate(stage.start_date)" class="form-control fz-16" disabled>
                            </div>
                            <div class="col-2">
                                <input type="date" :value="formattedDate(stage.end_date)" class="form-control fz-16" disabled>
                            </div>
                            <div class="col-2">
                                <div class="checkbox-wrapper-19">
                                    <div>Mark to Start</div>
                                    <input type="checkbox"  @input="updateStatus('started', index)" v-model="stage.started" :id="'cbtest-19-start-' + index" :disabled="!isEditing(index)">
                                    <label :for="'cbtest-19-start-' + index" class="check-box"></label>
                                </div>
                                <div class="checkbox-wrapper-19" v-if="stage.status !== 'pending'">
                                    <div>Check to End</div>
                                    <input type="checkbox" @input="updateStatus('completed', index)" v-model="stage.completed" :id="'cbtest-19-end-' + index" :disabled="!isEditing(index)">
                                    <label :for="'cbtest-19-end-' + index" class="check-box"></label>
                                </div>
                            </div>
                            <div class="col-2">
                                <textarea v-model="stage.comments" @input="markStageAsUpdated(stage)" class="form-control fz-14 min-h-100" :disabled="!isEditing(index)"></textarea>
                            </div>
                            <div class="col-1 p-0 d-flex">
                                <span class="mr-1"><button type="button" @click="deleteStage(stage)" class="btn btn-danger px-2 py-1"><i class="fa fa-trash"></i></button></span>
                                <span><button type="button" @click="editStage(index)" class="btn btn-warning px-2 py-1"><i class="fa fa-pencil"></i></button></span>
                            </div>
                        </div>
                        <div class="row bg-theme-gray-lightest py-2 mx-0">
                            <div class="col" v-if="stage.duration">
                                <span class="font-weight-bold mr-2">Duration</span>
                                <input type="text" :value="convertDuration(stage.duration)" class="border-0" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mx-0">
                        <div class="col">
                            <button type="button" @click="addStage" class="btn btn-success"><span class="pr-2"><i class="fa fa-plus"></i></span>Add Stage</button>
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