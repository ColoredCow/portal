<div>
    <p>Hello Finance Team!</p>
    <p>Here are list of invoices:</p>
    <p>Total invoices:{{ count($invoices) }}
        <div>
            <table style="border: 1px solid #000; border-collapse: collapse;">
                <thead>
                    <th style="padding-right: 10px;">Project name</th>
                </thead>
            
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr style='border-top: 1px solid #000'>
                            <td style="padding-right: 10px;">{{ $invoice->project->name}}</td>
                        </tr>
                    @endforeach   
                </tbody>
           </table>
        </div>
        <p><a href={{ route('invoice.index') }}> You can see more details here. </a></p>
    
        Please reach out in case you want to made some changes in this email. 
    </div>

</div>        
