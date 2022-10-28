@extends('user.layout.master')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/'.$product->image) }}" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $product->name }}</h3>
                    <div class="d-flex mb-3">
                        <small class="pt-1">( {{ $product->view_count + 1 }} Viewed )</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $product->price }} MMK</h3>
                    <p class="mb-4">
                        {{ $product->description }}
                    </p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    -
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1" id="qty">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    +
                                </button>
                            </div>
                        </div>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                        <input type="hidden" value="{{ $product->id }}" id="productId">
                        <button type="button" id="addCartBtn" class="btn btn-primary px-3">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">

                    @foreach ($productList as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/'.$p->image) }}" width="580" style="height: 230px;" alt="image">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark" href="#">Shop</a>
                                    <a class="btn btn-outline-dark" href="{{ route('pizza#detail',$p->id) }}">Detail</a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $p->price }} MMK</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small>( {{ $p->view_count }} Viewed )</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@section('jqScriptCode')
    <script>
        $(document).ready(function(){
            // view count
            $.ajax({
                type : 'get',
                url : 'http://localhost:8000/user/ajax/product/view',
                data : {
                    'userId' : $('#userId').val(),
                    'productId' : $('#productId').val()
                }
            });

            // add to cart
            $('#addCartBtn').click(function(){
                var userId = $('#userId').val();
                var productId = $('#productId').val();
                var qty = $('#qty').val();

                source = {
                    'userId' : userId,
                    'productId' : productId,
                };
                source['qty'] = qty;

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/user/ajax/cart',
                    data : source,
                    dataType : 'json',
                    success : function(response){
                        if(response.status == 'success') {
                            window.location.href = "http://localhost:8000/user/home";
                        }
                    }
                });
            });
        });
    </script>
@endsection
