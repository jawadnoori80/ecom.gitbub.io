@extends('admin/layout')
@section('page_title','Products')
@section('product_select','active')
@section('container')
@if(session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
   {{session('message')}}  
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">×</span>
   </button>
</div>
@endif
<div class="product_SearchBox">
   <a href="{{url('admin/product/manage_product')}}">
      <button type="button" class="btn btn-outline-primary">
         Add Product <i class="fas fa-plus"></i>
      </button>
   </a>
   
   <form id="searchBox" action="{{url('admin/product/search')}}/">
      <div class="input-group">
         <input id="SearchQuery" name="q" type="text" class="form-control" placeholder="Search Products">
         <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
               <i class="fa fa-search"></i>
            </button>
         </div>
      </div>
   </form>

</div>
<div class="row m-t-10">
   <div class="Products">
      
      {{-- New Template --}}

      <div class="admin_table">
         <h5 class="table_header">Products</h5>
         <div class="table_responsive no_wrap">
            <table class="table_box">
               <thead>
                 <tr>
                   <th>ID</th>
                   <th>Name</th>
                   <th>Slug</th>
                   <th>Actions</th>
                 </tr>
               </thead>
               <tbody>
                  @foreach($data as $list)
                  <tr>
                     <td>{{$list->id}}</td>
                     <td>{{$list->name}}</td>
                     <td>{{$list->slug}}</td>
                     <td class="actBtn{{$list->id}}">
                        <a href="{{url('admin/product/edit/')}}/{{$list->id}}"><button type="button" class="btn btn-outline-success btn-sm m-1">Edit</button></a>
                        @if($list->status==1)
                        <button type="button"  class="btn btn-outline-primary btn-sm m-1" onclick="deactivate_product({{$list->id}})">Active</button></a>
                        @elseif($list->status==0)
                        <button type="button"  class="btn btn-outline-warning btn-sm m-1" onclick="activate_product({{$list->id}})">Deactive</button>
                        @endif
                        <a href="{{url('admin/product/delete')}}/{{$list->id}}"><button type="button" class="btn btn-outline-danger btn-sm m-1">Delete</button></a>
                     </td>
                   </tr>
                   @endforeach

                   
               </tbody>
             </table>

         </div>

         <div class="mt-6 d-flex justify-content-center">
            {{$data->withQueryString()->links()}}
         </div>

     </div>
     {{-- New Template ENd --}}
   
   </div>
</div>


<script>

   function activate_product(id){
      event.preventDefault();
      $.ajax({
         url:"{{url('admin/product/status/1')}}/"+id,
         data: { _token: '{{csrf_token()}}' },
         type:'post',
         success:function(){
            var element = '.actBtn'+id;
            $(element).load(location.href+" " +element+">*","");
         }
      });
      
   }
   function deactivate_product(id){
      event.preventDefault();
      $.ajax({
         url:"{{url('admin/product/status/0')}}/"+id,
         data: { _token: '{{csrf_token()}}' },
         type:'post',
         success:function(){
            var element = '.actBtn'+id;
            $(element).load(location.href+" " +element+">*","");
         }

      });
      
   }
</script>
@endsection