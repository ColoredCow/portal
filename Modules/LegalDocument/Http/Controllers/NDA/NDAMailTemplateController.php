<?php
namespace Modules\LegalDocument\Http\Controllers\NDA;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LegalDocument\Entities\LegalDocumentMailTemplate;

class NDAMailTemplateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('legaldocument::nda.communications.mails.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        LegalDocumentMailTemplate::create($request->all());

        return redirect(route('legal-document.nda.index'));
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        $template = LegalDocumentMailTemplate::find($id);

        return view('legaldocument::nda.templates.show', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        LegalDocumentMailTemplate::find($id)->update($request->all());

        return redirect(route('legal-document.nda.index'));
    }

    public function showPreview()
    {
        $template = LegalDocumentMailTemplate::find(request('template_id'));
        $data = [
            'company' => '',
            'recipient' => 'ColoredCow',
            'recipientResourceName' => '',
            'current_date' => date('m d Y'),
        ];

        $finalData = array_merge($data, request()->all());
        $pdf = app('snappy.pdf.wrapper');
        $pdf->loadHTML($template->parse($finalData));

        return $pdf->inline();
    }
}
