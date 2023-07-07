@extends('layouts.app')

@section('content')
    <div class="container">
            <br>
            @include('hr.employees.menu')
            <br><br>
        <div class="col-md-12">
            <h1>New Joinees</h1>
            <br>
        </div>
        <form action="/approve-joinees" method="post">
            @csrf
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="sticky-top">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Number</th>
                        <!-- Add other fields as needed -->
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row[0] }}</td>
                            <td>{{ $row[1] }}</td>
                            <td>{{ $row[2] }}</td>
                            <td>
                                <input type="checkbox" name="approved[]"> Approve
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-primary mt-2" type="submit">Submit</button>
        </form>
    </div>
@endsection
