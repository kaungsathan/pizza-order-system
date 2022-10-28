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
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Account Info</h3>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-4 offset-1 mt-5">
                                            @if (Auth::user()->image == null)
                                                @if (Auth::user()->gender == 'male')
                                                    <img src="{{ asset('image/default_user.png') }}" alt="Admin" />
                                                @else
                                                    <img src="{{ asset('image/female-default.jpg') }}" alt="Admin" />
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/'.Auth::user()->image) }}" />
                                            @endif
                                        </div>

                                        <div class="col-6 offset-1">
                                            <h4 class="my-4"><i class="fa-solid fa-user me-3"></i> {{ Auth::user()->name }}</h4>
                                            <h4 class="my-4"><i class="fa-solid fa-envelope me-3"></i> {{ Auth::user()->email }}</h4>
                                            <h4 class="my-4"><i class="fa-solid fa-phone me-3"></i> {{ Auth::user()->phone }}</h4>
                                            <h4 class="my-4"><i class="fa-solid fa-venus-mars me-3"></i> {{ Auth::user()->gender }}</h4>
                                            <h4 class="my-4"><i class="fa-solid fa-location-dot me-3"></i> {{ Auth::user()->address }}</h4>
                                            <h4 class="my-4"><i class="fa-solid fa-user-clock me-3"></i> {{ Auth::user()->created_at->format('j-F-Y') }}</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3 offset-10 my-4">
                                            <a href="{{ route('admin#edit') }}">
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
