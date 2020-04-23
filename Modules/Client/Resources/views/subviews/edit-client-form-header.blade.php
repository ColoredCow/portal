<div class="theme-tabs-container">
    <div class="theme-tabs d-flex overflow-x-scroll mb-2 w-md-360 w-xl-696 mx-md-auto">
        <div class="theme-tabs-inner font-muli-bold px-4 px-md-0 d-flex justify-content-md-center mx-md-auto">
            <div  onclick="window.location.href='{{ route('client.edit', [$client, 'client-details']) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2  {{ $section == 'client-details' ? 'active' : '' }}">Client details</div> 

            <div onclick="window.location.href='{{ route('client.edit', [$client, 'client-type']) }}'" class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2 {{ $section == 'client-type' ? 'active' : '' }}">Client type</div>
        </div>
    </div>
</div>