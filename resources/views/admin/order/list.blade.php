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
                                        <h2 class="title-1">Order List</h2>

                                    </div>
                                </div>
                            </div>

                            {{-- search bar --}}
                            <div class="row">
                                <div class="col-3">
                                    <h4>Search: <span class="text-danger">{{ request('key') }}</span></h4>
                                </div>

                                <div class="col-3 offset-6">
                                    <form action="{{ route('order#listPage') }}">
                                        <div class="d-flex">
                                            <input type="text" name="key" value="{{ request('key') }}" class="form-control" placeholder="Name or Order Code...">
                                            <button type="submit" class="btn btn-dark">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- order status --}}
                            <div>
                                <select id="orderStatus" name="status" class="form-control text-center col-2">
                                    <option value="">All</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Accept</option>
                                    <option value="2">Reject</option>
                                </select>
                            </div>

                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 text-center">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Order Code</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataList">
                                        @foreach ($order as $o)
                                            <tr class="tr-shadow">
                                                <td>{{ $o->user_id }}</td>
                                                <td>{{ $o->user_name }}</td>
                                                <td><a href="{{ route('order#detailPage',$o->order_code) }}">{{ $o->order_code }}</a></td>
                                                <td>{{ $o->total_price }}</td>
                                                <td>
                                                    <select name="status" class="form-control text-center statusChange">
                                                        <option value="0" @if($o->status == 0) selected @endif>Pending</option>
                                                        <option value="1" @if($o->status == 1) selected @endif>Accept</option>
                                                        <option value="2" @if($o->status == 2) selected @endif>Reject</option>
                                                    </select>
                                                </td>
                                                <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                                <input type="hidden" value="{{ $o->id }}" id="orderId">
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

@section('jqScriptCode')
    <script>
        $(document).ready(function(){
            // status change
            statusChange();

            // filter stauts
            $('#orderStatus').change(function(){
                var status = $(this).val();

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8000/order/ajax/status',
                    data : {'status' : status},
                    dataType : 'json',
                    success : function(response){
                        // console.log(response);
                        var order = response;
                            var list = '';
                            var months = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
                            $(order).each(function(i,v) {
                                var dbTime = new Date(v.created_at);
                                var date = months[dbTime.getMonth()] + '-' + dbTime.getDate() + '-' + dbTime.getFullYear();

                                var statusMsg = '';
                                if(v.status == 0) {
                                    statusMsg = `
                                        <option value="0" selected>Pending</option>
                                        <option value="1">Accept</option>
                                        <option value="2">Reject</option>
                                    `;
                                }else if(v.status == 1) {
                                    statusMsg = `
                                        <option value="0">Pending</option>
                                        <option value="1" selected>Accept</option>
                                        <option value="2">Reject</option>
                                    `;
                                }else if(v.status == 2) {
                                    statusMsg = `
                                        <option value="0">Pending</option>
                                        <option value="1">Accept</option>
                                        <option value="2" selected>Reject</option>
                                    `;
                                }
                                list += `
                                            <tr class="tr-shadow">
                                                <td>${ v.user_id }</td>
                                                <td>${ v.user_name }</td>
                                                <td><a href="http://localhost:8000/order/detail/${v.order_code}">${ v.order_code }</a></td>
                                                <td>${ v.total_price }</td>
                                                <td>
                                                    <select name="status" class="form-control text-center statusChange">
                                                        ${statusMsg}
                                                    </select>
                                                </td>
                                                <td>${ date }</td>
                                                <input type="hidden" value="${ v.id }" id="orderId">
                                            </tr>
                                        `;
                            });
                            $('#dataList').html(list);

                            // status change
                            statusChange();
                    }
                });
            });

            // status change fuction
            function statusChange() {
                // status change
                $('.statusChange').change(function(){
                    var status = $(this).val();
                    var parent = $(this).parents('tr');
                    var orderId = parent.find('#orderId').val();

                    $.ajax({
                        type : 'get',
                        url : 'http://localhost:8000/order/ajax/status/change',
                        data : {
                            'orderId' : orderId,
                            'status' : status
                        },
                        dataType : 'json'
                    });
                });
            }
        });
    </script>
@endsection
