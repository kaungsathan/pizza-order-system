@extends('admin.layouts.master')

@section('title','Users')

@section('content')
    <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">User List</h2>

                                    </div>
                                </div>
                            </div>
                            @if (session('process'))
                                <div class="col-4 offset-8">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        {{ session('process') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            {{-- search bar --}}
                            <div class="row">
                                <div class="col-3">
                                    <h4>Search: <span class="text-danger">{{ request('key') }}</span></h4>
                                </div>

                                <div class="col-3 offset-6">
                                    <form action="{{ route('admin#listPage') }}">
                                        <div class="d-flex">
                                            <input type="text" name="key" value="{{ request('key') }}" class="form-control" placeholder="Name...">
                                            <button type="submit" class="btn btn-dark">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 text-center">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Role</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="tr-shadow">

                                                <td class="col-1">
                                                    @if ($user->image != null)
                                                        <img src="{{ asset('storage/'. $user->image) }}">
                                                    @else
                                                        @if ($user->gender == 'male')
                                                            <img src="{{ asset('image/default_user.png') }}">
                                                        @else
                                                            <img src="{{ asset('image/female-default.jpg') }}">
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>

                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->gender }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>
                                                    <select class="form-select form-select-sm roleStatus" aria-label=".form-select-sm example" data-id="{{ $user->id }}">
                                                        <option value="user" selected>User</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="userDelBtn" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $user->id }}">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="my-4">
                                    {{ $users->links() }}
                                </div>

                            </div>

                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
@endsection

@section('jqScriptCode')
    <script>
        $(document).ready(function(){
            $('.roleStatus').change(function(){
              var role = $(this).val();
              var userId = $(this).data('id');

              $.ajax({
                type : 'get',
                url : 'http://localhost:8000/admin/account/user/role',
                data : {
                    'userId' : userId,
                    'role' : role
                }
              });

              $(this).parents('tr').remove();
            });

            $('.userDelBtn').click(function(){

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/admin/account/user/delete',
                    data : { 'userId' : $(this).data('id') },
                    dataType : 'json'
                });

                $(this).parents('tr').remove();
            });
        });
    </script>
@endsection
