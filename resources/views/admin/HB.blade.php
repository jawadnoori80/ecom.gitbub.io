@extends('admin.layout')
@section('page_title','Home Banner')
@section('HB_select', 'active')
@section('container')

@if(session('message'))
    <div class="alert alert-success" role="alert">
        {{session('message')}}
    </div>
@endif


<h1>Home Banner Management</h1>

<a href="{{url('admin/HB/manage_HB')}}">
    <button type="button" class="btn btn-outline-primary">
        Add Banner
    </button>
</a>

<div class="m-t-10">
    <div class="Home_banners">
        {{-- new design --}}
        <div class="admin_table">
            <h5 class="table_header">Banners</h5>
            <div class="table_responsive no_wrap">
               <table class="table_box">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Banner Tag</th>
                      <th>text</th>
                      <th>Link</th>
                      <th>image</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($data as $list)
                     <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->tag}}</td>
                        <td class="wrap max_width_300">{{$list->text}}</td>
                        <td class="wrap">{{$list->link}}</td>
                        <td>
                            <img src="{{asset('storage/media/banners')}}/{{$list->image}}" style="width: 200px" alt="">
                        </td>
                        <td class="process">
                            <a href="{{url('admin/HB/delete')}}/{{$list->id}}"><button type="button" class="btn btn-outline-danger">Delete</button></a>
                           
                            @if($list->status==1)
                                <a href="{{url('admin/HB/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-outline-primary">Active</button></a>
                             @elseif($list->status==0)
                                <a href="{{url('admin/HB/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-outline-warning">Deactive</button></a>
                            @endif
                           
                            <a href="{{url('admin/HB/edit')}}/{{$list->id}}"><button type="button" class="btn btn-outline-primary">Edit</button></a>
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
