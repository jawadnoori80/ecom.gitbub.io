@extends('admin/layout')
@section('page_title','Size')
@section('size_select','active')
@section('container')
    @if(session()->has('message'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        {{session('message')}}  
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> 
    @endif                           
    <a href="{{url('admin/size/manage_size')}}">
        <button type="button" class="btn btn-outline-primary">
            Add Size <i class="fas fa-plus"></i>
        </button>
    </a>
    <div class="m-t-10">
        <div class="Sizes">
            {{-- new design --}}
            <div class="admin_table">
                <h5 class="table_header">Sizes</h5>
                <div class="table_responsive no_wrap">
                   <table class="table_box">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Size</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($data as $list)
                         <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->size}}</td>
                            <td>
                                <a href="{{url('admin/size/manage_size/')}}/{{$list->id}}"><button type="button" class="btn btn-outline-info btn-sm m-1">Edit</button></a>

                                @if($list->status==1)
                                    <a href="{{url('admin/size/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-outline-primary btn-sm m-1">Active</button></a>
                                 @elseif($list->status==0)
                                    <a href="{{url('admin/size/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-outline-warning btn-sm m-1">Deactive</button></a>
                                @endif

                                <a href="{{url('admin/size/delete/')}}/{{$list->id}}"><button type="button" class="btn btn-outline-danger btn-sm m-1">Delete</button></a>
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