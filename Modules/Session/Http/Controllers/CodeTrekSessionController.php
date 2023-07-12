<?php

namespace Modules\Session\Http\Controllers;

use Modules\Session\Entities\Session;
use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\Session\Http\Requests\SessionRequest;

class CodeTrekSessionController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(SessionRequest $request, CodeTrekApplicant $codeTrekApplicant)
    {
        $hiddenValue = $request->input('applicant_id');
        $codeTrekApplicant = CodeTrekApplicant::find($hiddenValue);

        $session = $codeTrekApplicant->sessions()->create([
            'topic_name' => $request->input('topic_name'),
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'level' => $request->input('level'),
            'summary' => $request->input('summary'),
        ]);

        return redirect()->route('codetrek.session.show', $codeTrekApplicant->id)->with('success', 'Session created successfully.');
    }

    public function show(CodeTrekApplicant $codeTrekApplicant, int $applicant)
    {
        $codeTrekApplicant = CodeTrekApplicant::findOrFail($applicant);
        $sessions = $codeTrekApplicant->sessions()
        ->orderBy('date', 'desc')
        ->get();

        return view('session::Codetrek.index')->with(['codeTrekApplicant' => $codeTrekApplicant, 'sessions' =>$sessions]);
    }

    public function edit($id)
    {
        //
    }

    public function update(SessionRequest $request, $id)
    {
        $hiddenValue = $request->input('applicant');

        $session = Session::find($id);
        $session->update([
            'topic_name' => $request->input('topic_name'),
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'level' => $request->input('level'),
            'summary' => $request->input('summary'),
        ]);
        $session->save();

        return redirect()->route('codetrek.session.show', $hiddenValue)->with('success', 'Session updated successfully.');
    }

    public function destroy($session_id, $applicant_id)
    {
        $session = Session::find($session_id);
        $session->delete();

        return redirect()->route('codetrek.session.show', $applicant_id)->with('success', 'Session deleted successfully.');
    }
}
