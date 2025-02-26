<div>
    <style>
        .line {
            line-height: 1px;
        }
    </style>

    <p>Hi Infrastructure Support Team,</p>

    <p>This is to put a request to set up a project folder and its effortsheet. Please find the necessary details below:</p>

    <ul>
        <li><strong>Project Name:</strong> {{ $project->name }}</li>
        <li><strong>Client Name:</strong> {{ $project->client->name ?? 'N/A' }}</li>
        <li><strong>Billing Type:</strong> {{ Str::of($project->type)->replace('-', ' ')->title() }}</li>
        <li><strong>Due Date:</strong> {{ now()->format('d M Y') }}</li>
    </ul>

    <p>We've copied the key account manager in the email thread. Once processed, please share the link on this thread. If you come across any queries or need assistance with details, please drop an email here.</p>

    <br>
    <p class="line">Best,</p>
    <p class="line">Portal Team</p>
    <p class="line">ColoredCow</p>
</div>
