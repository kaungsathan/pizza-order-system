@extends('admin.layouts.master')

@section('title','AdminCategoryList')

@section('content')
    <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->

                            <div class="card col-4">
                                <div class="card-header bg-white"><h3>Order Info</h3></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">Customer Name:</div>
                                        <div class="col">{{ $orderList[0]->user_name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col">Order Code:</div>
                                        <div class="col">{{ $orderList[0]->order_code }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col">Order Date:</div>
                                        <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col">Total:</div>
                                        <div class="col">{{ $total->total_price }} MMK</div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Order ID</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Date</th>
                                            <th>qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataList">
                                        @foreach ($orderList as $o)
                                            <tr class="tr-shadow">
                                                <td></td>
                                                <td>{{ $o->id }}</td>
                                                <td><img src="{{ asset('storage/'.$o->product_image) }}" width="100" alt="image"></td>
                                                <td>{{ $o->product_name }}</td>
                                                <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                                <td>{{ $o->qty }}</td>
                                                <td>{{ $o->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div class="my-4">
                                    {{ $order->links() }}
                                </div> --}}
                            </div>
                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
@endsection
