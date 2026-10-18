<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;



class CompanyController extends Controller
{

    public  $industries = [ 'Technology', 'Healthcare','Finance','Education','Retail','Manufacturing','Other',];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::latest();

        if($request->input('archived') == 'true'){
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create' , compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        $validatedData = $request->validated();
        //create owner
        $owner = User::create([
            'name' => $validatedData['Owner_name'],
            'email' => $validatedData['Owner_email'],
            'password' => Hash::make($validatedData['Owner_password']),
            'role' => 'company-owner',
        ]);

        //Return error if owner creation failed
        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Failed to create owner. Please try again.');
        }

        //create company
        Company::create([
            'name' => $validatedData['name'],
            'industry' => $validatedData['industry'],
            'address' => $validatedData['address'],
            'website' => $validatedData['website'],
            'ownerId' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        $industries = $this->industries;
        return view('company.edit', compact('company' , 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $company = Company::findOrFail($id);

        $company->update([
            'name' => $validatedData['name'],
            'industry' => $validatedData['industry'],
            'address' => $validatedData['address'],
            'website' => $validatedData['website'],
        ]);

        //update owner
        $ownerData =[];
        $ownerData['name'] = $validatedData['Owner_name'];

        if (!empty($validatedData['Owner_password'])) {
            $ownerData['password'] = Hash::make($validatedData['Owner_password']);
        }

        $company->owner->update($ownerData);

        if($request->query('redirectToList')=='false'){
            return redirect()->route('companies.show' , $id)->with('success', 'Company updated successfully.');
        }

            return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company archived successfully.');
    }

    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'Company restored successfully.');
    }
}
