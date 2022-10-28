@extends('admin.layouts.master')

@section('title','Contact information')

@section('content')
    <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-lg-10 offset-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Contact Info</h3>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="mt-5">
                                            <h4 class="my-3">Name : {{ $contact->name }}</h4>
                                            <h4 class="my-3">Email : {{ $contact->email }}</h4>
                                            <div>
                                                <h4 class="my-3">Message :</h4>
                                                {{ $contact->message }}
                                            </div>
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
