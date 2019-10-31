<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
@include('adminlte::layouts.partials.htmlheader')
@show

        <!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-mini">
<div id="app" v-cloak>
    <div class="wrapper">

        @include('adminlte::layouts.partials.mainheader')

        @include('adminlte::layouts.partials.sidebar')

                <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Show Employee</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('employees.index') }}"><i class="fa fa-users"></i> Employees</a></li>
                    <li class="active">Show Employee</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Employee &nbsp;&nbsp;&nbsp;<span class="text-primary">{{$employee->first_name}} {{$employee->last_name}}</span></h3>
                    </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            @if (count($errors) > 0)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger">
                                            <strong>Errors!</strong><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="">First Name <span class="text-red">*</span></label>
                                <input name="first_name" type="text" class="form-control" value="{{$employee->first_name}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Last Name <span class="text-red">*</span></label>
                                <input name="last_name" type="text" class="form-control" value="{{$employee->last_name}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Company</label>
                                <select id="company_id" name="company_id" class="form-control" disabled>
                                    <option value="0">...</option>
                                    @if ( count($companies) )
                                        @foreach( $companies as $company )
                                            <option value="{{$company->id}}" @if ( $company->id == $employee->company_id ) selected @endif>{{$company->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">E-mail</label>
                                <input name="email" type="text" class="form-control" value="{{$employee->email}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input name="phone" type="text" class="form-control" value="{{$employee->phone}}" disabled>
                            </div>
                        </div>
                    <!-- /.box-body -->
                </div>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('adminlte::layouts.partials.controlsidebar')

        @include('adminlte::layouts.partials.footer')

    </div><!-- ./wrapper -->
</div>
@section('scripts')
    @include('adminlte::layouts.partials.scripts')
@show

</body>
</html>