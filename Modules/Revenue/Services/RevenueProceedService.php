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
            'month' => $filters['month'] ?? null,
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
        $revenueProceed->category = Str::snake($request['category']);
        $revenueProceed->currency = $request['currency'];
        $revenueProceed->amount = $request['amount'];
        $revenueProceed->month = $request['month'];
        $revenueProceed->recieved_at = $request['recieved_at'];
        $revenueProceed->year = $request['year'];
        $revenueProceed->notes = $request['notes'];
        $revenueProceed->save();

        return $revenueProceed;
    }

    public function show($id)
    {
        return view('revenue::index');
    }

    public function update(Request $request, $id)
    {
        $revenueProceed = RevenueProceed::find($id);

        $revenueProceed->name = $request['name'];
        $revenueProceed->category = Str::snake($request['category']);
        $revenueProceed->currency = $request['currency'];
        $revenueProceed->month = $request['month'];
        $revenueProceed->year = $request['year'];
        $revenueProceed->amount = $request['amount'];
        $revenueProceed->recieved_at = $request['recieved_at'];
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
