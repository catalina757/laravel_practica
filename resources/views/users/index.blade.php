@extends('layout.base')

@include('components.topbar')
@include('components.nav')


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper" style="min-height: 1170.12px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Is Verified</th>
                        <th style="width: 100px">Role</th>
                        <th style="width: 40px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if ($user->email_verified_at)
                                    <span class="badge bg-primary">Verified</span>
                                @else
                                    <span class="badge bg-warning">Unverified</span>
                                @endif
                            </td>
                            <td>{{$user->role === \App\Models\User::ROLE_ADMIN ? 'Admin' : 'User'}}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-xs btn-primary mr-3" type="button"
                                            data-user="{{json_encode($user)}}" data-toggle="modal"
                                            data-target="#edit-modal">
                                        <i class="fas fa-edit"></i></button>
                                    <button class="btn btn-xs btn-danger" type="button"
                                            onclick="prepareToDelete({{ $user->id }})" data-toggle="modal"
                                            data-target="#delete-modal">
                                        <i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix  d-flex justify-content-end">
                {{ $users->onEachSide(2)->links() }}
            </div>
        </div>

        <script>
            let toDelete = null;

            function prepareToDelete(id) {
                toDelete = id;
            }

            function willDelete() {
                $.post( "/users/delete", {
                    "_token": "{{ csrf_token() }}",
                    id: toDelete,
                }).done(function() {
                    location.reload();
                });
            }

            function cancelDeleteConfirmation() {
                toDelete = null;
            }

        </script>

        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog">
                <form action="" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="editName"></div>
                            <input type="hidden" name="editId" value=""/>
                            <div class="form-group">
                                <label for="editRole">Role</label>
                                <select class="custom-select rounded-0" id="editRole">
                                    <option value="{{\App\Models\User::ROLE_USER}}">User</option>
                                    <option value="{{\App\Models\User::ROLE_ADMIN}}">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Do you want to delete user?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer justify-content-around">
                        <button type="button" class="btn btn-primary" onclick="willDelete();">Confirm</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancelDeleteConfirmation()">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    </div>
    <!-- /.content -->
@endsection

