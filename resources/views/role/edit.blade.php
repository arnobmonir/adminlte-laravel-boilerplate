@extends('layouts.master')
@section('breadcrumb')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Permission</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @can('role.show')
                    <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Role</a></li>
                @endcan
                <li class="breadcrumb-item active">Permissions</li>
            </ol>
        </div><!-- /.col -->
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Role Name:*</label>
                                <input class="form-control" disabled value="{{ $role->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-3">
                            <label>Permissions:</label>
                        </div>
                    </div>
                    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @foreach ($groups as $menu)
                            <div class="row check_group">
                                <div class="col-md-3">
                                    <h4>{{ $menu->name }}</h4>
                                </div>

                                <div class="col-md-9">
                                    <div class="row">
                                        @foreach (data_get($menu, 'permissions') as $permission)
                                            <div class="col-md-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="permission-{{ $permission->id }}" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        @if (in_array($permission->id, $permissions_ids)) checked @endif>
                                                    <label for="permission-{{ $permission->id }}"
                                                        class="custom-control-label">{{ $permission->label }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-sm btn-primary pull-right button-effect effect-5">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
