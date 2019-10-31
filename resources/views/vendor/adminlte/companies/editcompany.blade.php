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
                <h1>Edit Company</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('companies.index') }}"><i class="fa fa-building"></i> Companies</a></li>
                    <li class="active">Edit Company</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Company &nbsp;&nbsp;&nbsp;<span class="text-primary">{{$company->name}}</span></h3>
                    </div>
                    <!-- /.box-header -->
                    <form method="POST" action="{{ route('companies.update',['company_id' => $company->id]) }}" enctype="multipart/form-data">
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
                                <label for="">Name <span class="text-red">*</span></label>
                                <input name="name" type="text" class="form-control" value="{{$company->name}}" {{ $errors->first('name', 'has-error') }}>
                            </div>
                            <div class="form-group">
                                <label for="">E-mail</label>
                                <input name="email" type="text" class="form-control" value="{{$company->email}}" {{ $errors->first('email', 'has-error') }}>
                            </div>
                            <div class="form-group">
                                <label for="">Website</label>
                                <input name="website" type="text" class="form-control" value="{{$company->website}}">
                            </div>
                            @if ( $company->logo_link != '' )
                                <div class="form-group">
                                    <label for="">Current logo</label><br>
                                    <img src="{{ asset('storage/'.str_replace('public/','',$company->logo_link)) }}" alt="Logo" style="max-width:100%;">
                                </div>
                            @endif
                            <div class="form-group {{ $errors->first('logo', 'has-error') }}">
                                <label for="">New logo</label>
                                <input name="logo" type="file">
                                <p class="help-block">min. 100x100</p>
                            </div>
                            <input type="hidden" name="_method" value="PUT">
                            <input name="company_id" type="hidden" class="form-control" value="{{$company->id}}">
                            <input name="_token" type="hidden" class="form-control" value="{{csrf_token()}}">
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
        $('#companies_menu').addClass('active');
    });
</script>
</body>
</html>