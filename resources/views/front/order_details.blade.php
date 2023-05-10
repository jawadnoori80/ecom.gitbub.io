@extends('front.layout')
@section('page_title','Order Details')
@section('container')


<div class="container">
    <div class="order_details">
        <h2>ORDER DETAILS</h2>
        <ul class="responsive-table">
          <li class="table-header">
            <div class="head head-1">Item Name</div>
            <div class="head head-2">Size</div>
            <div class="head head-3">Quantity</div>
            <div class="head head-4">Price</div>
          </li>
          @foreach ($items as $item)
          
            <li class="table-row">
              {{-- <a href="{{url('order_details')}}/{{$order->id}}"> --}}
                <div class="head head-1" data-label="Item Name :">{{$name[$item->product_id]->name}}</div>
                <div class="head head-2" data-label="Size :">{{$size[$item->product_id]->size}}</div>
                <div class="head head-3" data-label="Quantity :">{{$item->quantity}}</div>
                <div class="head head-4" data-label="Price :">{{$item->price}}</div>
              {{-- </a> --}}
                {{-- <div class="more_details"><a href="{{url('order_details')}}/{{$order->id}}">More Details</a></div> --}}
            </li>
          
          @endforeach
          {{-- @if (count($orders)<1)
            <h4 class="gray">Empty!</h4>
          @endif --}}
        </ul>



        {{-- <table class="Items_Summary">
            <tr>
                <th class="order_desc">Items Summary</th>
                <th>Size</th>
                <th>QTY</th>
                <th>Price</th>
            </tr>
            <tr class="details_row">
                <td>
                    <div class="order_desc">
                        <div><img src="{{asset('storage/media/product_img')}}/328019701.jpg"></div>
                        <p>Adzuki Beans Lorem ipsum dolor sit amet.</p>
                    </div> 
                </td>
                <td>10kg</td>
                <td>5</td>
                <td>$110</td>
            </tr>
        </table> --}}
    </div>

    {{-- Customer Details --}}
    <div class="customer_details">
      <table>
        <tr>
          <th>Order ID:</th>
          <td>{{$order_details[0]->id}}</td>
        </tr>
        <tr>
          <th>Invoice #:</th>
          <td>{{$order_details[0]->invoice_id}}</td>
        </tr>
        <tr>
          <th>Address:</th>
          <td>{{$order_details[0]->address}} <br> 
            {{$order_details[0]->optional_add}} <br>
            {{$order_details[0]->city}}&nbsp;{{$order_details[0]->state}}&nbsp;{{$order_details[0]->post_code}}&nbsp;
          </td>
        </tr>
        <tr>
          <th>Order Status:</th>
          <td>{{$order_details[0]->order_status}}</td>
        </tr>
        <tr>
          <th>Order Date:</th>
          <td>{{date('d-m-Y', strtotime($order_details[0]->added_on))}}</td>
        </tr>
        <tr>
          <th>&nbsp;</th>
          <td></td>
        </tr>
        <tr>
          <th>Total:</th>
          <td>{{$order_details[0]->total}}</td>
        </tr>
      </table>
      
    </div>
    {{-- Customer Details End--}}
    
</div>

@endsection