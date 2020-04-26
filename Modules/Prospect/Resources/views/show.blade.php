@extends('client::layouts.master')
@section('content')

<div class="container" id="show_prospect_details_view">
    <h4 class="mb-5">{{ $prospect->name }}</h4>
    <div>
        <div class="card min-h-250 p-5">
            <div class="row">
                <div class="col-5">
                    <div>
                        <div class="font-weight-bold">Name</div>
                        <span>{{ $prospect->name }}</span>
                    </div>

                    <br>

                    <div>
                        <div class="font-weight-bold">Assign To</div>
                        <span>{{ optional($prospect->assigneeTo)->name }}</span>
                    </div>
                    <br>

                    <div>
                        <div class="font-weight-bold">Brif Info</div>
                        <span>{{ $prospect->brief_info }}</span>
                    </div>

                </div>
    
                <div class="col-5 offset-1">
                    <div>
                        <div class="font-weight-bold">Status</div>
                        <div>{{ 'Active' }}</div>
                    </div>

                    <br>

                    <div>
                        <div class="font-weight-bold">Added by</div>
                        <div>{{ $prospect->createdBy->name }}</div>
                    </div>

                    <br>

                    <div>
                        <div class="font-weight-bold">Coming From</div>
                        <div>{{ str_replace('_', ' ', \Str::title($prospect->coming_from))  }}</div>
                    </div>

                </div>
                
            </div>
           
           
        </div>
    </div>

    {{-- <div class="mt-3 w-75">
        <prospect-progress-component
        :new-comment-route = "{{ json_encode(route('book-comment.store', \App\Models\KnowledgeCafe\Library\Book::first()->id)) }}"
        :book = "{{ json_encode(\App\Models\KnowledgeCafe\Library\Book::first()) }}"
        :book-comments = "{{ json_encode(\App\Models\KnowledgeCafe\Library\Book::first()->comments) }}"
        :user = "{{ auth()->user() }}"
        />
    </div> --}}
    
</div>

@endsection


@section('js_scripts')
<script>
new Vue({
    el:'#show_prospect_details_view',

    data() {
        return {
            comingFrom: 'marketing'
        }
    },

    mounted() {
     
    }
});

</script>

@endsection