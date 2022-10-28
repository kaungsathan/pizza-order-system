@extends('user.layout.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class=" d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('user#home') }}"><label class="" for="price-all">All Categories</label></a>
                            <span>{{ count($category) }}</span>
                        </div>
                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mb-3">
                                <a href="{{ route('user#filter',$c) }}"><label class="form-check-label" for="price-1">{{ $c->name }}</label></a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->

                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button type="button" class="btn btn-primary position-relative">
                                    Cart
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
                                        {{ count($cart) }}
                                    </span>
                                </button>
                            </div>
                            <div class="ml-2">
                                <div>
                                    <select name="sorting" id="sortingOpt" class="btn btn-dark p-2">
                                        <option value="">Sorting</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (count($pizza) != 0)
                        <div class="row" id="dataList">
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" src="{{ asset('storage/'.$p->image) }}" width="580" style="height: 400px;">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark" href="{{ route('pizza#detail',$p->id) }}">Shop</a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $p->price }} kyats</h5>
                                                {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h2 class="text-center">There is no pizza</h2>
                    @endif

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('jqScriptCode')
    <script>
        $(document).ready(function(){
            // $.ajax({
            //     type : "get",
            //     url : "http://localhost:8000/user/ajax/pizzaList",
            //     dataType : "json",
            //     success : function(response){
            //         console.log(response);
            //     }
            // });

            $('#sortingOpt').change(function(){
                var status = $(this).val();

                if(status == 'asc') {
                    $.ajax({
                        type : "get",
                        url : "http://localhost:8000/user/ajax/pizzaList",
                        data : { "status" : "asc"},
                        dataType : "json",
                        success : function(response){
                            // console.log(response);
                            var product = response;
                            var list = '';
                            $(product).each(function(i,p) {
                                // console.log(`Name - ${p.name}`);
                                list += `
                                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                                <div class="product-item bg-light mb-4">
                                                    <div class="product-img position-relative overflow-hidden">
                                                        <img class="img-fluid w-100" src="{{ asset('storage/${p.image}') }}" width="580" style="height: 400px;">
                                                        <div class="product-action">
                                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-4">
                                                        <a class="h6 text-decoration-none text-truncate" href="">${p.name}</a>
                                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                                            <h5>${p.price} kyats</h5>
                                                            {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                            });
                            $('#dataList').html(list);
                        }
                    });
                }else if(status == 'desc') {
                    $.ajax({
                        type : "get",
                        url : "http://localhost:8000/user/ajax/pizzaList",
                        data : { "status" : "desc"},
                        dataType : "json",
                        success : function(response){
                            var product = response;
                            var list = '';
                            $(product).each(function(i,p) {
                                // console.log(`Name - ${p.name}`);
                                list += `
                                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                                <div class="product-item bg-light mb-4">
                                                    <div class="product-img position-relative overflow-hidden">
                                                        <img class="img-fluid w-100" src="{{ asset('storage/${p.image}') }}" width="580" style="height: 400px;">
                                                        <div class="product-action">
                                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-4">
                                                        <a class="h6 text-decoration-none text-truncate" href="">${p.name}</a>
                                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                                            <h5>${p.price} kyats</h5>
                                                            {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                            });
                            $('#dataList').html(list);
                        }
                    });
                }
            });
        });
    </script>
@endsection
