<div class="theme-tabs-container">
    <div class="theme-tabs d-flex overflow-x-scroll mb-2 mx-md-auto">
        <div class="theme-tabs-inner font-muli-bold px-4 px-md-0 d-flex justify-content-md-center mx-md-auto">
            <div onclick="window.location.href='{{ route('user.profile', [ 'section' => 'basic-details']) }}'"
                class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2  {{ $section == 'basic-details' ? 'active' : '' }}">
                Basic Details
            </div>

            <div onclick="window.location.href='{{ route('user.profile', [ 'section' => 'documents']) }}'"
                class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2  {{ $section == 'documents' ? 'active' : '' }}">
                Documents
            </div>

            <div onclick="window.location.href='{{ route('user.profile', [ 'section' => 'finance']) }}'"
                class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2  {{ $section == 'finance' ? 'active' : '' }}">
                Finance</div>

        </div>
    </div>
</div>