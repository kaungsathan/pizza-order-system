@extends('admin.layouts.master')

@section('title','AdminCategoryList')

@section('content')
    <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-lg-10 offset-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="ms-2">
                                        <i class="fa-solid fa-left-long" onclick="history.back()"></i>
                                    </div>
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Pizza Info</h3>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-4 offset-1 mt-4">
                                            <img src="{{ asset('storage/'. $pizza->image) }}" class="shadow-sm" />
                                        </div>

                                        <div class="col-6 offset-1">
                                            <h3 class="my-4"> {{ $pizza->name }}</h3>
                                            <button class="my-2 btn btn-dark"><i class="fa-solid fa-money-bill-wave me-1"></i> {{ $pizza->price}}</button>
                                            <button class="my-2 btn btn-dark"><i class="fa-solid fa-bars-staggered"></i> {{ $pizza->category_name}}</button>
                                            <button class="my-2 btn btn-dark"><i class="fa-solid fa-eye me-1"></i> {{ $pizza->view_count}}</button>
                                            <button class="my-2 btn btn-dark"><i class="fa-solid fa-user-clock me-1"></i> {{ $pizza->created_at->format('j-F-Y') }}</button>
                                            <div class="my-4"><i class="fa-solid fa-file-lines me-3"></i> Description</div>
                                            <div>{{ $pizza->description }}</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3 offset-10 my-4">
                                            <a href="{{ route('product#updatePage',$pizza->id) }}">
                                                <button class="btn btn-dark">
                                                    <i class="fa-solid fa-pen-to-square me-3"></i> Edit Profile
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
@endsection
