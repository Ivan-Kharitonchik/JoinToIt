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
                <h1>Employees</h1>
                <ol class="breadcrumb">
                    <li class="active"><i class="fa fa-users"></i> Employees</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Employees List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <a href="{{URL::to('/employees/create')}}" class="btn btn-primary">Create employee</a>
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
                        @if ( count($employees) )
                            <div id="employees_table" class="table-scrollable">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>E-mail</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ( $employees as $employee )
                                        <tr>
                                            <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                                            <td>
                                                @if ( $employee->company != NULL )
                                                    {{$employee->company->name}}
                                                @endif
                                            </td>
                                            <td>{{$employee->email}}</td>
                                            <td>{{$employee->phone}}</td>
                                            <td style="white-space:nowrap;">
                                                <a href="{{ route('employees.show', ['employee_id' => $employee->id]) }}" class="btn btn-success" title="Show">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('employees.edit', ['employee_id' => $employee->id]) }}" class="btn btn-primary" title="Edit">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>

                                                <form method="POST" action="{{ route('employees.destroy', ['employee_id' => $employee->id]) }}" style="display:inline;">
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
                            @if ( count($employees) )
                                <?php echo $employees->appends(request()->except('page'))->links(); ?>
                            @endif
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
<script>
    $(document).ready(function(){
        $('#employees_menu').addClass('active');
    });
</script>
</body>
</html>