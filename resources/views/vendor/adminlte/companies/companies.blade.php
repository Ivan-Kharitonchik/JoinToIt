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
                <h1>Companies</h1>
                <ol class="breadcrumb">
                    <li class="active"><i class="fa fa-building"></i> Companies</li>
                </ol>
            </section>

                    <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Companies List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <a href="{{URL::to('/companies/create')}}" class="btn btn-primary">Create company</a>
                        </div>
                            {{-- page alerts start--}}
                            @if ( $flash = session('success') )
                                <div id="flash-message-success" class="alert alert-success">
                                    {{ $flash }}
                                    {{ Session::forget('success') }}
                                </div>
                            @elseif( $flash = session('error') )
                                <div id="flash-message-attach-no" class="alert alert-danger">
                                    {{ $flash }}
                                    {{ Session::forget('error') }}
                                </div>
                            @endif
                            {{-- page alerts end--}}
                        @if ( count($companies) )
                            <div id="companies_table" class="table-scrollable">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>E-mail</th>
                                            <th>Website</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $companies as $company )
                                            <tr>
                                                <td>
                                                    @if ( $company->logo_link != '' )
                                                        {{--<img src="{{ storage_path('app/'.$company->logo_link) }}" alt="Logo">--}}
                                                        <img src="{{ asset('storage/'.str_replace('public/','',$company->logo_link)) }}" alt="Logo" style="width:50px;">
                                                    @endif
                                                </td>
                                                <td>{{$company->name}}</td>
                                                <td>{{$company->email}}</td>
                                                <td>{{$company->website}}</td>
                                                <td style="white-space:nowrap;">
                                                    <a href="{{ route('companies.show', ['company_id' => $company->id]) }}" class="btn btn-success" title="Show">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('companies.edit', ['company_id' => $company->id]) }}" class="btn btn-primary" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>

                                                    <form method="POST" action="{{ route('companies.destroy', ['company_id' => $company->id]) }}" style="display:inline;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <button type="submit" class="btn btn-danger" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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