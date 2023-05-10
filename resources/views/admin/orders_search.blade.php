@extends('admin.layout')
@section('page_title','Search Results')
@section('dashboard_select', 'active')
@section('container')

<form id="searchBox" action="{{url('admin/orders/search')}}/">
    <div class="orders_search">
       <input id="OrderSearchQuery" name="q" type="text" class="form-control" placeholder="Search Products" value="{{$q}}">
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
            <h5 class="table_header">Showing Orders for "{{$q}}"</h5>
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
                        <td>{{$order->order_status}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td class="actBtn{{$order->id}}">
                            <a href="{{url('admin/orders/edit/')}}/{{$order->id}}"><button type="button" class="btn btn-outline-success btn-sm m-1">Edit</button></a>
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
