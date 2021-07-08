<tr>
    <td> 
        <span class="{{ $level ? 'ml-2' : ''  }}">
            <a href="{{ route('client.edit', $client) }}">
               <span >{{ $client->name }} </span> 
            </a> 
        </span>
       
    </td>
    <td >
        @include('client::subviews.listing-client-type', ['client' => $client])
    </td>
    <td>{{ optional($client->keyAccountManager)->name ?: '-' }}</td>
</tr>