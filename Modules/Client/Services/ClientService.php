<?php

namespace Modules\Client\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Contracts\ClientServiceContract;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;
use Modules\Client\Entities\ClientBillingDetail;
use Modules\Client\Entities\ClientContactPerson;
use Modules\Client\Entities\ClientContract;
use Modules\Client\Entities\ClientMeta;
use Modules\User\Entities\User;

class ClientService implements ClientServiceContract
{
    public function index(array $data = [])
    {
        $filters = [
            'status' => $data['status'] ?? 'active',
            'name' => $data['name'] ?? null,
            'sort' => $data['sort'] ?? 'name',
            'direction' => $data['direction'] ?? 'asc',
        ];

        $clients = Client::applyFilter($filters)
        ->with([
            'linkedAsPartner' => function ($subQuery) use ($filters) {
                return $subQuery->applyFilter($filters)->orderBy($filters['sort'], $filters['direction']);
            },
            'linkedAsDepartment' => function ($subQuery) use ($filters) {
                return $subQuery->applyFilter($filters)->orderBy($filters['sort'], $filters['direction']);
            },
        ])
        ->orderBy($filters['sort'], $filters['direction'])
        ->get();
        $count = $clients->count();

        $topLevel = $clients->filter(function ($value) {
            return $value->isTopLevel();
        });

        /* Filter all the status (active/Inactive clients which
         * does not have a parent with different status) */

        foreach ($topLevel as $client) {
            $clients = $clients->diff($client->linkedAsPartner);
            $clients = $clients->diff($client->linkedAsDepartment);
        }

        $activeClientsCount = Client::where('status', 'active')->count();
        $inactiveClientsCount = Client::where('status', 'inactive')->count();

        return ['clients' => $clients, 'count' => $count, 'activeClientsCount' => $activeClientsCount, 'inactiveClientsCount' => $inactiveClientsCount];
    }

    public function create()
    {
        $countries = Country::all();

        return [
            'keyAccountManagers' => $this->getKeyAccountManagers(),
            'channelPartners' => $this->getChannelPartners(),
            'parentOrganisations' => $this->getParentOrganisations(),
            'countries' => $countries,
        ];
    }

    public function edit($client, $section)
    {
        if (! $section || $section == 'client-details') {
            return [
                'channelPartners' => $this->getChannelPartners(),
                'parentOrganisations' => $this->getParentOrganisations(),
                'client' => $client,
                'section' => $section ?: config('client.default-client-form-stage'),
            ];
        }

        if ($section == 'contact-persons') {
            return [
                'client' => $client,
                'section' => $section,
                'contactPersons' => $client->contactPersons,
            ];
        }

        if ($section == 'address') {
            return [
                'client' => $client,
                'section' => $section,
                'countries' => Country::all(),
                'addresses' => $client->addresses,
            ];
        }

        if ($section == 'billing-details') {
            return [
                'client' => $client,
                'section' => $section,
                'clientBillingAddress' => $this->getClientBillingAddress($client),
                'keyAccountManagers' => $this->getKeyAccountManagers()->whereNull('deleted_at')->sortBy('name'),
                'clientBillingDetail' => $client->billingDetails,
            ];
        }

        if ($section == 'contract') {
            return [
                'client' => $client,
                'section' => $section,
                'contract' => $client->clientContracts,
            ];
        }

        if ($section == 'projects') {
            return [
                'client' => $client,
                'section' => $section,
                'projects' => $client->projects,
            ];
        }
    }

    public function update($data, $client)
    {
        $data['section'] = $data['section'] ?? null;
        $nextStage = route('client.index');
        $defaultRoute = route('client.index');

        switch ($data['section']) {
            case 'client-details':
                $this->updateClientDetails($data, $client);
                $nextStage = route('client.edit', [$client, 'contact-persons']);
                break;

            case 'contact-persons':
                $this->updateClientContactPersons($data, $client);
                $nextStage = route('client.edit', [$client, 'address']);
                break;

            case 'address':
                $this->updateClientAddress($data, $client);
                $nextStage = route('client.edit', [$client, 'billing-details']);
                break;

            case 'billing-details':
                $this->updateBillingDetails($data, $client);
                $nextStage = route('client.edit', [$client, 'contract']);
                break;

            case 'contract':
                $this->updateContract($data, $client);
                $nextStage = route('client.edit', [$client, 'projects']);
                break;

            case 'default':
                $client->update($data);
                break;
        }

        return [
            'route' => $data['submit_action'] == 'next' ? $nextStage : $defaultRoute,
        ];
    }

    public function getKeyAccountManagers()
    {
        return User::all();
    }

    public function getAll($status = 'active')
    {
        return Client::status($status)->with('projects')->orderBy('name')->get();
    }

