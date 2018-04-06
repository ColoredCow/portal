@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-6"><h1>Weekly Doses</h1></div>
        <div class="col-md-6"><button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#weeklydose_setup_modal">See plugin setup guide</button></div>
    </div>
    <br><br>
    <table class="table table-striped table-bordered" id="table_weeklydoses">
        <tr>
            <th>Description</th>
            <th>URL</th>
            <th>Recommended By</th>
            <th>Date</th>
        </tr>
        @foreach ($weeklydoses as $weeklydose)
        <tr>
            <td>{{ $weeklydose->description }}</td>
            <td><a href="{{ $weeklydose->url }}" target="_blank">{{ $weeklydose->url }}</a></td>
            <td>{{ $weeklydose->recommended_by }}</td>
            <td>{{ date_format($weeklydose->created_at, 'Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="modal" tabindex="-1" role="dialog" id="weeklydose_setup_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">WeeklyDose Chrome Plugin Guide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Follow the steps to get started with the WeeklyDose functionality:</p>
                <ol>
                    <li><a href="{{ env('WEEKLYDOSE_PLUGIN_URL') }}" target="_blank">Add the chrome plugin.</a></li>
                    <li>Once added, you'll see a small ColoredCow icon at the top-right section of your browser.</li>
                    <li>Click on the icon and set your WeeklyDose configurations by clicking on the settings <i class="fa fa-cog"></i> icon.</li>
                    <li>
                        Save your name and add the following WeeklyDose service url:
                        <div class="bg-light d-flex align-items-center justify-content-between pl-2" id="weeklydose_service_url">{{ env('WEEKLYDOSE_SERVICE_URL') }}
                            <button class="btn btn-secondary btn-clipboard" id="copy_weeklydose_service_url" data-clipboard-target="#weeklydose_service_url" data-original-title="Copy to clipboard">
                                <i class="fa fa-copy"></i>
                            </button>
                        </div>
                    </li>
                    <li>Now open the article you want to share in a new tab. From the same tab, click on the ColoredCow icon. You'll see the article link in the popup. Add a brief description and hit send!</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
