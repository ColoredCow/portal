@extends('layouts.app')

@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>
        <form class="form" action="#">
            <div class="d-flex justify-content-between mb-2">
                <h4 class="mb-1 pb-1 fz-28">Tickets</h4>
                <span>
                    @include('ticket::modals.create')
                    <a href="#" class="btn btn-success ml-2 text-white" data-toggle="modal"
                        data-target="#modal-ticket-details"><i class="fa fa-plus mr-1"></i>New Ticket</a>
                    </a>
                </span>
            </div>
            <div class=" d-flex justify-content-between">
                <div class="font-bold mt-2">Total Tickets : </div>
            </div>
        </form>
        <div class="menu_wrapper mt-5">
            <div class="navbar" id="navbar">
                <li id="list-styling">
                    <a id="" class="btn" href="#">
                        <div>
                            <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/people.svg')) !!}</span>
                            <h5 class="application-menu-headings fz-20 font-mulish">My Tickets</h5>
                        </div>
                    </a>
                </li>
                <li id="list-styling">
                    <a id="" class="btn" href="#">
                        <div>
                            <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/code.svg')) !!}</span>
                            <h5 class="">Open</h5>
                        </div>
                    </a>
                </li>
                <li id="list-styling">
                    <a id="" class="btn" href="#">
                        <div>
                            <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/clipboard.svg')) !!}</span>
                            <h5 class="application-menu-headings fz-20 font-mulish ">Completed</h5>
                        </div>
                    </a>
                </li>
                <li id="list-styling">
                    <a id="" class="btn" href="#">
                        <div>
                            <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/x-circle.svg')) !!}</span>
                            <h5 class="application-menu-headings fz-20 font-mulish">Closed</h5>
                        </div>
                    </a>
                </li>
            </div>
        </div>
        <table class="table table-striped table-bordered" id="">
            <thead class="thead-dark sticky-top">
                <th>Ticket ID</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Type </th>
                <th>Status</th>
            </thead>
            <tbody>
                @include('ticket::subviews.render-ticket-row')
            </tbody>
        </table>
    </div>
@endsection
