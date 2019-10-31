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
                <h1>Create Employee</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('employees.index') }}"><i class="fa fa-users"></i> Employees</a></li>
                    <li class="active">Create Employee</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Employee</h3>
                    </div>
                    <!-- /.box-header -->
                    <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
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
                                <input name="_token" type="hidden" class="form-control" value="{{csrf_token()}}">
                            </div>
                            <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                <label for="">First Name <span class="text-red">*</span></label>
                                <input name="first_name" type="text" class="form-control">
                            </div>
                            <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                <label for="">Last Name <span class="text-red">*</span></label>
                                <input name="last_name" type="text" class="form-control">
                            </div>
                            <div class="form-group {{ $errors->first('company_id', 'has-error') }}">
                                <label for="">Company</label>
                                <select id="company_id" name="company_id" class="form-control">
                                    <option value="0">...</option>
                                    @if ( count($companies) )
                                        @foreach( $companies as $company )
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                <label for="">E-mail</label>
                                <input name="email" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input name="phone" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
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
<script>
    $(document).ready(function(){
        $('#employees_menu').addClass('active');
    });
</script>
</body>
</html>