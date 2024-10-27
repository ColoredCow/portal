<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use App\Helpers\ContentHelper;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Round;
use Modules\HR\Http\Requests\Recruitment\RoundRequest;

class RoundController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  RoundRequest  $request
     * @param  Round  $round
     *
     * @return string
     */
    public function update(RoundRequest $request, Round $round)
    {
        $validated = $request->validated();

        switch ($validated['type']) {
            case 'confirmed_mail':
            case 'rejected_mail':
                $mailTemplate = $validated['type'] . '_template';
                $round->update([
                    $mailTemplate => [
                        'subject' => $validated['round_mail_subject'],
                        'body' => $validated['round_mail_body'] ? ContentHelper::editorFormat($validated['round_mail_body']) : null,
                    ],
                ]);
                break;
            case 'guidelines':
                $guidelines = preg_replace('/[\r\n]/', '', $validated['guidelines']);
                $round->update([
                    'guidelines' => $guidelines,
                ]);

                return $guidelines;
        }

        return redirect()->back()->with('status', 'Round updated successfully!');
    }
}
