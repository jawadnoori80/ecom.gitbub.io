@extends('admin.layout')
@section('page_title','Dashboard')
@section('dashboard_select', 'active')
@section('container')

<form id="searchBox" action="{{url('admin/orders/search')}}/">
    <div class="orders_search">
       <input id="OrderSearchQuery" name="q" type="text" class="form-control" placeholder="Search Products">
       <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
             <i class="fa fa-search"></i>
          </button>
       </div>
    </div>
 </form>

<div class="row m-t-10">
    <div class="Orders">
        
        {{-- New Template --}}
        <div class="admin_table">
            <h5 class="table_header">ORDERS</h5>
            <div class="table_responsive no_wrap">
                <table class="table_box">
                <thead>
                    <tr>
                    <th>Order ID</th>
                    <th>invoice ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Order Stutus</th>
                    <th>Payment Stutus</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->invoice_id}}</td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->email}}</td>
                        {{-- Order Status --}}
                        
                        @if ($order->order_status === "Placed")
                        <td><span class="badge badge-pill badge-primary">{{$order->order_status}}</span></td>
                        
                        @endif
                        @if ($order->order_status === "Pending")
                        <td><span class="badge badge-pill badge-warning">{{$order->order_status}}</span></td>
                        
                        @endif
                        @if ($order->order_status === "Shipped")
                        <td><span class="badge badge-pill badge-successful">{{$order->order_status}}</span></td>
                        
                        @endif

                        {{-- Order Status --}}
                        
                        {{-- Payment Status --}}
                        @if ($order->payment_status === "Pending")
                        
                        <td><span class="badge badge-pill badge-warning">{{$order->payment_status}}</span></td>
                       
                        @endif

                        @if ($order->payment_status === "Successful")
                        
                        <td><span class="badge badge-pill badge-success">{{$order->payment_status}}</span></td>
                       
                        @endif

                        @if ($order->payment_status === "Failed")
                        
                        <td><span class="badge badge-pill badge-danger">{{$order->payment_status}}</span></td>
                       
                        @endif
                        
                        {{-- Payment Status --}}
                        
                        
                        <td class="actBtn{{$order->id}}">
                            <a href="{{url('admin/orders/details/')}}/{{$order->id}}"><button type="button" class="btn btn-outline-success btn-sm m-1">Edit</button></a>
                            <a href="{{url('admin/orders/details')}}/{{$order->id}}"><button type="button" class="btn btn-outline-primary btn-sm m-1">Details</button></a>
                        </td>
                    </tr>
                    @endforeach
    
                    
                </tbody>
                </table>
    
            </div>
    
            <div class="mt-6 d-flex justify-content-center">
                {{$orders->withQueryString()->links()}}
            </div>
    
        </div>
        {{-- New Template ENd --}}
    
    </div>
</div>

@endsection
