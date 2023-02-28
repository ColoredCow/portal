<div>
    <h2>{{ $count }} applicants submitted their application before 3 days.</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($applicants as $applicant)
            <tr>
                <td><a href="http://portal.test/hr/recruitment/applicant/details/show/{{ $applicant->id }}">{{ $applicant->name }}</a></td>
                <td>{{ $applicant->email }}</td>
                <td>{{ $applicant->phone }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>