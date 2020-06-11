<?php

namespace App\Http\Controllers;

use App\Companies;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $companies = Companies::paginate(10);

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'name' => 'required',
            'email' => 'email',
            'logo' => 'mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100|max:3000'
        ]);

        $file = '';

        if ($request->file('logo')) {
            $file = $this->saveFile($request->file('logo'), '_logo');
        }
        $data['logo'] = $file;


        Companies::create($data);

        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function edit(Companies $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Companies $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email',
            'logo' => 'mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100|max:3000'
        ]);
        $data = $request->all();

        if ($request->file('logo')) {
            $this->deleteFile($company->logo);
            $file = $this->saveFile($request->file('logo'), '_logo');
            $data['logo'] = $file;
        }


        $company->update($data);

        return redirect()->route('companies.index')
            ->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Companies $company)
    {
        $this->deleteFile($company->logo);
        $company->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully');
    }


    public function saveFile($image, $prefix)
    {
        $name = time() . '_' . $prefix . '.' . $image->getClientOriginalExtension();
        $destinationPath = base_path() . "/public/uploads/";
        $image->move($destinationPath, $name);
        return "/uploads/" . $name;
    }

    public function deleteFile($file)
    {
        $path = base_path() . "/public";
        if ($file != '' && file_exists($path . $file)) {
            unlink($path . $file);
        } else {
            return false;
        }
    }

    public function show(Companies $company)
    {
        return view('companies.show', compact('company'));
    }
}
