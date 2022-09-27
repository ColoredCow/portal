<?php

namespace Modules\Expense\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Expense\Services\ExpenseService;

class ExpenseController extends Controller
{
    protected $service;

    public function __construct(ExpenseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('expense::index', ['expenses' => $this->service->index()]);
    }

    public function create()
    {
        return view('expense::create');
    }

    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect()->route('expense.index');
    }

    public function edit($id)
    {        
        return view('expense::edit',$this->service->edit($id));
    }
    
    public function update(Request $request,$id)
    {
        $this->service->update($request->all(), $id);

        return redirect()->route('expense.index');
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return redirect()->route('expense.index');
    }
}
