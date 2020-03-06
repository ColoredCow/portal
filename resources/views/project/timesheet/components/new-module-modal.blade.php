<new-timesheet-module 
    :new-module-route="{{ json_encode(route('project.timesheet.new-module', [$timesheet])) }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
</new-timesheet-module>
