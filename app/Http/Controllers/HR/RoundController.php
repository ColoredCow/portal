<?php

namespace App\Http\Controllers\HR;

use App\Helpers\ContentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\RoundRequest;
use App\Models\HR\Round;

class RoundController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\HR\RoundRequest $request
     * @param \App\Models\HR\Round               $round
     *
     * @return string
     */
    public function update(RoundRequest $request, Round $round)
    {
        $validated = $request->validated();

        switch ($validated['type']) {
            case 'confirmed_mail':
            case 'rejected_mail':
                $mailTemplate = $validated['type'].'_template';
                $round->update([
                    $mailTemplate => [
                        'subject' => $validated['round_mail_subject'],
                        'body'    => $validated['round_mail_body'] ? ContentHelper::editorFormat($validated['round_mail_body']) : null,
                    ],
                ]);
                break;
            case 'guidelines':
                $guidelines = preg_replace('/[\r\n]/', '', $validated['guidelines']);
                $round->update([
                    'guidelines' => $guidelines,
                ]);

                return $guidelines;
                break;
        }

        return redirect()->back()->with('status', 'Round updated successfully!');
    }
}