    public function store($data)
    {
        $data['status'] = 'active';
        $data['client_id'] = Client::max('client_id') + 1;
        $data['is_billable'] = $data['is_billable'] ?? false;

        $newClient = Client::create($data);
        $clientAddress = new ClientAddress();
        $clientAddress->country_id = $data['country_id'];
        $clientAddress->client_id = $newClient->id;
        $clientAddress->save();

        return $newClient;
    }

    public function getChannelPartners()
    {
        return Client::where('is_channel_partner', true)->get();
    }

    public function getBillableClients($status = 'active')
    {
        return Client::billable()->status($status)->with('projects')->orderBy('name')->get();
    }

    public function getParentOrganisations()
    {
        return Client::where('has_departments', true)->get();
    }

    public function getClientBillingAddress($client)
    {
        $addresses = $client->addresses()->with('country')->get();
        if ($addresses->isEmpty()) {
            return;
        }

        $billingAddress = $addresses->where('type', 'billing-address')->first();
        if ($billingAddress && $billingAddress->id) {
            return $billingAddress;
        }

        return $addresses->first();
    }

    public function saveOrUpdateClientContract($data, $client)
    {
        if ($data['contract_file'] ?? null) {
            $file = $data['contract_file'];
            $folder = '/clientcontract/' . date('Y') . '/' . date('m');
            $fileName = $file->getClientOriginalName();
            $filePath = Storage::putFileAs($folder, $file, $fileName);
            $start_date = $data['start_date'] ?? null;
            $end_date = $data['end_date'] ?? null;

            ClientContract::updateOrCreate(
                ['client_id' => $client->id],
                [
                    'contract_file_path' => $filePath,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ],
            );
        }
    }

    private function updateClientDetails($data, $client)
    {
        $data['is_channel_partner'] = $data['is_channel_partner'] ?? false;
        $data['has_departments'] = $data['has_departments'] ?? false;
        $data['is_billable'] = $data['is_billable'] ?? false;
        $isDataUpdated = $client->update($data);

        if ($data['status'] ?? 'active' == 'inactive') {
            $client->projects()->update(['status' => 'inactive']);
        }

        return $isDataUpdated;
    }

    private function updateClientContactPersons($data, $client)
    {
        $contactPersons = $data['client_contact_persons'] ?? [];
        $clientContactPersons = collect([]);
        foreach ($contactPersons as $contactPersonData) {
            $contactPersonID = $contactPersonData['id'] ?? null;
            if ($contactPersonID) {
                $contactPerson = ClientContactPerson::find($contactPersonID);
                $contactPerson->update($contactPersonData);
                $clientContactPersons->push($contactPerson);
                continue;
            }
            $contactPerson = new ClientContactPerson($contactPersonData);
            $client->contactPersons()->save($contactPerson);
            $clientContactPersons->push($contactPerson);
        }

        $client->contactPersons
            ->diff($clientContactPersons)
            ->each(function ($contactPerson) {
                $contactPerson->delete();
            });

        return true;
    }

    private function updateClientAddress($data, $client)
    {
        $addresses = $data['address'] ?? [];
        $useForBillingAddress = $data['use_as_billing_address'] ?? null;
        $clientAddresses = collect([]);

        foreach ($addresses as $addressData) {
            $addressId = $addressData['id'] ?? null;
            if ($addressId) {
                $clientAddress = ClientAddress::find($addressId);
                $clientAddress->update($addressData);
                $clientAddresses->push($clientAddress);
                continue;
            }

            $clientAddress = new ClientAddress($addressData);
            $client->addresses()->save($clientAddress);
            $clientAddresses->push($clientAddress);
        }

        $client->addresses
            ->diff($clientAddresses)
            ->each(function ($clientAddress) {
                $clientAddress->delete();
            });

        if ($useForBillingAddress) {
            $client->addresses()->update(['type' => 'alternate-address']);
            $billingClientAddress = ClientAddress::find($useForBillingAddress);
            $billingClientAddress->type = 'billing-address';
            $billingClientAddress->save();
        }

        return true;
    }

    private function updateBillingDetails($data, $client)
    {
        $client->update(['key_account_manager_id' => $data['key_account_manager_id']]);

        ClientBillingDetail::updateOrCreate(['client_id' => $client->id], $data);

        return true;
    }
    private function updateContract($data, $client)
    {
        $this->saveOrUpdateClientContract($data, $client);

        if (isset($data['contract_level'])) {
            ClientMeta::updateOrCreate(
                [
                    'key' => config('client.meta_keys.contract_level.key'),
                    'client_id' => $client->id,
                ],
                [
                    'value' => $data['contract_level'],
                ]
            );
        } else {
            $data['contract_level'] = 'project';
            ClientMeta::updateOrCreate(
                [
                    'key' => config('client.meta_keys.contract_level.key'),
                    'client_id' => $client->id,
                ],
                [
                    'value' => 'project',
                ]
            );
        }

        return true;
    }
}
