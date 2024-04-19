@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{$employee}}
                <h1 class="mb-5 mt-10 font-weight-bold"> {{ $employee->name }} </h4>
            </div>
            <div class="col-md-12 text-center">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr class="sticky-top">
                            <th>Project</th>
                            <th>Rate
                                <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="per hour">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </span>
                            </th>
                            <th> Total Efforts</th>
                            <th>
                                Earning
                                <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Per hour Rate">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                Shubham
                            </td>
                            <td>
                                Shubham
                            </td>
                            <td>
                                Shubham
                            </td>
                            <td>
                                Shubham
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><h4>Total</h4></td>
                            <td colspan="1"> <h4>0</h4> </td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
