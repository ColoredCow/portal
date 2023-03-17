@extends('report::layouts.master')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>

        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1"> Client Revenue Report</h4>
        </div>
        <br>    
        <br>

        <div>
            <form action="{{ route('reports.finance.profit-and-loss.detailed') }}" id="p&LFilterForm">
                <div class="d-flex">
                    <div class='form-group mr-4 w-168'>
                        <select class="form-control bg-light" name="year"
                            onchange="document.getElementById('p&LFilterForm').submit();">
                        </select>
                    </div>
                    <div class="ml-auto">
                        <button type="submit" formaction="{{ route('reports.finance.profit-and-loss.report.export')}}" class="btn btn-info text-white">Export to Excel</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div>
            <table class="table table-bordered table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th>Clients</th>
                        <th>Projects</th>
                        <th>Total</th>
                        <th>Apr- </th>
                        <th>May-</th>
                        <th>Jun-</th>
                        <th>Jul-</th>
                        <th>Aug-</th>
                        <th>Sep-</th>
                        <th>Oct-</th>
                        <th>Nov- </th>
                        <th>Dec-</th>
                        <th>Jan- </th>
                        <th>Feb-</th>
                        <th>Mar-</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($clientsData as $clientData)
                        <tr>
                            <td>{{ $clientData["clientName"] }}</td>
                            <td>{{ $clientData["projectName"] }}</td>
                                
                            
                            {{-- <td>{{ $perticular['amounts']['total'] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["04-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["05-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["06-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["07-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["08-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["09-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["10-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["11-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["12-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["01-$startYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["02-$startYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["03-$startYearVal"] ?? 0 }}</td> --}}
                        </tr>
                    @endforeach

                    <tr class="bg-info">

                        <td colspan="2">Total Revenue </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
