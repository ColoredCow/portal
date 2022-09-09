<tr>
    <td> 
        <span class="{{ $level ? 'ml-2' : ''  }}">
            @canany(['clients.update', 'clients.create', 'clients.delete'])
            <a href="{{ route('projectcontract.edit', $client) }}" >
                {{ $client->name }}
            </a> 
            @else
            <span>{{ $projectContract->client_name }} </span> 
            @endcanany
        </span>
    </td>  
    <td>
        @if ($client->keyAccountManager)
            <span data-html="true" data-toggle="tooltip" title="{{ $client->keyAccountManager->name}}" class="content tooltip-wrapper">
            <img src="{{ $client->keyAccountManager->avatar }}" class="w-35 h-30 rounded-circle mb-1"> </a>
        @else
            -
        @endif
    </td>

</tr>
