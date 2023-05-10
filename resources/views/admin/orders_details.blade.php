@extends('admin.layout')
@section('page_title','Search Results')
@section('dashboard_select', 'active')
@section('container')

<div class="row m-t-10">
    <div class="Order_details">
        
        {{-- New Template --}}
        <div class="admin_table">
            <h5 class="table_header">ORDER #{{$order_details[0]->id}}</h5>
            <div class="table_responsive no_wrap">
                <table class="table_box">
                <thead>
                    <tr>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Price <strong>X</strong> Quantity</th>
                    <th>Per Item Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$name[$item->product_id]->name}} <br>
                        SKU: {{$sku[$item->product_id]->sku}}
                        </td>
                        <td>{{$size[$item->product_id]->size}}</td>
                        <td>{{$item->price}} X {{$item->quantity}}</td>
                        <td>${{$item->price*$item->quantity}}</td>
                        {{-- <td>{{$order_details[0]->total}}</td> --}}
                    </tr>
                    @endforeach
    
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: end">Total</td>
                        <td>${{$order_details[0]->total}}</td>
                    </tr>
                </tbody>
                </table>
    
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
            <th>Customer Name:</th>
            <td>{{$order_details[0]->name}}</td>
          </tr>
          <tr>
            <th>E-Mail:</th>
            <td>{{$order_details[0]->email}}</td>
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
        {{-- New Template ENd --}}

        
    
    </div>
</div>

@endsection
