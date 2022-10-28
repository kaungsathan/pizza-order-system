@extends('user.layout.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="dataTable">
                        @foreach ($cartList as $c)
                            <tr>
                                <td class="align-middle" id="productName">{{ $c->product_name }}</td>
                                <td class="align-middle">{{ $c->product_price }} MMK</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button data-price="{{ $c->product_price }}" class="btn btn-sm btn-primary btn-minus" >-</button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" id="qty" value="{{ $c->qty }}">
                                        <div class="input-group-btn">
                                            <button data-price="{{ $c->product_price }}" class="btn btn-sm btn-primary btn-plus">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td id="totalPrice" class="align-middle">{{ $c->product_price * $c->qty }} MMK</td>
                                <input type="hidden" value="{{ $c->id }}" id="cartId">
                                <input type="hidden" value="{{ $c->user_id }}" id="userId">
                                <input type="hidden" value="{{ $c->product_id }}" id="productId">
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove">Delete</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotal">{{ $totalPrice }} MMK</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 MMK</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 3000 }} MMK</h5>
                        </div>
                        <button id="orderBtn" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                        <button id="clearBtn" class="btn btn-block btn-danger font-weight-bold my-3 py-3">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('jqScriptCode')
    <script>
        $(document).ready(function(){
            // add and reduce qty button
            $('.btn-minus').click(function(){
                var parent = $(this).parents('tr');

                var price = $(this).data('price');
                var qty = parent.find('#qty').val();

                qtyBtnProcess(parent,price,qty);
                subTotal();
            });

            $('.btn-plus').click(function(){
                var parent = $(this).parents('tr');

                var price = $(this).data('price');
                var qty = parent.find('#qty').val();

                qtyBtnProcess(parent,price,qty);
                subTotal();
            });

            $('.btnRemove').click(function(){

                var cartId = $(this).parents('tr').find('#cartId').val();

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/user/ajax/cart/product/clear',
                    data : {'cartId' : cartId},
                    dataType : 'json'
                });
                $(this).parents('tr').remove();
                subTotal();
            });

            // checkout button
            $('#orderBtn').click(function(){

                var orderList = [];
                var random = Math.floor(Math.random() * 1000001);
                $('#dataTable tr').each(function(i,v){
                    orderList.push({
                        'userId' : $(v).find('#userId').val(),
                        'productId' : $(v).find('#productId').val(),
                        'qty' : $(v).find('#qty').val(),
                        'total' : $(v).find('#totalPrice').html().replace('MMK','')*1,
                        'orderCode' : '60' + random
                    });
                });

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/user/ajax/order',
                    data : Object.assign({},orderList),
                    dataType : 'json',
                    success : function(response) {
                        if(response.status == 'true') {
                            window.location.href = "http://localhost:8000/user/home";
                        }
                    }
                });
            });

            // clear button
            $('#clearBtn').click(function(){
                $('#dataTable tr').remove();

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/user/ajax/cart/clear',
                    dataType : 'json',
                });
            });

            // function
            // add and reduce qty
            function qtyBtnProcess(parent,price,qty) {
                var totalPrice = price * qty;

                parent.find('#totalPrice').html(totalPrice + ' MMK');
            }

            // get all price and insert subtotal
            function subTotal() {
                var allPrice = 0;
                $('#dataTable tr').each(function(i,v){
                    allPrice += Number($(v).find('#totalPrice').html().replace('MMK',''));
                });
                $('#subTotal').html(`${allPrice} MMK`);
                $('#finalPrice').html(`${allPrice + 3000} MMK`);
            }
        })
    </script>
@endsection
