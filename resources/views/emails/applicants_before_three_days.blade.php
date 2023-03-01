<div>
 <p>Dear HR,
    I hope this email finds you well. I am writing to inform you that {{ $count }} applicants have submitted their application for the position within the last three days.
    Please find below a table summarizing the applicants' details:</p>
 <div>
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
    <p>Please feel free to click on the applicant's name to view their application details page.
        Thank you for your time and attention to this matter.
    </p>
</div>


