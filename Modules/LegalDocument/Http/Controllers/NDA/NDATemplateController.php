<?php
namespace Modules\LegalDocument\Http\Controllers\NDA;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LegalDocument\Entities\LegalDocumentTemplate;

class NDATemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = LegalDocumentTemplate::all();

        return view('legaldocument::nda.templates.index', ['templates' => $templates]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('legaldocument::nda.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        LegalDocumentTemplate::create($request->all());

        return redirect(route('legal-document.nda.template.index'));
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        $template = LegalDocumentTemplate::find($id);

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
        LegalDocumentTemplate::find($id)->update($request->all());

        return redirect(route('legal-document.nda.template.index'));
    }

    public function showPreview()
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
