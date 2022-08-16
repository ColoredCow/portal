<div class="card">
    <a id='working_days_in_month' :data-days-count='workingDaysInMonth'></a>
    <div id="project_team_member_form">
        <form  action="{{ route('project.update', $project) }}" method="POST" id="updateProjectTeamMemberForm">
            @csrf
            <input type="hidden" value="project_team_members" name="update_section">

            <div class="card-body form-body">
                <div class="row mb-1">
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-4">
                        <div class="text-center fz-16 font-weight-bold">
                            Expected Efforts In Hours
                        </div>
                    </div>
                </div>
                <div class="row mb-3 fz-16 font-weight-bold align-items-center">
                    <div class="">
                        S. No.
                    </div>
                    <div class="col-2">
                        Team Members
                    </div>
                    <div class="col-2">
                        Designations
                    </div>                
                    <div class="col-1">
                        Daily
                        (@{{ totalDailyEffort }})
                    </div>
                    <div class="col-1">
                        Weekly
                        (@{{ totalDailyEffort*5 }})
                    </div>
                    <div class="col-1">
                        Monthly
                        (@{{ totalDailyEffort*workingDaysInMonth }})
                    </div>
                    <div class="col-2 text-center">
                        Billing Engagement %
                    </div>
                </div>

                <div class="row mb-3 bg-theme-gray-light pt-2" v-for="(projectTeamMember, index) in projectTeamMembers" :key="projectTeamMember.id">
                    <input hidden type="text" :name="`project_team_member[${index}][project_team_member_id]`" :value="projectTeamMember.pivot.id" class="form-control">
                    <div class="mx-2 pt-2 font-weight-bold">
                        @{{ index + 1 }}.
                    </div>
                    <div class="col-2">
                        <select v-model="projectTeamMember.id" :name="`project_team_member[${index}][team_member_id]`" class="custom-select">
                            <option value="">Select team member</option>
                            <option v-for="(teamMember) in users" :value="teamMember.id" :key="teamMember.id">@{{ teamMember.name }}</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select v-model="projectTeamMember.pivot.designation" :name="`project_team_member[${index}][designation]`" class="custom-select">
                            <option value="">Select Designations</option>

                            <option v-for="(designation, key) in designations" :value="key">@{{ designation }}</option>
                        </select>
                    </div>
                    <div class="col-1 daily-effort-div" >

                      <input type="number" @input="updatedDailyExpectedEffort($event, index, 1)" :value="projectTeamMember.pivot.daily_expected_effort" class="form-control daily-effort">
                    </div>

                    <div class="col-1 weekly-effort-div">
                        <input type="number" @input="updatedDailyExpectedEffort($event, index, 5)" :value="projectTeamMember.pivot.weekly_expected_effort" class="form-control weekly-effort">
                    </div>

                    <div class="col-1 monthly-effort-div">
                        <input type="number" @input="updatedDailyExpectedEffort($event, index, workingDaysInMonth)" :value="projectTeamMember.pivot.monthly_expected_effort" class="form-control monthly-effort">
                    </div>
                    <div class="col-2">
                        <input type="number" step="0.01" :name="`project_team_member[${index}][billing_engagement]`" v-model="projectTeamMember.pivot.billing_engagement" class="form-control">
                    </div>
                    <div class="col-1">
                        <button v-on:click="removeProjectTeamMember(index)" type="button" class="btn btn-danger btn-sm mt-1 ml-2 text-white fz-14" {{ $project->status == 'active' ? '' : 'disabled' }} >Remove</button>
                    </div>
                    <div class="d-flex mt-2 ml-9 text-light">
                        <div class="mr-2">
                            <div class="d-flex flex-column form-group">
                                <label class="text-dark font-weight-bold fz-16">Added on</label>
                                <input class="form-control" type="date" :name="`project_team_member[${index}][started_on]`" @input="updateStartDateForTeamMember($event, index)" :value="projectTeamMember.pivot.started_on | toDate">
                            </div>
                        </div>
                        <div>
                            <div class="d-flex flex-column form-group">
                                <label class="text-dark font-weight-bold fz-16">Ended on</label>
                                <input class="form-control" type="date" :name="`project_team_member[${index}][ended_on]`" @input="updateEndDateForTeamMember($event, index)" :value="projectTeamMember.pivot.ended_on | toDate">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <span v-on:click="addNewProjectTeamMember()" style="text-decoration: underline;" class="text-underline btn" >Add new team member</span>
                </div>

                <hr class='bg-dark mt-4 mb-5 pb-0.5'>

                <div class="bg-theme-gray-lighter card mt-3">
                    <h4 class="ml-3 mt-2 mb-2 font-weight-bold">Team Members History</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>Team Members</th>
                            <th>Designation</th>
                            <th>Added on</th>
                            <th>Ended on</th>
                        </tr>
                        @foreach ($project->getInactiveTeamMembers as $inactiveTeamMember)
                        <tr>
                            <th class="font-weight-normal"><img src="{{ $inactiveTeamMember->user->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">{{$inactiveTeamMember->user->name}}</th>
                            <th class="font-weight-light">{{ ucwords(str_replace('_', ' ', $inactiveTeamMember->designation)) }}</th>
                            <th class="font-weight-light">{{ optional($inactiveTeamMember->started_on)->format('Y-m-d') }}</th>
                            <th class="font-weight-light">{{ optional($inactiveTeamMember->ended_on)->format('Y-m-d') }}</th>
                        <tr>
                        @endforeach
                    </table>
                </div>

            </div>

            <div class="card-footer">
                <button type="button" class="btn btn-primary save-btn" v-on:click="updateProjectForm('updateProjectTeamMemberForm')" {{ $project->status == 'active' ? '' : 'disabled' }} >Save</button>
            </div>
        </form>
    </div>

</div>
