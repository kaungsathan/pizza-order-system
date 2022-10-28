@extends('user.layout.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" style="height: 576px;">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                            <tr>
                                <td class="align-middle" id="productName">{{ $o->order_code }}</td>
                                <td class="align-middle">{{ $o->total_price }} MMK</td>
                                <td class="align-middle">
                                    @if ($o->status == 0)
                                        <span class="text-warning">Pending...</span>
                                    @elseif ($o->status == 1)
                                        <span class="text-success">Success...</span>
                                    @elseif ($o->status == 2)
                                        <span class="text-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $o->created_at->format('F-j-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-4">{{ $order->links() }}</div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
