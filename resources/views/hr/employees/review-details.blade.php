@extends('layouts.app')

@section('content')
    <div class="container mb-20">
        <br>
        <h4 class="mb-5 font-weight-bold">{{ $employee->name }}'s review details</h4>
        @include('hr.employees.sub-views.menu')
        <br>
        <div>
            <br>
            <form method="POST" action="{{ route('update.employee.reviewers', $employee->id) }}">
                @csrf
                <div class="d-flex justify-content-between">
                    @foreach (config('constants.employee-reviewers') as $key => $role)
                        <div>
                            <label for="{{ $role }}">{{ $role }}:</label>
                            <select class="pt-0 ml-2 btn bg-light text-left" name="{{ $key }}"
                                onchange="this.form.submit()">
                                <option value="" selected="selected">Select {{ $role }}</option>
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ $employee->toArray()[$key] == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </form>

            @foreach ($assessments as $assessment)
                <form method="POST" action="{{ route('review.updateStatus') }}">
                    @csrf
                    <input type="hidden" value="{{ $assessment->id }}" name="assessmentId" />
                    <div class="review-cards mt-5">
                        <!-- Quarter 1 Review Card -->
                        <div class="card mb-4">
                            <div class="card-header review-card-header">
                                <h4 class="font-weight-bold">Review date <span
                                        class="font-weight-light">{{ $assessment->created_at->format('d-m-Y') }}</span>
                                </h4>
                            </div>
                            <div class="card-body review-card-body" style="display: none;">
                                <div>Next review due: <span
                                        class="text-info">{{ $assessment->created_at->addMonths(3)->startOfMonth()->format('d-m-Y') }}</span>
                                </div>
                                <br>
                                <br>
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr class="sticky-top">
                                            @foreach (config('constants.employee-review-status') as $key => $role)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tr>
                                        @foreach (config('constants.employee-review-status') as $role => $reviewStatuses)
                                            <td>
                                                <select class="pt-0 ml-2 btn bg-light text-left" name="{{ $role }}"
                                                    onchange="updateHiddenField(this)">
                                                    <option value="" selected="selected">Select Review Status
                                                    </option>
                                                    @foreach ($reviewStatuses as $key => $reviewStatus)
                                                        <option value="{{ $key }}"
                                                            {{ $assessment->assessmentReviewStatus($assessment, $role, $key) ? 'selected' : '' }}>
                                                            {{ $reviewStatus }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                                <br>
                            </div>
                        </div>
                        <input type="hidden" id="hidden-review-type" value="" name="review_type" />
                        <input type="hidden" id="hidden-reviewer-id" value="" name="reviewer_id" />
                </form>
            @endforeach

            <!-- Add more Quarter Review Cards as needed -->

        </div>
    </div>
    </div>

    <script>
        // jQuery code to toggle card body visibility
        $(document).ready(function() {
            $('.review-card-header').click(function() {
                $(this).next('.review-card-body').slideToggle();
            });
        });

        function updateHiddenField(selectElement) {
            let headerName = selectElement.name;
            $('#hidden-review-type').val(headerName);
            switch (headerName) {
                case 'self':
                    $('#hidden-reviewer-id').val({{ $employee->id }});
                    break;
                case 'mentor':
                    $('#hidden-reviewer-id').val({{ $employee->mentor_id }});
                    break;
                case 'hr':
                    $('#hidden-reviewer-id').val({{ $employee->hr_id }});
                    break;
                case 'manager':
                    $('#hidden-reviewer-id').val({{ $employee->manager_id }});
                    break;
                default:
                    break;
            }
            $(selectElement).closest("form").submit();
        }
    </script>
@endsection
