<div>
    <div class="card-header d-flex mb-4 c-pointer" data-toggle="collapse" data-target="#project-stages">
        <h4>Project Stages</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>
    <div class="collapse" id="project-stages">
        <div class="mt-4">
            <form id="stage-form" v-on:submit.prevent="submitForm">
                @csrf
                <div class="card">
                        <table class="table mt-5" v-for="(stage, index) in stages" :key="index">
                            <tbody>
                                    <tr class="bg-theme-gray-lightest d-flex justify-content-between flex-wrap">
                                        <td>@{{ index + 1 }}</td>
                                        <td>
                                            <p class="fz-16 font-weight-bold">Stage Name</p>
                                            <input v-if="isEditing(index)" type="text" v-model="stage.stage_name" @input="markStageAsUpdated(stage)" class="form-control fz-16" required :disabled="!isEditing(index)">
                                            <p v-else class="max-w-100">@{{ stage.stage_name }}</p>
                                        </td>
                                        <td v-if="stage.initialStatus === 'completed' && stage.id">
                                            <p class="fz-16 font-weight-bold">Start Date</p>
                                            <input v-if="isEditing(index)" type="date" :value="formattedDate(stage.start_date)" class="form-control fz-14" disabled>
                                            <p v-else class="fz-16">@{{ formatDisplayDate(stage.start_date) }}</p>
                                        </td>
                                        <td>
                                        <p class="fz-16 font-weight-bold">Expected End Date</p>
                                            <input v-if="isEditing(index)" type="date" v-model="stage.expected_end_date" class="form-control fz-14" required :disabled="!isEditing(index)">
                                            <p v-else class="fz-16">@{{ formatDisplayDate(stage.expected_end_date) }}</p>
                                        </td>
                                        <td v-if="stage.initialStatus === 'completed' && stage.id">
                                            <p class="fz-16 font-weight-bold">Actual End Date</p>
                                            <input v-if="isEditing(index)" type="date" :value="formattedDate(stage.end_date)" class="form-control fz-14" disabled>
                                            <p v-else class="fz-16">@{{ formatDisplayDate(stage.end_date) }}</p>
                                        </td>
                                        <td>
                                            <p class="fz-16 font-weight-bold">Status</p>
                                            <select @change="updateStatus($event.target.value, index)" v-model="stage.status" :class="[dropdownClass(stage.status), 'fz-14']" :disabled="!isEditing(index)">
                                                <option value="pending" :disabled="stage.status === 'pending'">Pending</option>
                                                <option value="started" :disabled="stage.status === 'started'">Started</option>
                                                <option value="completed" :disabled="stage.status === 'completed'" v-if="stage.status !== 'pending'">Completed</option>
                                                <option value="overdue" disabled v-if="new Date(stage.expected_end_date) < new Date(currentDate)">Overdue</option>
                                            </select>
                                        </td>
                                        <td>
                                            <p class="fz-16 font-weight-bold">Comments</p>
                                            <textarea v-model="stage.comments" @input="markStageAsUpdated(stage)" :class="{'d-none': !isEditing(index), 'form-control': true, 'fz-16': true, 'min-h-100': true }" :id="'stage-comments-' + index" :disabled="!isEditing(index)"></textarea>
                                            <p :class="{'d-none': isEditing(index), 'max-w-200': true }" @input="markStageAsUpdated(stage)" @change="markStageAsUpdated(stage)" @blur="markStageAsUpdated(stage)" v-html="stage.comments"></p>
                                        </td>
                                        <td>
                                            <p class="fz-16 font-weight-bold">Action</p>
                                            <button type="button" @click="deleteStage(stage)" class="btn btn-danger px-2 py-1 mb-1"><i class="fa fa-trash"></i></button>
                                            <button type="button" @click="editStage(index)" class="btn btn-warning px-2 py-1 mb-1"><i class="fa fa-pencil"></i></button>
                                        </td>
                                    </tr>
                                    <tr v-if="stage.duration" class="bg-theme-gray-lightest">
                                        <td colspan="8">
                                            <span class="font-weight-bold mr-2">Duration:</span>
                                            <span v-html="calculateDuration(stage)" class="border-0 w-50p" disabled></span>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
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
