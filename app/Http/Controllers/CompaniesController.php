<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class CompaniesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Company::all();

        return view('adminlte::companies.companies', compact('companies'));
    }

    public function create(){
        return view('adminlte::companies.addcompany');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'logo' => 'mimes:jpeg,png,gif|dimensions:min_width=100,min_height=100',
        ]);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $company = new Company();

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if ( $file = $request->file('logo') ) {

            $file_name = pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_FILENAME);
            $file_extension = $request->file('logo')->getClientOriginalExtension();
            $generated_file_name = $file_name . '_' . date('H:i:s');
            $file_path = 'public/logos/' . date('Y') . '/' . date('m') . '/' . date('d');

            if ( !Storage::exists($file_path ) ) {
                Storage::makeDirectory($file_path, 0777, true);
                $request->file('logo')->storeAs($file_path, $generated_file_name . '.' . $file_extension);
            } else {
                $request->file('logo')->storeAs($file_path, $generated_file_name . '.' . $file_extension);
            }

            $company->logo_link = $file_path . '/' . $generated_file_name . '.' . $file_extension;
        }

        $company->save();

        session()->flash('success', 'New company \'' . $company->name . '\' was added successfully');
        return redirect('/companies');
    }

    public function show($company_id){
        $company = Company::find($company_id);

        return view('adminlte::companies.showcompany', compact('company'));
    }

    public function update(Request $request){
        $company = Company::find($request->company_id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'logo' => 'mimes:jpeg,png,gif|dimensions:min_width=100,min_height=100',
        ]);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if ( $file = $request->file('logo') ) {

            Storage::delete(storage_path() . '/app/' . $company->logo_link);

            $file_name = pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_FILENAME);
            $file_extension = $request->file('logo')->getClientOriginalExtension();
            $generated_file_name = $file_name . '_' . date('H:i:s');
            $file_path = 'public/logos/' . date('Y') . '/' . date('m') . '/' . date('d');

            if ( !Storage::exists($file_path) ) {
                Storage::makeDirectory($file_path, 0777, true);
                $request->file('logo')->storeAs($file_path, $generated_file_name . '.' . $file_extension);
            } else {
                $request->file('logo')->storeAs($file_path, $generated_file_name . '.' . $file_extension);
            }

            $company->logo_link = $file_path . '/' . $generated_file_name . '.' . $file_extension;
        }

        $company->save();

        session()->flash('success', 'Changes was saved successfully');
        return redirect('/companies');
    }

    public function edit($company_id){
        $company = Company::find($company_id);

        return view('adminlte::companies.editcompany', compact('company'));
    }

    public function destroy(Company $company){
        Storage::delete(storage_path() . '/app/' . $company->logo_link);
        $company->delete();

        session()->flash('success', 'Company was deleted successfully');
        return redirect('/companies');
    }

    public function searchcompanies(){
        $companies = Company::where('name','LIKE','%' . request('f_search') . '%')->limit(10)->get();

        $c_temp = [];
        if ( count($companies) ) {
            foreach ($companies as $c) {
                $c_temp_arr = [];
                $c_temp_arr['label'] = $c->name;
                $c_temp_arr['value'] = $c->id;
                $c_temp[] = $c_temp_arr;
            }
        }

        if ( count($companies) ) {
            return response(array('success' => "true", 'org' => $c_temp), 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }


}