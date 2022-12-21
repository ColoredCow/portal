<?php

namespace Modules\Revenue\Services;

use Modules\Revenue\Entities\RevenueProceed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RevenueProceedService
{
    public function index($filters)
    {
        $filters = [
            'year' => $filters['year'] ?? null,
        ];

        $revenueProceeds = RevenueProceed::orderby('name')->applyFilters($filters)
        ->paginate(config('constants.pagination_size'));

        return [
            'revenueProceedData'=> $revenueProceeds,
            'filters' => $filters,
        ];
    }

    public function store(Request $request)
    {
        $revenueProceed = new RevenueProceed;

        $revenueProceed->name = $request['name'];
        $revenueProceed->currency = $request['currency'];
        $revenueProceed->amount = $request['amount'];
        $revenueProceed->category = Str::snake($request['category']);
        $revenueProceed->received_at = $request['received_at'];
        $revenueProceed->month = $revenueProceed->received_at->month;
        $revenueProceed->year = $revenueProceed->received_at->year;

        $revenueProceed->notes = $request['notes'];
        $revenueProceed->save();

        return $revenueProceed;
    }

    public function update(Request $request, $id)
    {
        $revenueProceed = RevenueProceed::find($id);
        $revenueProceed->name = $request['name'];
        $revenueProceed->amount = $request['amount'];
        $revenueProceed->currency = $request['currency'];
        $revenueProceed->category = Str::snake($request['category']);
        $revenueProceed->received_at = $request['received_at'];
        $revenueProceed->month = $revenueProceed->received_at->month;
        $revenueProceed->year = $revenueProceed->received_at->year;
        $revenueProceed->notes = $request['notes'];
        $revenueProceed->save();

        return $revenueProceed;
    }

    public function delete($id)
    {
        return RevenueProceed::find($id)->delete();
    }

    public function defaultFilters()
    {
        return [
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
        ];
    }
}
