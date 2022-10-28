@extends('admin.layouts.master')

@section('title','AdminCategoryList')

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
                                        <h2 class="title-1">Admin List</h2>

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
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admin as $a)
                                            <tr class="tr-shadow">

                                                <td class="col-1">
                                                    @if ($a->image != null)
                                                        <img src="{{ asset('storage/'. $a->image) }}">
                                                    @else
                                                        @if ($a->gender == 'male')
                                                            <img src="{{ asset('image/default_user.png') }}">
                                                        @else
                                                            <img src="{{ asset('image/female-default.jpg') }}">
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $a->name }}</td>

                                                <td>{{ $a->email }}</td>
                                                <td>{{ $a->gender }}</td>
                                                <td>{{ $a->phone }}</td>
                                                <td>{{ $a->address }}</td>
                                                <td>
                                                    <div class="table-data-feature">

                                                        @if (Auth::user()->id != $a->id)
                                                            <select class="form-select form-select-sm roleStatus roleStatus col-9" aria-label=".form-select-sm example" data-id="{{ $a->id }}">
                                                                <option value="admin" selected>Admin</option>
                                                                <option value="user">User</option>
                                                            </select>

                                                            <a class="ms-3" href="{{ route('admin#delete',$a->id) }}">
                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="my-4">
                                    {{ $admin->links() }}
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

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/admin/role/change',
                    data : { 'adminId' : $(this).data('id') },
                    dataType : 'json'
                });

                $(this).parents('tr').remove();
            });
        });
    </script>
@endsection
