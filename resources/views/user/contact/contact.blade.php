@extends('user.layout.master')

@section('content')
    <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="col-lg-10 offset-1">
                        <div class="card col-6 offset-3">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Contact Us</h3>
                                </div>
                                <hr>

                                @if (session('process'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{session('process')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('user#contact') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="row my-3">

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Name</label>
                                                <input id="cc-pament" name="name" type="text" value="" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Name...">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Email</label>
                                                <input id="cc-pament" name="email" type="text" value="" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="example@gmail.com">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Message</label>
                                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" cols="10" rows="10" placeholder="Your Message..."></textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div>
                                                <input type="submit" value="Submit" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END MAIN CONTENT-->
@endsection
