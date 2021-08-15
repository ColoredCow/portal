<?php

namespace Modules\LegalDocument\Http\Controllers\NDA;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\LegalDocument\Entities\LegalDocumentMailTemplate;

class NDAMailTemplateController extends Controller
{

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('legaldocument::nda.communications.mails.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $legalDocumentTemplate = LegalDocumentMailTemplate::create($request->all());

        return redirect(route('legal-document.nda.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $template = LegalDocumentMailTemplate::find($id);

        return view('legaldocument::nda.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('legaldocument::nda.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $legalDocumentTemplate = LegalDocumentMailTemplate::find($id)->update($request->all());

        return redirect(route('legal-document.nda.index'));
    }

    public function showPreview(Request $request)
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
