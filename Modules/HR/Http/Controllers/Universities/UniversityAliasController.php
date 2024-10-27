<?php
namespace Modules\HR\Http\Controllers\Universities;

use Illuminate\Routing\Controller;
use Modules\HR\Entities\UniversityAlias;
use Modules\HR\Http\Requests\UniversityAliasRequest;

class UniversityAliasController extends Controller
{
    public function store(UniversityAliasRequest $request)
    {
        $validated = $request->validated();
        $alias = UniversityAlias::create($validated);

        return response()->json([
            'message' => __('Alias created successfully'),
            'data' => $alias,
        ], 200);
    }

    public function update(UniversityAliasRequest $request, UniversityAlias $alias)
    {
        $validated = $request->validated();
        $alias->update($validated);

        return response()->json([
            'message' => __('Alias updated successfully'),
            'data' => $alias,
        ], 200);
    }

    public function destroy(UniversityAlias $alias)
    {
        $isDeleted = $alias->delete();
        $status = $isDeleted ? 'Alias deleted successfully!' : 'Something went wrong! Please try again';

        return response()->json([
            'message'=>$status,
        ], 200);
    }
}
