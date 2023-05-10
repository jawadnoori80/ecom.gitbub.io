@extends('admin.layout')
@section('page_title','Category')
@section('category_select', 'active')
@section('container')

@if(session('message'))
    <div class="alert alert-success" role="alert">
        {{session('message')}}
    </div>
@endif

<a href="{{url('admin/category/manage_category')}}">
    <button type="button" class="btn btn-outline-primary">
        Add Category <i class="fas fa-plus"></i>
    </button>
</a>

<div class="m-t-10">
    <div class="Categories">

        {{-- new design --}}
        <div class="admin_table">
            <h5 class="table_header">Categories</h5>
            <div class="table_responsive no_wrap">
               <table class="table_box">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category Name</th>
                      <th>Category Slug</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($data as $list)
                     <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->category_name}}</td>
                        <td>{{$list->category_slug}}</td>
                        <td class="process">
                            <a href="{{url('admin/category/delete')}}/{{$list->id}}"><button type="button" class="btn btn-outline-danger btn-sm mb-1">Delete</button></a>
                            <a href="{{url('admin/category/edit')}}/{{$list->id}}"><button type="button" class="btn btn-outline-primary btn-sm mb-1">Edit</button></a>
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
</div>

@endsection
