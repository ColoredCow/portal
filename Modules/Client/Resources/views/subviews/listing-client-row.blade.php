<tr>
    <td> 
        <span class="{{ $level ? 'ml-2' : ''  }}">
            <a @can('clients.update' || 'clients.create' || 'clients.delete') href="{{ route('client.edit', $client) }}" @endcan>
               <span >{{ $client->name }} </span> 
            </a> 
        </span>
       
    </td>
    <td >
        @include('client::subviews.listing-client-type', ['client' => $client])
    </td>
    <td>{{ optional($client->keyAccountManager)->name ?: '-' }}</td>
</tr>