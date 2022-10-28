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
                                        <h3 class="text-center title-2">Edit Product</h3>
                                    </div>
                                    <hr>

                                    <form action="{{ route('product#update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $pizza->id }}">
                                        <div class="row">
                                            <div class="col-4 offset-1">
                                                    <img src="{{ asset('storage/'.$pizza->image) }}" alt="Admin" />
                                                <div class="mt-3">
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-dark col-12">Update</button>
                                                </div>
                                            </div>

                                            <div class="row col-6 my-3">
                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1">Name</label>
                                                    <input id="cc-pament" name="name" type="text" value="{{ old('name',$pizza->name) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Name...">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1">Description</label>
                                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="10">{{ old('description',$pizza->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1">Category</label>
                                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                                        <option value="">Choose category...</option>
                                                        @foreach ($category as $c)
                                                            <option value="{{ $c->id }}" @if($pizza->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1">Price</label>
                                                    <input id="cc-pament" name="price" type="text" value="{{ old('price',$pizza->price) }}" class="form-control @error('price') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="MMK">
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1">Created Date</label>
                                                    <input id="cc-pament" name="created_at" type="text" value="{{ old('created_at',$pizza->created_at->format('j-F-Y')) }}" class="form-control" aria-required="true" aria-invalid="false" disabled>
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
