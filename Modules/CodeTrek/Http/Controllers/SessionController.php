<?php

namespace Modules\CodeTrek\Http\Controllers;

use App\Models\Session;
use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\SessionRequest;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CodeTrekApplicant $codeTrekApplicant, int $applicant)
    {
        $codeTrekApplicant = CodeTrekApplicant::findOrFail($applicant);
        $sessions = $codeTrekApplicant->sessions()
        ->orderBy('date', 'desc')
        ->get();

        return view('codetrek::Sessions.index')->with(['codeTrekApplicant' => $codeTrekApplicant, 'sessions' =>$sessions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($session_id, $applicant_id)
    {
        $session = Session::find($session_id);
        $session->delete();

        return redirect()->route('codetrek.session.show', $applicant_id)->with('success', 'Session deleted successfully.');
    }
}
