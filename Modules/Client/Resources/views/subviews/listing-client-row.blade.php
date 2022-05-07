<tr>
    <td> 
        <span class="{{ $level ? 'ml-2' : ''  }}">
            @canany(['clients.update', 'clients.create', 'clients.delete'])
                <a href="{{ route('client.edit', $client) }}" >
                    {{ $client->name }}
                </a> 
            @else
                <span>{{ $client->name }} </span> 
            @endcanany
        </span>
    </td>
    <td >
        @include('client::subviews.listing-client-type', ['client' => $client])
    </td>
    <td>{{ optional($client->keyAccountManager)->name ?: '-' }}</td>
</tr>