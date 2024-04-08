<div class="theme-tabs-container">
    <div class="theme-tabs d-flex overflow-x-scroll mb-2 mx-md-auto">
        <div class="theme-tabs-inner font-muli-bold px-2 px-md-0 d-flex justify-content-md-center mx-md-auto">
            <div onclick="window.location.href='{{ route('employees.show', $employee) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-4 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6 mr-1 mr-xl-2  {{ Request::is('hr/employees*') && !Request::is('salary/employee*') ? 'active' : '' }}">Dashboard</div> 
            <div onclick="window.location.href='{{ route('salary.employee', $employee) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-4 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6 mr-1 mr-xl-2  {{ Request::is('salary/employee*') ? 'active' : '' }}">Salary</div> 
            <div onclick="window.location.href='{{ route('employees.basic.details', $employee) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-4 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6 mr-1 mr-xl-2  {{ Request::is('hr/employee-basic-details*') ? 'active' : ' ' }}">Basic Details</div> 
            <div onclick="window.location.href='{{ route('employees.review-details', $employee) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-4 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6 mr-1 mr-xl-2  {{ Request::is('hr/employee-review-details*') ? 'active' : ' ' }}">Review Details</div>
            <div class="theme-tab disabled flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter  rounded-6  mr-1 mr-xl-2  ">HR Review </div> 
            <div class="theme-tab disabled flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter  rounded-6  mr-1 mr-xl-2  ">Project Review </div> 
        </div>
    </div>
</div>
