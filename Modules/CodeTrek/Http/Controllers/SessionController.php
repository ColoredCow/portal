    <?php

namespace Modules\CodeTrek\Http\Controllers;

use App\Models\Session;
use Google\Service\CloudSearch\Id;
use Google\Service\CloudTrace\Module;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Http\Requests;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\SessionRequest;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CodeTrekApplicant $codeTrekApplicant)
    {   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CodeTrekApplicant $codeTrekApplicant)
    {
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
        
        $topicName = $request->input('topic_name');
        $date = $request->input('date');
        $link = $request->input('link');
        $level = $request->input('level');
        $summary = $request->input('summary');

        $session = $codeTrekApplicant->sessions()->create([
            'topic_name' => $topicName,
            'date' => $date,
            'link' => $link,
            'level' => $level,
            'summary' => $summary,
        ]);

        // $codeTrekApplicant->sessions()->save($session);

        return redirect()->route('codetrek.session.show', $codeTrekApplicant->id)
            ->with('success', 'Session created successfully.');
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

        $sessions= $codeTrekApplicant->sessions()
        ->orderBy('date', 'desc')
        ->get();

        return view('codetrek::Sessions.index')->with(['codeTrekApplicant' => $codeTrekApplicant,'sessions' =>$sessions]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CodeTrekApplicant $codeTrekApplicant)
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


    public function update(SessionRequest $request, int $id)
    {
        $hiddenValue = $request->input('applicant');

        $topicName = $request->input('topic_name');
        $date = $request->input('date');
        $link = $request->input('link');
        $level = $request->input('level');
        $summary = $request->input('summary');

        $session = Session::find($id);
        $session->update([
            'topic_name' => $topicName,
            'date' => $date,
            'link' => $link,
            'level'=> $level,
            'summary' => $summary
        ]);

        $session->save();

        return redirect()->route('codetrek.session.show',$hiddenValue)
            ->with('success', 'Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($session_id, $applicant_id )
    {   
        
        $session = Session::find($session_id);
        $session->delete();

        return redirect()->route('codetrek.session.show',$applicant_id)->with('success', 'Session deleted successfully.');
    }
}
