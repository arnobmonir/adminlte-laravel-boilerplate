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
            <h1 class="m-0">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @can('dashboard.show')
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                @endcan
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All user list with details</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dtable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ strtoupper(data_get($user, 'uuid')) }}</td>
                            <td>{{ ucfirst(data_get($user, 'name')) }}
                            </td>
                            <td>{{ data_get($user, 'roles.0.name') }}</td>
                            <td>{{ data_get($user, 'email') }}</td>
                            <td> {{ data_get($user, 'phone', 'No Phone') }}</td>
                            <td>{{ Carbon\Carbon::create(data_get($user, 'created_at'))->toFormattedDateString() }}</td>
                            <td>
                                <div class="btn-group">
                                    @can('user.edit')
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-info btn-sm"
                                            title="Edit {{ data_get($user, 'name') }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <a href="#" class="btn btn-warning btn-sm"
                                            title="Delete {{ data_get($user, 'name') }}">
                                            <i class="fas fa-key"></i> Change Password
                                        </a>
                                    @endcan
                                    @can('user.delete')
                                        @if (Auth::user()->id != $user->id)
                                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete {{ data_get($user, 'name') }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
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
    <!-- DataTables  & Plugins -->
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
