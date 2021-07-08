<div class="card mb-1 update-card">
        <form class="task-form mt-2 ml-5" action="{{ $task->update_action}}" method="POST" name="updateForm">
            @csrf
            <div class="method">
                @method('PUT')
            </div>

            <input type="hidden" name="project_id" value="{{$project->id}}">

            <div class="form-row mb-1">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="name" placeholder="Task Name" value="{{$task->name}}" required>
                </div>

                <div class="col-md-2" >
                    <input type="date" class="form-control" name="worked_on" placeholder="worked_on" value="{{$task->worked_on}}" required>
                </div>

                <div class="col-md-1">
                    <select class="form-control narrow type" name="type" >
                            @foreach($taskType as $type)
                                <option value="{{$type}}" {{$type == $task->type ? 'selected' : ''}}>{{ucfirst($type)}}</option>
                            @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <!-- <img src="" class="user-avatar w-25 h-25 rounded-circle mr-1"> -->
                    <select class="form-control narrow asignee_id" name="asignee_id">
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{$task->asignee_id==$user->id?'selected':''}}>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <input type="number" max="99" step="0.5" min="0" class="form-control" name="estimated_effort" placeholder="Estd. Effort(Hrs)" value="{{$task->estimated_effort}}" required>
                </div>

                <div class="col-md-1">
                    <input type="number" max="99" step="0.5" min="0" class="form-control" name="effort_spent" placeholder="Effort Spent(Hrs)" value="{{$task->effort_spent}}" required>
                </div>

                <div class="col-md-3 com-lg-3 col-sm-3 ">
                    <button class="btn btn-primary w-100 btn-update" value="{{$task->btn_text}}" type="submit">
                        <span class="spinner-border spinner-border-sm d-none loader"></span>
                        <span class="btn-text">{{$task->btn_text}}</span>
                        <i class="fa fa-check text-success fa-lg d-none icon" aria-hidden="true"></i>
                    </button>

                    <button type="button" title="Delete" class="remove_button {{ $task->class }} btn btn-danger delete-form ml-1 w-100">
                        <span class="delete-text">Remove</span>
                        <div class="spinner-border spinner-border-sm d-none delete-loader" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>

                    <button type="button" class="ml-1 btn btn-danger w-100 remove-contact add d-none">Remove</button>
                </div>
            </div>

            <p class="text-primary form-row col-md-1" id="show_comment" >{{$task->note}}</p>
            <div class="d-none col-md-4 form-row comment_toggle mb-2">
                <input type="text" class="form-control" placeholder="Add Note"name="comment" value="{{$task->comment}}">
            </div>

        </form>

        <form class="remove_button {{ $task->class }} remove-form" action="{{ $task->delete_action }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </div>
