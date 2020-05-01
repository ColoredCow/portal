<ul class="list list-group float-right">

    @foreach($prospectChecklist as $checklist)
       @if($checklist['status'] == 'completed')

       <li class="bg-theme-gray-lightest my-3 p-2 rounded rounded-12  text-white">
            <label class="d-flex align-items-center mb-0 flex-basis-xl-50p">
                <input type="checkbox" name="project_tollgate_objective" value="" checked="checked" disabled="disabled" class="position-absolute invisible"> 
                <span class="checkbox-custom custom-checkbox-success border-theme-gray-darker rounded-0 w-24 h-24 w-xl-32 h-xl-32 mr-2"></span> 
                <a href="{{ route('prospect.checklist.show', [$prospect, $checklist['id']]) }}" class="text-dark">{{ $checklist['name'] }}</a>
            </label>
        </li>

       @elseif($checklist['status'] == 'in-progress')
        <li class="bg-theme-gray-lightest my-3 p-2 rounded rounded-12  text-white">
            <i data-toggle="tooltip" data-placement="left" title="NDA initiated and waiting for review" class="83 bg-theme-orange fa fa-spinner fz-22 p-0 rounded-12"></i>
            <a class="text-theme-gray-darker" href="{{ route('prospect.checklist.show', [$prospect, $checklist['id']]) }}">{{ $prospect->getChecklistCurrentTask($checklist['id']) }}</a>
        </li>

       @else

        <li class="bg-theme-gray-lightest mb-3 p-2 rounded rounded-12  text-white">
            <a class="text-theme-gray-darker" href="{{ route('prospect.checklist.show', [$prospect, $checklist['id']]) }}">{{ $checklist['name'] }}</a>
        </li>
       @endif

    @endforeach

</ul>