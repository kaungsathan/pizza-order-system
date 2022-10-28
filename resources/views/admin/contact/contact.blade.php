@extends('admin.layouts.master')

@section('title','Contact')

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
                                        <h2 class="title-1">Contact List</h2>

                                    </div>
                                </div>
                            </div>

                            {{-- search bar --}}
                            <div class="row">
                                <div class="col-3">
                                    <h4>Search: <span class="text-danger">{{ request('key') }}</span></h4>
                                </div>

                                <div class="col-3 offset-6">
                                    <form action="{{ route('admin#contactList') }}">
                                        <div class="d-flex">
                                            <input type="text" name="key" value="{{ request('key') }}" class="form-control" placeholder="name...">
                                            <button type="submit" class="btn btn-dark">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if (count($contact) != 0)
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2 text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contact as $c)
                                                <tr class="tr-shadow">

                                                    <td>{{ $c->id }}</td>
                                                    <td>{{ $c->name }}</td>
                                                    <td>{{ $c->email }}</td>
                                                    <td>{{ $c->created_at->format('j-F-Y') }}</td>
                                                    <td>
                                                        <div class="table-data-feature">
                                                            <a href="{{ route('admin#contactDetail',$c->id) }}">
                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </button>
                                                            </a>


                                                            <button class="ms-3 delBtn" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $c->id }}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>

                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <div class="my-4">
                                        {{ $contact->appends(request()->query())->links() }}
                                    </div>

                                </div>
                            @else
                                <h3 class="text-secondary text-center mt-5">There is no contact here!</h3>
                            @endif
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
            $('.delBtn').click(function(){
                var contactId = $(this).data('id');

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/admin/contact/delete',
                    data : {'contactId' : contactId},
                    dataType : 'json'
                });

                $(this).parents('tr').remove();
            });
        });
    </script>
@endsection
