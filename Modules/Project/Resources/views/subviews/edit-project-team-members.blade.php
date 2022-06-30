<div class="card">
    <div class="card-header">
    </div>
    <a id='working_days_in_month' :data-days-count='workingDaysInMonth'></a>
    <div id="project_team_member_form">
        <form  action="{{ route('project.update', $project) }}" method="POST" id="update_project_team_member_form">
            @csrf
            <input type="hidden" value="project_team_members" name="update_section">

            <div class="card-body form-body">
                <div class="row mb-1">
                    <div class="col-3">
                    </div>
                    <div class="col-3">
                    </div>
                    <div class="col-3">
                        <div class="text-center fz-16 font-weight-bold">
                            Expected Efforts In Hours
                        </div>
                    </div>
                </div>
                <div class="row mb-3 fz-16 font-weight-bold">
                    <div class="col-3">
                        Team Members
                    </div>
                    <div class="col-3">
                        Designations
                    </div>
                    <div class="col-1">
                        Daily
                    </div>
                    <div class="col-1">
                        Weekly
                    </div>
                    <div class="col-1">
                        Monthly
                    </div>
                </div>

                <div class="row mb-3" v-for="(projectTeamMember, index) in projectTeamMembers" :key="projectTeamMember.id">
                    <input hidden type="text" :name="`project_team_member[${index}][project_team_member_id]`" :value="projectTeamMember.pivot.id" class="form-control">
                    <div class="col-3">
                        <select v-model="projectTeamMember.id" :name="`project_team_member[${index}][team_member_id]`" class="form-control">
                            <option value="">Select team member</option>
                            <option v-for="(teamMember) in users" :value="teamMember.id" :key="teamMember.id">@{{ teamMember.name }}</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select v-model="projectTeamMember.pivot.designation" :name="`project_team_member[${index}][designation]`" class="form-control">
                            <option value="">Select Designations</option>

                            <option v-for="(designation, key) in designations" :value="key">@{{ designation }}</option>
                        </select>
                    </div>
                    <div class="col-1 daily-effort-div" >
                        <input type="number" :name="`project_team_member[${index}][daily_expected_effort]`" :value="projectTeamMember.pivot.daily_expected_effort" class="form-control daily-effort">
                    </div>

                    <div class="col-1 weekly-effort-div">
                        <input type="number" :value="projectTeamMember.pivot.daily_expected_effort*5" class="form-control weekly-effort">
                    </div>

                    <div class="col-1 monthly-effort-div">
                        <input type="number" :value="projectTeamMember.pivot.daily_expected_effort*workingDaysInMonth" class="form-control monthly-effort">
                    </div>
                    <div class="col-1">
                        <button v-on:click="removeProjectTeamMember(index)" type="button" class="btn btn-danger btn-sm mt-1 ml-2 text-white fz-14">Remove</button>
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
                            <th class="font-weight-light">{{ ($inactiveTeamMember->created_at)->format('Y-m-d') }}</th>
                            <th class="font-weight-light">{{ ($inactiveTeamMember->ended_on)->format('Y-m-d') }}</th>
                        <tr>
                        @endforeach
                    </table>
                </div>
                
            </div>

            <div class="card-footer">
                <button type="button" class="btn btn-primary save-btn" v-on:click="updateProjectForm('update_project_team_member_form')">Save</button>
            </div>
        </form>
    </div>

</div>
