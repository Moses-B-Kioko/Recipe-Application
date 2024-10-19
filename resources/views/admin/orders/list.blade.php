@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<section class="section-11">
    <!-- Main content -->
    <section class="content" style="height: calc(100vh - 60px);"> <!-- Adjust the height as needed -->
        <!-- Default box -->
        <div class="container-fluid h-100"> <!-- Added h-100 to fill height -->
            <div class="row h-100"> <!-- Added h-100 to fill height -->
                <!-- Sidebar on the Left 
                <div class="col-md-3">
                    @include('front.account.common.sidebar')
                </div>-->

                <!-- Main Content on the Right -->
                <div class="col-md-12 col-lg-13 h-100"> <!-- Changed to col-lg-11 for a wider content area -->
                    <div class="card h-100"> <!-- Added h-100 to fill height -->
                        <form action="" method="get">
                            <div class="card-header"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-title">
                                            <button type="button" onClick="window.location.href='{{ route('orders.index') }}'" class="btn btn-default btn-sm">Reset</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="card-tools">
                                            <div class="input-group" style="width: 300px;"> <!-- Increased width of search input -->
                                                <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body table-responsive p-0 h-100"> <!-- Added h-100 to fill height -->
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th width="60">Order#</th>
                                        <th style="width: 200px;">Customer</th>
                                        <th style="width: 60px;">Email</th>
                                        <th style="width: 60px;">Phone</th>
                                        <th width="80" class="text-center">Status</th>
                                        <th width="100">Amount</th>
                                        <th width="100">Date Purchased</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->isNotEmpty())
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><a href="{{ route('orders.detail', [$order->id, 1]) }}">{{ $order->id }}</a></td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->mobile }}</td>
                                                <td class="text-center">
                                                    @if($order->status == "pending")
                                                        <span class="badge bg-danger">Pending</span>
                                                    @elseif ($order->status == 'shipped')
                                                        <span class="badge bg-info">Shipping</span>
                                                    @elseif ($order->status == 'delivered')
                                                        <span class="badge bg-success">Delivered</span>
                                                    @else 
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @endif 
                                                </td>
                                                <td>{{ number_format($order->grand_total, 2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d,M,Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">Records Not Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
@endsection
