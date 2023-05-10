@extends('admin/layout')
@section('page_title','Customers')
@section('customer_select','active')
@section('container')
    @if(session()->has('message'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        {{session('message')}}  
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> 
    @endif
    <div class="m-t-10">
        <div class="Customers_list">

            {{-- new design --}}
        <div class="admin_table">
            <h5 class="table_header">Customers List</h5>
            <div class="table_responsive no_wrap">
               <table class="table_box">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($data as $list)
                     <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->firstName}} {{$list->lastName}}</td>
                        <td>{{$list->email}}</td>
                        <td>
                            <a href="{{url('admin/customer/show/')}}/{{$list->id}}"><button type="button" class="btn btn-outline-primary">View</button></a>
                        </td>
                      </tr>
                      @endforeach
   
                      
                  </tbody>
                </table>
   
            </div>
        </div>
        {{-- new design --}}

        </div>
    </div>
                        
@endsection