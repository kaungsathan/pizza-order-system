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
                                        <h2 class="title-1">Product List</h2>

                                    </div>
                                </div>
                                <div class="table-data__tool-right">
                                    <a href="{{ route('product#createPage') }}">
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>Add Product
                                        </button>
                                    </a>
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        CSV download
                                    </button>
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
                                    <form action="{{ route('product#list') }}">
                                        <div class="d-flex">
                                            <input type="text" name="key" value="{{ request('key') }}" class="form-control">
                                            <button type="submit" class="btn btn-dark">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if (count($pizzas) != 0)
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2 text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Category</th>
                                                <th>View Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pizzas as $pizza)
                                                <tr class="tr-shadow">
                                                    <td>{{ $pizza->id }}</td>
                                                    <td><img src="{{ asset('storage/'. $pizza->image) }}" width="150"></td>
                                                    <td>{{ $pizza->name }}</td>
                                                    <td>{{ $pizza->price }}</td>

                                                    <td>{{ $pizza->category_name }}</td>
                                                    {{-- database relation --}}

                                                    <td><i class="fa-solid fa-eye"></i> {{ $pizza->view_count }}</td>
                                                    <td>
                                                        <div class="table-data-feature">
                                                            <a href="{{ route('product#viewPage',$pizza->id) }}">
                                                                <button class="item me-2" data-toggle="tooltip" data-placement="top" title="View">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </button>
                                                            </a>

                                                            <a href="{{ route('product#updatePage',$pizza->id) }}">
                                                                <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                            </a>

                                                            <a href="{{ route('product#delete',$pizza->id) }}">
                                                                <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="my-4">
                                        {{ $pizzas->links() }}
                                    </div>
                                </div>
                            @else
                                <h3 class="text-secondary text-center mt-5">There is no product here!</h3>
                            @endif

                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
@endsection
