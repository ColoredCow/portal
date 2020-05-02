@extends('legaldocument::layouts.master')

@section('content')
<div class="container">
    @include('legaldocument::nda.menu')
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">NDA Emails</h4>
        <span>
            <a  href= "{{ route('legal-document.nda.template.create') }}" class="btn btn-info text-white"> Add new template</a>
        </span>
    </div>
    
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                <tr>
                    <td>
                       <a href="{{ route('legal-document.nda.template.show', $template) }}">{{ $template->title }}</a>
                    </td>

                    <td>
                        Active
                    </td>
                </tr>

                @empty
                    <tr>
                        <td colspan="2">
                            <p class="my-4 text-left">No NDA templates found.</p>
                        <td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
</div>
@endsection