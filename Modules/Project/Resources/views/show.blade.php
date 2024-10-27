@extends('project::layouts.master')
@section('content')
<div class="efforts-sync-loader text-center bg-theme-semi-transparent position-fixed w-full h-full d-none" style="top: 0%; right: 0%; z-index: 9999" id="preloader">
	<div class="spinner-border position-relative" style="top: 40%; border: 0.25em solid #ffff; border-right-color: transparent;" id="spinner">
		<span class="sr-only">Loading...</span>
	</div>
</div>
<div class="container" id="vueContainer">
    <br>
    <div class=" d-flex">
        <h4 class="c-pointer d-inline-block font-weight-bold" v-on:click="counter += 1">Project Name : {{$project->name}}</h4>
        @can('update', $project)
            <a id="view_effort_sheet_badge" target="_self" href="{{route('project.edit', $project )}}" class="btn btn-primary text-white ml-auto">{{ _('Edit') }}</a>
        @endcan
    </div>
    <br>
    <div class="card-header d-flex" data-toggle="collapse" data-target="#resource-engagement" >
        <h4>Resource Engagement</h4>
        <span class ="arrow ml-auto rotate180">&#9660;</span>
    </div>
    <div id="resource-engagement" class= "collapse card mt-3 show">
        <div class="collapes-body">
            <br>
            <div class="container" id="vueContainer">
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mb-1">Current Velocity:</label>
                        </h4>
                        <span class="{{ $project->velocity >= 1 ? 'text-success' : 'text-danger'}} fz-lg-22">{{ $project->velocity }}</span>
                        {{-- <a target="_self" href="{{route('project.effort-tracking', $project )}}" class="btn-sm text-decoration-none btn-primary text-white ml-1 text-light rounded">{{ _('Check FTE') }}</a> --}}
                    </div>
                    <div class="form-group col-md-6 pl-10">
                            <h4 class="d-inline-block">
                                <label for="name" class="font-weight-bold mb-6 ml-1">Effortsheet:</label>
                            </h4>
                            @if($project->effort_sheet_url)
                                <a id="view_effort_sheet_badge" href="{{ $project->effort_sheet_url }}" class="btn-sm btn-primary btn-smtext-white ml-2 text-light rounded"
                                    target="_blank">{{ _('Open Sheet') }}</a>
                            @else
                                <span class="ml-2 fz-lg-22">Not Available</span>
                            @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-12 pl-4">
                        <div class="fz-14 mr-3 mt-1 d-flex justify-content-between">
                            <h4 class="d-inline-block ">
                                <label for="name" class="font-weight-bold">Team Members({{count($project->getTeamMembers)}})</label>
                            </h4>
                        <div class="d-flex">
                            <h4 class="mr-5">
                                <i class="fa fa-spinner fa-spin ml-2 d-none"></i>
                                <i class="ml-2 font-weight-bold fa fa-refresh c-pointer" aria-hidden="true"
                                    @if(auth()->user()->can('finance_invoices.create'))
                                        data-toggle="modal" data-target="#syncEffortsModal"
                                    @else
                                        data-url="{{ route('effort-tracking.refresh', $project) }}"
                                    @endif>
                                </i>
                            </h4>
                                <strong>Timeline:</strong>{{ (Carbon\Carbon::parse($project->client->month_start_date)->format('dS M')) }}
                                -{{ (Carbon\Carbon::parse($project->client->month_end_date)->format('dS M')) }}
                                &nbsp;&nbsp;&nbsp; <strong>Last refreshed at:</strong>{{ (Carbon\Carbon::parse($project->last_updated_at)->setTimezone('Asia/Kolkata')->format('Y-M-d , D h:i:s A')) }}
                        </div>
                        </div>
                            <div class="flex-column flex-md-row d-flex flex-wrap col-md-18 px-0 ml-1 mr-4">
                                <div class="table">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-theme-gray text-light">
                                                <th class="pb-md-3 pb-xl-4 px-9">Name</th>
                                                <th>Expected Billable <br>hrs/WD
                                                    {{-- <div class="ml-lg-3 ml-xl-5 fz-md-10 fz-xl-14">
                                                        ({{$daysTillToday}} Days)
                                                    </div> --}}
                                                </th>
                                                <th>Working Days <br>Total | Completed</th>
                                                <th>Total Efforts Booked
                                                    {{-- <br>Billable | Actual</th> --}}
                                                {{-- <th>Velocity <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."><i class="fa fa-question-circle"></i>&nbsp;</span></th> --}}
                                            </tr>
                                        </thead>
                                        @if($project->teamMembers->first() == null)
                                            </table>
                                            <div class="fz-lg-28 text-center mt-4">No member in the project</div>
                                        @else
                                            <tbody>
                                            @foreach($project->getTeamMembers  as $teamMember)
                                                <tr>
                                                    <th class="fz-lg-20 my-2 px-5 font-weight-normal">
                                                        <span>
                                                            <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation] }}">
                                                            <a href="{{ route('employees.show', optional($teamMember->user->employee)->id) }}">
                                                            <img src="{{ $teamMember->user->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                                                            </a>
                                                        </span>
                                                        <a href="{{ route('employees.show', optional($teamMember->user->employee)->id) }}">
                                                            {{$teamMember->user->name}}
                                                        </a>
                                                    </th>
                                                    <td id="projectHours">{{$teamMember->daily_expected_effort }}</td>
                                                    <td data-toggle="tooltip" title="Start date: {{$teamMember->started_on->format('Y-m-d')}}  {{$teamMember->ended_on != null ? "End date: " . ($teamMember->ended_on->format('Y-m-d')) : ""}}">{{$effortData['totalWorkingDays']}} Days | {{$effortData['daysTillToday']}} Days</td>
                                                    <td>{{$teamMember->current_actual_effort}}hrs
                                                        {{-- | {{$project->getactualEffortOfTeamMember([$teamMember->id])}}hrs</td> --}}
                                                    {{-- <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">{{$teamMember->velocity}}</td> --}}
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            </table>
                                        @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="px-4">
                        <h1 class="font-weight-bold fz-22">Team Member Engagement Stats</h1>
                        <form action="{{ route('project.show', $project) }}" id="FilterForm" method="GET">
                            <div class="d-flex">
                                <div class='form-group mr-4 ml-1 mt-1 w-168'>
                                    <select class="form-control bg-light" name="month"
                                            onchange="document.getElementById('FilterForm').submit();">
                                        @foreach (config('constants.months') as $months => $month)
                                            <option value="{{ $month }}" {{ $effortData['currentMonth'] == $month ? 'selected' : '' }}>
                                                {{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class='form-group mr-4 mt-1 w-168'>
                                    <select class="form-control bg-light" name="year"
                                        onchange="document.getElementById('FilterForm').submit();">
                                        @php $year = now()->year; @endphp
                                        @while ($year != 1999)
                                            <option {{ request()->input('year') == $year ? 'selected=selected' : '' }}
                                                value="{{ $year }}">
                                                {{ $year-- }}
                                            </option>
                                        @endwhile
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div>
                                <div class="mt-4">
                                    <input type="hidden" name="team_members_effort" value="{{ $effortData['teamMembersEffort'] }}">
                                    <input type="hidden" name="workingDays" value="{{ $effortData['workingDaysObject'] }}">
                                    <input type="hidden" name="totalWorkingDays" value="{{ $effortData['totalWorkingDays'] }}">
                                    <input type="hidden" name="users" value="{{ $effortData['users'] }}">
                                    <input type="hidden" name="dailyEffort" value="{{ $dailyEffort }}">
                                    <canvas class="w-full" id="effortTrackingGraph"></canvas>
                                </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    <br>
    <div class="card-header d-flex" data-toggle="collapse" data-target="#approved-pipeline">
        <h4>Approved Pipeline</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>
    <div id="approved-pipeline" class="collapse card mt-3">
        <div class="panel-body">
            <br>
                <div class="form-row">
                        <div class="form-row d-flex justify-content-between">
                            <div class="col-md-5 pl-4 d-flex justify-content-between">
                                <div class="mr-5">
                                    <h4 class="d-inline-block">
                                        <label for="name" class="font-weight-bold mb-6 ml-1">Expected Hours:</label>
                                    </h4>
                                </div>
                                <div class="d-flex">
                                    <div class="pr-10 project-hour text-center">
                                        <span class="fz-lg-22 text-capitalize">Monthly
                                        </span>
                                        <span>{{$totalExpectedHourInMonth}}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="pr-10 project-hour text-center">
                                            <span class="fz-lg-22 text-capitalize">Weekly
                                            </span>
                                            <span>{{$totalWeeklyEffort}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                    <div class="form-row">
                        <div class="form-row d-flex justify-content-between">
                            <div class="col-md-5 pl-4 d-flex justify-content-between">
                                <div class="mr-5">
                                    <h4 class="d-inline-block">
                                        <label for="name" class="font-weight-bold mb-6 ml-1">Hours To Cover:</label>
                                    </h4>
                                </div>
                                <div class="d-flex">
                                    <div class="pr-10 project-hour text-center">
                                        <span class="fz-lg-22 text-capitalize">Monthly
                                        </span>
                                        <span>{{$remainingExpectedEffort}}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="pr-10 project-hour text-center">
                                            <span class="fz-lg-22 text-capitalize">Weekly
                                            </span>
                                            <span>{{round($weeklyHoursToCover,2)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-5 pl-4 d-flex justify-content-between">
                            <h4 class="d-inline-block">
                                <label for="name" class="font-weight-bold mb-6 ml-1">Approved Pipeline:</label>
                                @if ($isApprovedWorkPipelineExist)
                                <span>{{$monthlyApprovedHour}} hrs
                                    @if($monthlyApprovedHour > $weeklyHoursToCover)
                                    <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Approved pipeline is sufficient for this week"><i class="fa fa-info-circle" style="color: green;" aria-hidden="true"></i></span>
                                    @else
                                    <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Approved pipeline is not sufficient for this week"><i class="fa fa-info-circle" style='color: red' aria-hidden="true"></i></span>
                                    @endif
                                </span>
                                @else
                                    <span class="text-capitalize ml-2 text-danger fz-18 font-weight-normal">
                                        ERROR <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Formatting issue with effortsheet"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                    </span>
                                @endif
                            </h4>
                        </div>
                    </div>
            </div>
    </div>
    <br>
    <div class="card-header d-flex" data-toggle="collapse" data-target="#basic-details" >
        <h4>Basic Details</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>

    <div id="basic-details" class="collapse card mt-3">
       <div class="m-5">
        <div class="d-flex" style="flex-wrap: wrap">
            <div class="pr-10 project-hour w-33p mb-10">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold">Start Date:</label>
                </h4>
                <span class="text-capitalize  fz-lg-22">{{ optional($project->start_date)->format('d M Y')}}</span>
            </div>
                <div class="pr-10 project-hour w-33p mb-10">
                    <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold ">End Date:</label>
                    </h4>
                    <span class="text-capitalize  fz-lg-22">{{ optional($project->end_date)->format('d M Y')}}</span>
                </div>
                <div class="pr-10 project-hour w-33p mb-10">
                    <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold ">Project Name:</label>
                    </h4>
                    <span class="text-capitalize  fz-lg-22">{{ $project->name }}</span>
                    @if ($project->is_amc == 1 )
                    <span class="badge badge-pill badge-success mr-1  mt-1">AMC</span>
                    @endif
                </div>
                <div class="pr-10 project-hour w-33p mb-10">
                    <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold">Client Name:</label>
                    </h4>
                    <a href="{{route('client.edit', $project->client->id)}}" class="text-capitalize fz-lg-22">{{ $project->client->name }}</a>
                </div>
                    <div class="pr-10 project-hour w-33p mb-10">
                        <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold ">Status:</label>
                        </h4>
                        <span class="text-capitalize fz-lg-22">{{ $project->status }}</span>
                    </div>
                    <div class="pr-10 project-hour w-33p mb-10">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Billing Cycle:</label>
                        </h4>
                        <span class="text-capitalize fz-lg-22">{{ $project->type }}</span>
                    </div>
                    <div class="pr-10 project-hour w-33p mb-10">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold ">Contract File:</label>
                        </h4>
                        <div class="flex-row">
                            @if ($project->projectContracts->isEmpty() == false)
                            <a id="contract_file"
                            style="{{ $project->projectContracts ? '' : 'd-none' }}"
                            href="{{ route('pdf.show', $project->projectContracts->first()) }}">
                             <span class="text-capitalize fz-lg-22">{{ $project->name}}_contract_{{ optional($project->start_date)->format('d M Y')}}</span>
                             <i class="fa fa-external-link-square fa-1x"></i></a>
                            @endif
                    </div>
        </div>
       </div>
    </div>
</div>
<br>
@can('finance_reports.view')
    <div class="card-header d-flex" data-toggle="collapse" data-target="#contract-history" >
        <h4>Contract History</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>
    <div class="collapse" id="contract-history">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-50p" scope="col">File</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project->projectContracts as $contract)
                    <tr>
                        <td> <a href="{{ route('pdf.show', $contract->first()) }}"
                                target="_blank">{{ basename($contract->contract_file_path) }}</a></td>
                        <td>{{ optional($project->start_date)->format('d M Y') ?? '-' }}</td>
                        <td>{{ optional($project->end_date)->format('d M Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endcan
</div>
<div class="container" id="stages_app">
    @include('project::subviews.project-stages')
</div>
<div>
    @include('project::modals.efforts-sync-modal')
</div>
<br>
<br>
@endsection
@section('vue_scripts')
<script>
    new Vue({
        el: '#stages_app',
        data() {
            return {
                stages: [],
                deletedStages: [],
                projectId: "{{ $project->id }}",
                loaderVisible: false,
                submitButton: true,
                editButtonStates: {},
                dropdownVisibility: {},
                currentDate: "{{ now()->toDateString() }}"
            };
        },
        methods: {
            convertToDateTime(seconds) {
                const units = [
                    { label: 'd', value: 24 * 3600 },
                    { label: 'h', value: 3600 },
                    { label: 'm', value: 60 },
                    { label: 's', value: 1 }
                ];
                return units.map(unit => {
                    const count = Math.floor(seconds / unit.value);
                    seconds %= unit.value;
                    return count ? `${count}${unit.label}` : '';
                }).filter(Boolean).join(' ');
            },
            calculateDuration(stage) {
                const duration = this.convertToDateTime(stage.duration);
                const delay = this.calculateDelay(stage.end_date, stage.expected_end_date);
                return delay ? `${duration} (<strong>Delay: </strong>${delay})` : duration;
            },
            calculateDelay(endDate, expectedEndDate) {
                const delayDays = Math.floor((new Date(endDate).setHours(0, 0, 0, 0) - new Date(expectedEndDate).setHours(0, 0, 0, 0)) / 1000);
                return delayDays > 0 ? this.convertToDateTime(delayDays) : null;
            },
            formattedDate(dateTime) {
                return dateTime ? new Date(dateTime).toISOString().split('T')[0] : '';
            },
            formatDisplayDate(date) {
                return new Date(date).toDateString().split(' ').slice(1).join(' ');
            },
            formatDateTime(dateTime) {
                var date = new Date(dateTime);
                var datePart = date.toISOString().split('T')[0];
                var timePart = date.toTimeString().split(' ')[0].slice(0, 5);
                return `${datePart}T${timePart}`;
            },
            addStage() {
                const newIndex = this.stages.length;
                this.editStage(newIndex);
                this.submitButton = false;
                this.stages.push({
                    stage_name: '',
                    comments: '',
                    start_date: '',
                    expected_end_date: '',
                    end_date: '',
                    status: 'pending'
                });
                this.$nextTick(() => this.initializeRichTextEditor(newIndex));
            },
            editStage(index) {
                this.submitButton = false;
                this.$set(this.editButtonStates, index, true);
                this.initializeRichTextEditor(index);
            },
            isEditing(index) {
                return this.editButtonStates[index] || false;
            },
            deleteStage(stage) {
                this.submitButton = false;
                if (!this.deletedStages.includes(stage.id) && stage.id) {
                    this.deletedStages.push(stage.id);
                }
                var index = this.stages.indexOf(stage);
                if (index !== -1) {
                    this.stages.splice(index, 1);
                }
                this.$nextTick(() => {
                    tinymce.remove();
                    this.stages.forEach((stage, index) => {
                        if (this.isEditing(index)) {
                            this.initializeRichTextEditor(index);
                        }
                    });
                });
            },
            markStageAsUpdated(stage) {
                if (stage.id) stage.isUpdated = true;
            },
            updateStatus(status, index) {
                const stage = this.stages[index];
                stage.status = status;
                if (status === 'started') {
                    if (status !== this.stages[index].initialStatus) {
                        this.stages[index].start_date = stage.start_date || this.formatDateTime(new Date());
                    }
                    stage.end_date = null;
                } else if (status === 'completed') {
                    if ('started' !== this.stages[index].initialStatus) {
                        this.stages[index].start_date = stage.start_date || this.formatDateTime(new Date());
                    }
                    stage.end_date = stage.end_date || this.formatDateTime(new Date());
                } else if (status === 'pending') {
                    stage.start_date = null;
                    stage.end_date = null;
                }
                this.markStageAsUpdated(stage);
            },
            submitForm() {
                const newStages = this.stages.filter(stage => !stage.id).map(this.cleanStageData);
                const updatedStages = this.stages.filter(stage => stage.id && stage.isUpdated).map(this.cleanStageData);

                this.toggleLoader();
                axios.post('{{ route('projects.manage-stage') }}', {
                    newStages,
                    updatedStages,
                    deletedStages: this.deletedStages,
                    project_id: this.projectId,
                    _token: '{{ csrf_token() }}'
                }).then(() => {
                    this.toggleLoader();
                    this.$toast.success('Stages Managed Successfully!');
                    location.reload(true);
                }).catch(error => {
                    this.toggleLoader();
                    const errorMessage = error.response?.data?.message || error.response?.data?.error || "An error occurred. Please check console";
                    this.$toast.error(errorMessage);
                    console.error(error.response.data);
                });
            },
            toggleLoader() {
                this.loaderVisible = !this.loaderVisible;
            },
            cleanStageData(stage) {
                const { comments, duration, start_date, expected_end_date, end_date, id, project_id, stage_name, status } = stage;
                return { comments, duration, start_date, expected_end_date, end_date, id, project_id, stage_name, status };
            },
            dropdownClass(status) {
                const statusClasses = {
                    pending: 'btn btn-theme-gray',
                    started: 'btn btn-theme-fog',
                    completed: 'btn btn-success',
                    overdue: 'btn btn-danger'
                };
                return `dropdown-content ${statusClasses[status] || 'btn btn-theme-gray'}`;
            },
            checkOverdueStatus(stage) {
                if (new Date(stage.expected_end_date) < new Date(this.currentDate) && stage.status !== 'completed') {
                    stage.status = 'overdue';
                }
            },
            initializeRichTextEditor(index) {
                if (!tinymce.get(`stage-comments-${index}`)) {
                    tinymce.init({
                        selector: `#stage-comments-${index}`,
                        skin: "lightgray",
                        toolbar: "undo redo | formatselect | fontselect fontsizeselect bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                        plugins: ["advlist lists autolink link image"],
                        font_formats: "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
                        images_upload_url: "postAcceptor.php",
                        content_style: "body { font-size: 14pt; }",
                        automatic_uploads: false,
                        fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt",
                        menubar: false,
                        statusbar: false,
                        entity_encoding: "raw",
                        forced_root_block: "",
                        force_br_newlines: true,
                        force_p_newlines: false,
                        width: 350,
                        convert_urls: false,
                        setup: editor => {
                            editor.on('input change keyup paste', () => {
                                this.stages[index].comments = editor.getContent();
                                this.markStageAsUpdated(this.stages[index]);
                            });
                        }
                    });
                }
            }
        },
        mounted() {
            this.stages = @json($stages) || [];
            this.stages.forEach((stage, index) => {
                stage.started = ['started', 'completed'].includes(stage.status);
                stage.completed = stage.status === 'completed';
                stage.initialStatus = stage.status;
                this.checkOverdueStatus(stage);
            });
        }
    });
</script>

@endsection