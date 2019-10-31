<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class EmployeesController extends Controller
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
        $employees = Employee::with('company')->paginate(10);

        return view('adminlte::employees.employees', compact('employees'));
    }

    public function create(){
        $companies = Company::all();

        return view('adminlte::employees.addemployee', compact('companies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email',
            'company_id' => 'required|numeric|min:0|not_in:0',
        ]);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $employee = new Employee();

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();

        session()->flash('success', 'New employee \'' . $employee->first_name . ' ' . $employee->last_name . '\' was added successfully');
        return redirect('/employees');
    }

    public function show($employee_id){
        $employee = Employee::find($employee_id);
        $companies = Company::all();

        return view('adminlte::employees.showemployee', compact('employee','companies'));
    }

    public function update(Request $request){
        $employee = Employee::find($request->employee_id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email',
            'company_id' => 'required|numeric|min:0|not_in:0',
        ]);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();

        session()->flash('success', 'Changes was saved successfully');
        return redirect('/employees');
    }

    public function edit($employee_id){
        $employee = Employee::find($employee_id);
        $companies = Company::all();

        return view('adminlte::employees.editemployee', compact('employee','companies'));
    }

    public function destroy(Employee $employee){
        $employee->delete();

        session()->flash('success', 'Employee was deleted successfully');
        return redirect('/employees');
    }


}