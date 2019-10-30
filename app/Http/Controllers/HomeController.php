<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
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

        return view('adminlte::companies.companies',compact('company'));
    }

    public static function store(Request $request)
    {

        if(Sentinel::hasAccess(['employee_attachment.create'])) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|max:10000'
            ]);

            if ($validator->fails()) {
                $error = 'The Maximum File Size is 10 Mb. The file that you\'ve uploaded is higher that 10Mb.';
                return response()->json(compact('error'), 200);
            }

            $attachment_delete = Sentinel::hasAccess(['employee_attachment.delete']);
            $role_admin = Sentinel::inRole('admin') ?? '';


            if ($file = $request->file('file')) {

                $file_extension = $request->file->getClientOriginalExtension();
                $mime_type = $request->file->getClientMimeType();

                $user = User::find($request->user_id);

                $file_name = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
                $generated_file_name = 'Employee#' . $request->user_id . '_' . $user->first_name . $user->last_name . '_' . $file_name . '_' . date('Y-m-d_H:i:s');

                $employee_attachments = Employee_attachment::where('file_name', $generated_file_name)->get();

                if (!Storage::exists('employee_attachments/' . $generated_file_name) && $employee_attachments->isEmpty()) {
                    $request->file->storeAs('employee_attachments/', $generated_file_name . '.' . $file_extension);
                } else {
                    $error = 'Such file already exists!';
                    return response()->json(compact('error'), 200);
                };


                if ($mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    $icon_name = 'google_doc.svg';
                } elseif ($mime_type == 'image/jpeg') {
                    $icon_name = 'jpeg.svg';
                } elseif ($mime_type == 'image/png') {
                    $icon_name = 'png.svg';
                } elseif ($mime_type == 'application/octet-stream' || $mime_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    $icon_name = 'google_sheet.svg';
                } elseif ($mime_type == 'application/pdf') {
                    $icon_name = 'pdf.svg';
                } elseif ($mime_type == 'audio/x-m4a' || $mime_type == 'audio/mpeg') {
                    $icon_name = 'mp3.svg';
                } else {
                    $icon_name = 'file.svg';
                }

                $link = 'employee_attachments/' . $generated_file_name;
                $employee_attachment = new Employee_attachment;
                $employee_attachment->user_id = $request->user_id;
                $employee_attachment->link = $link;
                $employee_attachment->original_file_name = $request->file->getClientOriginalName();
                $employee_attachment->file_name = $generated_file_name;
                $employee_attachment->file_extension = $request->file->getClientOriginalExtension();
                $employee_attachment->full_file_name = $generated_file_name . '.' . $file_extension;
                $employee_attachment->link = 'employee_attachments/' . $generated_file_name . '.' . $file_extension;
                $employee_attachment->mime_type = $mime_type;
                $employee_attachment->icon_name = $icon_name;

                $employee_attachment->save();

                $employee_attachments = Employee_attachment::where('user_id', $request->user_id)->get();
                $error = '';

                return response()->json(compact('employee_attachments', 'error', 'attachment_delete', 'role_admin'), 200);

            }
        }
    }
}