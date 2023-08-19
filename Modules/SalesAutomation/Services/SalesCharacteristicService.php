<?php

namespace Modules\SalesAutomation\Services;

use Modules\SalesAutomation\Entities\SalesCharacteristic;

class SalesCharacteristicService
{
    public function index(array $filters = [])
    {
        $salesCharacteristicQuery = $this->getsalesCharacteristicFilterQuery($filters);
        $salesCharacteristics = $salesCharacteristicQuery->paginate(config('salesautomation.sales-characteristic.paginate'));

        return [
            'salesCharacteristics' => $salesCharacteristics,
            'filters' => $filters,
            'filterDepth' => count($filters),
        ];
    }

    public function store(array $data)
    {
        return SalesCharacteristic::create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
    }

    public function update(array $data, SalesCharacteristic $salesCharacteristic)
    {
        $salesCharacteristic->update([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);

        return $salesCharacteristic;
    }

    public function destroy(SalesCharacteristic $salesCharacteristic)
    {
        $salesCharacteristic->delete();
    }

    private function getsalesCharacteristicFilterQuery(array $filters = [])
    {
        $salesCharacteristicQuery = SalesCharacteristic::query();
        foreach ($filters as $filter) {
            switch ($filter['type']) {
                case 'name':
                    $salesCharacteristicQuery->filter($filter['type'], $filter['keyword']);
                    break;
            }
        }

        return $salesCharacteristicQuery;
    }
}
