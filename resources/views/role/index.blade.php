@extends('layouts.master')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('breadcrumb')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Role</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @can('dashboard.show')
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                @endcan
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All role list with role permission</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dtable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ ucfirst(data_get($role, 'name')) }}
                            </td>
                            <td>{{ data_get($role, 'label') }}</td>
                            <td>{{ Carbon\Carbon::create(data_get($role, 'created_at'))->toFormattedDateString() }}</td>
                            <td>
                                <div class="btn-group">
                                    {{-- <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-info btn-sm"
                                        title="Edit {{ data_get($role, 'name') }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a> --}}
                                    @can('user.delete')
                                        <a href="#" class="btn btn-danger btn-sm"
                                            title="Delete {{ data_get($role, 'name') }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    @endcan
                                    @can('role.edit')
                                        <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-success btn-sm"
                                            title="Change Permission of {{ data_get($role, 'name') }}">
                                            <i class="fas fa-key"></i> Change Permission
                                        </a>
                                    @endcan
                                    {{-- <a href="#" class="btn btn-success btn-sm"
                                        title="Show {{ data_get($user, 'name') }}">
                                        <i class="fas fa-eye"></i>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@push('js')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#dtable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#dtable_wrapper .col-md-6:eq(0)');

        });
    </script>
@endpush
