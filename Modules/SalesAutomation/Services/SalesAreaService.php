<?php

namespace Modules\SalesAutomation\Services;

use Modules\SalesAutomation\Entities\SalesArea;

class SalesAreaService
{
    public function index(array $filters = [])
    {
        $salesAreaQuery = $this->getSalesAreaFilterQuery($filters);
        $salesAreas = $salesAreaQuery->paginate(config('salesautomation.sales-area.paginate'));

        return [
            'salesAreas' => $salesAreas,
            'filters' => $filters,
            'filterDepth' => count($filters),
        ];
    }

    public function store(array $data)
    {
        return SalesArea::create([
            'name' => $data['name'],
        ]);
    }

    public function update(array $data, SalesArea $salesArea)
    {
        $salesArea->update([
            'name' => $data['name'],
        ]);

        return $salesArea;
    }

    public function destroy(SalesArea $salesArea)
    {
        $salesArea->delete();
    }

    private function getSalesAreaFilterQuery(array $filters = [])
    {
        $salesAreaQuery = SalesArea::query();
        foreach ($filters as $filter) {
            switch ($filter['type']) {
                case 'name':
                    $salesAreaQuery->filter($filter['type'], $filter['keyword']);
                    break;
            }
        }

        return $salesAreaQuery;
    }
}
