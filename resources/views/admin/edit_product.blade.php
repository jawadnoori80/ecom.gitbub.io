@extends('admin.layout')
@section('page_title','Edit Category')
@section('container')
<a href="{{url('admin/product')}}">
<button type="button" class="btn btn-success m-t-25">
Back
</button>
</a>
<h2 class="m-t-30">Edit Category</h2>
<div class="row m-t-25">
   <div class="col-md-8">
      <form action="{{url('admin/product/update')}}/{{$data->id}}" method="post" enctype="multipart/form-data">
         
         {{-- PRODUCT INFORMATION --}}
         <div class="card">
            <div class="card-body">
               @csrf
               <input type="hidden" name="PID" value="{{$data->id}}">
               <div class="form-group">
                  <label for="name" class="control-label mb-1"> Name</label>
                  <input id="name" value="{{$data->name}}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                  @error('name')
                  <div class="alert alert-danger" role="alert">
                     {{$message}}		
                  </div>
                  @enderror
               </div>
               <div class="form-group">
                  <label for="slug" class="control-label mb-1"> Slug</label>
                  <input id="slug" value="{{$data->slug}}" name="slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                  @error('slug')
                  <div class="alert alert-danger" role="alert">
                     {{$message}}		
                  </div>
                  @enderror
               </div>
               <div class="row">
                  <div class="form-group col-sm-6">
                     <label for="image" class="control-label mb-1"> Image</label>
                     <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                     @if($data->image!='')
                                 <a href="{{asset('storage/media/product_img/'.$data->image)}}" target="_blank"><img width="100px" src="{{asset('storage/media/product_img/'.$data->image)}}"/></a>
                              @endif
                     @error('image')
                     <div class="alert alert-danger" role="alert">
                        {{$message}}		
                     </div>
                     @enderror
                  </div>
                  <div class="form-group col-sm-6">
                     <label for="category_id" class="control-label mb-1"> Category</label>
                     <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Select Categories</option>
                        @foreach($category as $list)
                        @if($data->category_id==$list->id)
                        <option selected value="{{$list->id}}">
                           @else
                        <option value="{{$list->id}}">
                           @endif
                           {{$list->category_name}}
                        </option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label for="brand" class="control-label mb-1"> Brand</label>
                  <input id="brand" value="{{$data->brand}}" name="brand" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
               </div>
               
               <div class="form-group">
                  <label for="desc" class="control-label mb-1"> Description</label>
                  <textarea id="desc" name="desc" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$data->desc}}</textarea>
               </div>
               <div class="form-check mt-3">
                  @if($data->best_selling=='1')
                  <input class="form-check-input" type="checkbox" value="1" id="best_selling" name="best_selling" checked>
                  <label class="form-check-label" for="best_selling">Best Selling</label>
                  @else
                  <input class="form-check-input" type="checkbox" value="1" id="best_selling" name="best_selling">
                  <label class="form-check-label" for="best_selling">Best Selling</label>
                  @endif
              </div>
              <div class="form-check">
               @if($data->discounted=='1')
               <input class="form-check-input" type="checkbox" value="1" id="discounted" name="discounted" checked>
               <label class="form-check-label" for="discounted">discounted</label>
               @else
               <input class="form-check-input" type="checkbox" value="1" id="discounted" name="discounted">
               <label class="form-check-label" for="discounted">discounted</label>
               @endif
           </div>
           <div class="form-check">
            @if($data->popular=='1')
            <input class="form-check-input" type="checkbox" value="1" id="popular" name="popular" checked>
            <label class="form-check-label" for="popular">Popular Now</label>
            @else
            <input class="form-check-input" type="checkbox" value="1" id="popular" name="popular">
            <label class="form-check-label" for="popular">Popular Now</label>
            @endif
        </div>
            </div>
         </div>
         {{-- END PRODUCT INFORMATION --}}

         {{-- Product Images Upload Section  --}}

         <h2 class="mb10">Product Images</h2>
         <div class="card border border-2">
             <div class="card-body form-group">
                 <div class="row">
                     <div id="product_image_box">
                        @php 
                        $loop_count_image=0;
                        @endphp
                        @foreach($productImagesrArr as $key=>$val)
                        @php 
                        $pIArr=(array)$val;
                        $loop_count_image++;
                        @endphp
                         <div id="product_image_{{$loop_count_image}}">
                             <div class="form-group">
                                 <input type="hidden" name="piid[]" value="{{$pIArr['id']}}">
                                 <label for="images" class="control-label mb-1"> Image</label>
                                 <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false">
                             </div>
                             @error('images.*')
                             <div class="alert alert-danger" role="alert">
                                 {{$message}}		
                             </div>
                             @enderror
                             @if($pIArr['images']!='')
                                 <a href="{{asset('storage/media/product_img/'.$pIArr['images'])}}" target="_blank"><img width="100px" src="{{asset('storage/media/product_img/'.$pIArr['images'])}}"/></a>
                              @endif
                             <div class="col-3 col-sm-2 form-group">
                                 

                              @if($loop_count_image==1)
                                 <button type="button" class="add_image_field form-control btn btn-outline-primary btn-sm mt-2">
                                 <i class="fa fa-plus"></i>&nbsp; Add</button>
                              @else
                                 <button type="button" class="btn btn-outline-danger btn-sm" onclick="remove_image({{$pIArr['id']}},{{$loop_count_image}})">
                                 <i class="fa fa-minus"></i>&nbsp; Remove</button>
                              @endif
                             </div>

                             


                         </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
        {{--  END Product Images Upload Section  --}}


         {{-- PRODUCT ATTRIBUTES INFORMATION --}}
         <div class="card">
            <div class="card-body">
               <h2 class="mb10">Product Attributes</h2>
               <div id="product_attr_box">
               @php 
               $loop_count_num=0;
               @endphp
               @foreach($productAttrArr as $key=>$val)
               @php
                  $pAArr=(array)$val;
                  $loop_count_num++;
               @endphp

                  <div class="card" id="product_attr_{{$loop_count_num}}">
                        <input id="paid" type="hidden" name="paid[]" value="{{$pAArr['id']}}">
                        <div class="card-body">
                           <div class="form-group">
                              <div class="row">
                                    <div class="col-md-2">
                                         <label for="sku" class="control-label mb-1"> SKU</label>
                                         <input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['sku']}}" required>
                                         @error('sku.*')
                                         <div class="alert alert-danger" role="alert">
                                             {{$message}}		
                                         </div>
                                         @enderror
                                    </div>
                                    <div class="col-md-3">
                                       <label for="size_id" class="control-label mb-1"> Size</label>
                                       <select id="size_id" name="size_id[]" class="form-control">
                                          <option value="">Select</option>
                                          @foreach($sizes as $list)
                                             @if($pAArr['size_id']==$list->id)
                                             <option selected value="{{$list->id}}">{{$list->size}}</option>
                                             @else
                                             <option value="{{$list->id}}">{{$list->size}}</option>
                                             @endif
                                          @endforeach
                                       </select>
                                       @error('size_id')
                                         <div class="alert alert-danger" role="alert">
                                             {{$message}}		
                                         </div>
                                         @enderror
                                    </div>
                                    <div class="col-md-2">
                                       <label for="msrp" class="control-label mb-1"> MSRP</label>
                                       <input id="msrp" name="msrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['msrp']}}">
                                       @error('msrp.*')
                                         <div class="alert alert-danger" role="alert">
                                             {{$message}}		
                                         </div>
                                         @enderror
                                    </div>
                                    <div class="col-md-2">
                                       <label for="price" class="control-label mb-1"> Price</label>
                                       <input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['price']}}" required>
                                       @error('price')
                                         <div class="alert alert-danger" role="alert">
                                             {{$message}}		
                                         </div>
                                         @enderror
                                    </div>
                                    <div class="form-group col-5 col-sm-3 col-xxl-2">
                                       @if($loop_count_num==1)
                                          <label for="button">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                          <button type="button" class="add_form_field form-control btn btn-outline-primary btn-sm mt-2">&nbsp;&nbsp;
                                          <i class="fa fa-plus"></i>&nbsp; Add&nbsp;&nbsp;&nbsp;</button>
                                       @else
                                          <button type="button" class="form-control btn btn-outline-danger btn-sm mt-2" onclick="remove_attr({{$pAArr['id']}},{{$loop_count_num}})">
                                          <i class="fa fa-minus"></i>&nbsp; Remove</button>
                                       @endif
                                       {{-- {{$pAArr['id']}},  --}}
                                       {{-- <a href="{{url('admin/product/product_attr_delete')}}/{{$pAArr['id']}}/{{$data->id}}"> --}}
                                    </div>
                              </div>
                           </div>
                        </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>


         {{-- PRODUCT ATTRIBUTES INFORMATION --}}


         <div>
            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
               Submit
            </button>
         </div>
      </form>
   </div>
