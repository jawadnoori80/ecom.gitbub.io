@extends('front.layout')
@section('page_title','My Orders')
@section('container')


<div class="container text-center my_orders">
        <h2>My Orders</h2>
        <ul class="responsive-table">
          <li class="table-header">
            <div class="head head-1">Order Id</div>
            <div class="head head-2">Order Status</div>
            <div class="head head-3">Total Amount</div>
            <div class="head head-4">Placed at</div>
          </li>
          @foreach ($orders as $order)
          
            <li class="table-row">
              {{-- <a href="{{url('order_details')}}/{{$order->id}}"> --}}
                <div class="head head-1" data-label="Order Id :">{{$order->id}}</div>
                <div class="head head-2" data-label="Order Status :">{{$order->order_status}}</div>
                <div class="head head-3" data-label="Total Amount :">${{$order->total}}</div>
                <div class="head head-4" data-label="Placed at :">{{date('d-m-Y', strtotime($order->added_on))}}</div>
              {{-- </a> --}}
                <div class="more_details"><a href="{{url('order_details')}}/{{$order->id}}">More Details</a></div>
            </li>
          
          @endforeach
          @if (count($orders)<1)
            <h4 class="gray">Empty!</h4>
          @endif
        </ul>
</div>

@endsection