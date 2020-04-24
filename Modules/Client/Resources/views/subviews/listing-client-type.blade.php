<ul class="list-style-none ml-0 pl-1 mb-0">
    @php $isIndepandet = true; @endphp
    @if($client->is_channel_partner)
    <li> Channel Partner</li>
    @php $isIndepandet = false; @endphp
    @endif

    @if($client->has_departments)
    <li> Parent organisation</li>
    @php $isIndepandet = false; @endphp
    @endif

    @if($client->channel_partner_id)
    <li> <span class="font-weight-bold">{{  $client->channelPartner->name  }}</span> is the channel partner</li>
    @php $isIndepandet = false; @endphp
    @endif

    @if($client->parent_organisation_id)
    <li> <span class="font-weight-bold">{{ $client->parentOrganisation->name }}</span> is the parent
        organisation</li>
    @php $isIndepandet = false; @endphp
    @endif

    @if($isIndepandet)
    <li> - </li>
    @endif
</ul>