</div>

<script>
   $(document).ready(function() {
       var max_fields = 6;
       var wrapper = $("#product_attr_box");
       var add_button = $(".add_form_field");
       var x = {{$loop_count_num}};
      
   
       $(add_button).click(function(e) {
           e.preventDefault();
           if (x < max_fields) {
               x++;
               $(wrapper).append('<div class="card" id="product_attr_'+x+'"><input id="paid" type="hidden" name="paid[]" value=""><div class="card-body"><div class="form-group"><div class="row"><div class="col-md-2"><label for="sku" class="control-label mb-1"> SKU</label><input name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div><div class="col-md-3"><label for="size_id" class="control-label mb-1"> Size</label><select name="size_id[]" class="form-control"><option value="">Select</option>@foreach($sizes as $list)<option value="{{$list->id}}">{{$list->size}}</option>@endforeach</select></div><div class="col-md-2"><label for="msrp" class="control-label mb-1"> MSRP</label><input id="msrp" name="msrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false"></div><div class="col-md-2"><label for="price" class="control-label mb-1"> Price</label><input name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div><div class="form-group col-5 col-sm-3 col-xxl-2"><label for="button">&nbsp;&nbsp;&nbsp;&nbsp;</label><button type="button" class="form-control btn btn-outline-danger btn-sm mt-2" onclick=remove("'+x+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div></div></div></div></div>'); //add input box
           } else {
               alert('You Reached the limits');
           }
       });

       //Product Images Buttons
         var max_fields_image = 6;
         var wrapper_image = $("#product_image_box");
         var add_button_image = $(".add_image_field");
         var y = {{$loop_count_image}};
         

         $(add_button_image).click(function(e) {
            e.preventDefault();
            if (y < max_fields_image) {
                  y++;
                  $(wrapper_image).append('<div id="product_image_'+y+'"><div class="form-group"><input type="hidden" name="piid[]"><label for="image" class="control-label mb-1"> Image</label><input name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required>@error("images")<div class="alert alert-danger" role="alert">{{$message}}</div>@enderror</div><div class="form-group col-4 col-sm-2"><button type="button" class="btn btn-outline-danger form-control mt-2 btn-sm mt-2" onclick=remove_image_input("'+y+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div></div></div>'); //add input box
            } else {
                  alert('You Reached the limits');
            }
         });
   
    
   
   });
   function remove(loop_count){
              jQuery('#product_attr_'+loop_count).remove();
         }
   //remove new image inputs
   function remove_image_input(loop_count){
      jQuery('#product_image_'+loop_count).remove();
   }


         //paId, 
   function remove_attr(paId,loop_counts){
      $.ajax({
         url:"{{url('admin/product/product_attr_delete')}}/"+paId,
         data: { somefield: "Some field value", _token: '{{csrf_token()}}' },
         type:'post',
         success:function(result){
            jQuery('#product_attr_'+loop_counts).remove();
         }
      });
      
   }
   
   function remove_image(pIId,loop_counts){
      $.ajax({
         url:"{{url('admin/product/product_image_delete')}}/"+pIId,
         data: { somefield: "Some field value", _token: '{{csrf_token()}}' },
         type:'post',
         success:function(result){
            jQuery('#product_image_'+loop_counts).remove();
         }
      });
      
   }
</script>
@endsection