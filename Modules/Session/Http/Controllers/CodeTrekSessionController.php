<?php

namespace Modules\Session\Http\Controllers;

use Modules\Session\Entities\Session;
use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\Session\Http\Requests\SessionRequest;

class CodeTrekSessionController extends Controller
{
    public function index(CodeTrekApplicant $codeTrekApplicant)
    {
        $codeTrekApplicant = CodeTrekApplicant::findOrFail($codeTrekApplicant->id); //Find the record of a applicant by given id

        $sessions = $codeTrekApplicant->sessions() //get all session of the particular applicant order by date in descending order
        ->orderBy('date', 'desc')
        ->get();

        // @phpstan-ignore argument.type
        return view('session::codetrek.index')->with([
            'codeTrekApplicant' => $codeTrekApplicant,
            'sessions' => $sessions
        ]);
    }

    public function create()
    {
        //
    }

    public function store(SessionRequest $request, CodeTrekApplicant $codeTrekApplicant)
    {
        $codeTrekApplicant = CodeTrekApplicant::find($codeTrekApplicant->id);

        $session = $codeTrekApplicant->sessions()->create([
            'topic_name' => $request->input('topic_name'),
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'level' => $request->input('level'),
            'summary' => $request->input('summary'),
        ]); //Stores the session data to the particular applicant

        return redirect()->route('codetrek.session.index', $codeTrekApplicant->id)->with('success', 'Session created successfully.');
    }

    public function show(CodeTrekApplicant $codeTrekApplicant, int $applicant)
    {
        //
    }

    public function update(SessionRequest $request, Session $session, CodeTrekApplicant $codeTrekApplicant)
    {
        $session = Session::find($session->id);
        $session->update([
            'topic_name' => $request->input('topic_name'),
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'summary' => $request->input('summary'),
        ]);
        $session->save();

        return redirect()->route('codetrek.session.index', $codeTrekApplicant->id)->with('success', 'Session updated successfully.');
    }

    public function destroy(Session $session, CodeTrekApplicant $codeTrekApplicant)
    {
        $session = Session::find($session->id);
        $session->delete();

        return redirect()->route('codetrek.session.index', $codeTrekApplicant->id)->with('success', 'Session deleted successfully.');
    }
}
