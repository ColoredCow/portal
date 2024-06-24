<div class="card-header d-flex mb-4" data-toggle="collapse" data-target="#project-stages" >
    <h4>Project Stages</h4>
    <span class ="arrow ml-auto">&#9660;</span>
</div>
<div class="collapse" id="project-stages">
<div>
    <div class="fz-36" id="toggle-form">
    <i class="fa fa-plus mr-1"></i>
    Add
    </div>
    <form id="stage-form" method="POST" class="d-none">
        @csrf
        <div>
            <label>
                <span>Stage</span>
                <input type="text" name="stage_name" required>
            </label>
        </div>
        <div>
            <label>
                <span>Comment</span>
                <input type="text" name="comment">
            </label>
        </div>
        <div>
        <div class="checkbox-wrapper-19">
            <input type="checkbox"  name="status" value="completed" id="cbtest-19" />
            <label for="cbtest-19" class="check-box">
            </label>
        </div>
        <div>
            <input type="hidden" name="project_id" value="{{ $project->id }}">
        </div>
        <button type="submit">Add</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle form visibility when the + button is clicked
        $('#toggle-form').on('click', function() {
            $('#stage-form').toggleClass('d-none');
        });

        // Handle form submission
        $('#stage-form').on('submit', function(e) {
            e.preventDefault();

            // Perform the first AJAX request to add the stage listing
            const projectId = $('input[name="project_id"]').val();
            const stageName = $('input[name="stage_name"]').val();
            const comment = $('input[name="comment"]').val();
            const status = $('input[name="status"]').is(':checked') ? 'completed' : 'pending';

            // Perform the second AJAX request to add the project stage
            $.ajax({
                url: '{{ route('projects.add-stage') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    project_id: projectId,
                    stage_name: stageName,
                    comment: comment,
                    status: status
                },
                success: function(response) {
                    alert('Stage added successfully!');
                    $('#stage-form').toggleClass('d-none'); // Hide the form after successful submission
                },
                error: function(xhr) {
                    alert('Error adding stage.');
                }
            });
        });
    });
</script>

    <!-- <table class="table">
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
    </table> -->
</div>