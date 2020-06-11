<?php

namespace App\Http\Controllers;

use App\Employes;
use App\Companies;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = Employes::paginate(10);
        return view('employes.index', compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Companies::select('id', 'name')->get();
        return view('employes.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);
        $data = $request->all();

        if ($data['company_id'] == 0) {
            $data['company_id'] = null;
        }
        Employes::create($data);

        return redirect()->route('employes.index')
            ->with('success', 'Employer created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employes = Employes::find($id);
        $companies = Companies::get();
        return view('employes.edit', compact('employes', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employes  $employes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Employes  $employes)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $data = $request->all();
        if ($data['company_id'] == 0) {
            $data['company_id'] = null;
        }

        $employes = Employes::find($data['id']);
        $employes->update($data);

        return redirect()->route('employes.index')
            ->with('success', 'Employer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employes::find($id)->delete();

        return redirect()->route('employes.index')
            ->with('success', 'Employer deleted successfully');
    }

    public function show($id)
    {
        $employes=Employes::find($id);
        return view('employes.show',compact('employes'));
    }
}
