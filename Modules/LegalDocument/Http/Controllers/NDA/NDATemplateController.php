<?php

namespace Modules\LegalDocument\Http\Controllers\NDA;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\LegalDocument\Entities\LegalDocumentTemplate;

class NDATemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('legaldocument::nda.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $legalDocumentTemplate = LegalDocumentTemplate::create($request->all());
        return redirect(route('legal-document.nda.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $template = LegalDocumentTemplate::find($id);
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
        $legalDocumentTemplate = LegalDocumentTemplate::find($id)->update($request->all());
        return redirect(route('legal-document.nda.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function showPreview(Request $request)
    {
        $template = LegalDocumentTemplate::find(request('template_id'));
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
