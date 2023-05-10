@extends('admin/layout')
@section('page_title','Manage Product')
@section('product_select','active')
@section('container')
<h1 class="mb10">Manage Product</h1>
<a href="{{url('admin/product')}}">
<button type="button" class="btn btn-light btn-sm mt-2">
Back
</button>
</a>
<div class="row mt-5">
   <div class="col-xl-8 col-sm-12">
       <form action="{{route('product.manage_product_process')}}" method="post" enctype="multipart/form-data">
           {{-- PRODUCT INFORMATION --}}
           <div class="card">
               <div class="card-body">
                   @csrf
                   <div class="form-group">
                       <label for="name" class="control-label mb-1"> Name</label>
                       <input id="name" value="{{old('name')}}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                       @error('name')
                       <div class="alert alert-danger" role="alert">
                           {{$message}}		
                       </div>
                       @enderror
                   </div>
                   <div class="form-group">
                       <label for="slug" class="control-label mb-1"> Slug</label>
                       <input id="slug" value="{{old('slug')}}" name="slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                       @error('slug')
                       <div class="alert alert-danger" role="alert">
                           {{$message}}		
                       </div>
                       @enderror
                   </div>
                   <div class="row">
                       <div class="form-group col-md-6">
                           <label for="image" class="control-label mb-1"> Image</label>
                           <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" required>
                           @error('image')
                           <div class="alert alert-danger" role="alert">
                               {{$message}}		
                           </div>
                           @enderror
                       </div>
                       <div class="form-group col-md-6">
                           <label for="category_id" class="control-label mb-1"> Category</label>
                           <select id="category_id" name="category_id" class="form-control" required>
                               <option value="">Select Categories</option>
                               @foreach($category as $list)
                               @if (old('category_id')==$list->id)
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
                       <input id="brand" value="{{old('brand')}}" name="brand" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                   </div>
                   <div class="form-group">
                       <label for="desc" class="control-label mb-1"> Description</label>
                       <textarea id="desc" name="desc" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{old('desc')}}</textarea>
                   </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" id="best_selling" name="best_selling">
                        <label class="form-check-label" for="best_selling">
                        Best Selling
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="special" name="special">
                        <label class="form-check-label" for="special">
                        Discounted Products
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="popular" name="popular">
                        <label class="form-check-label" for="popular">
                        Popular Now
                        </label>
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
                            <div id="product_image_1">
                                <div class="form-group">
                                    <input type="hidden" name="piid[]">
                                    <label for="images" class="control-label mb-1"> Image</label>
                                    <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required>
                                </div>
                                @error('images.*')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}		
                                </div>
                                @enderror
                                <div class="col-3 col-sm-2 form-group">
                                    <button type="button" class="add_image_field form-control btn btn-outline-primary btn-sm mt-2">
                                    <i class="fa fa-plus"></i>&nbsp; Add</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           {{--  END Product Images Upload Section  --}}

           {{-- Product attribute Start --}}
            <div class="card">
               <div class="card-body">
                  <h2 class="mb10">Product Attributes</h2>
                  <div id="product_attr_box">
                     <div class="card" id="product_attr_1">
                           <div class="card-body">
                              <div class="form-group">
                                 <div class="row">
                                       <div class="col-md-2">
                                            <label for="sku" class="control-label mb-1"> SKU</label>
                                            <input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            @error('sku[]')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}		
                                            </div>
                                            @enderror
                                       </div>
                                       <div class="col-md-3">
                                          <label for="size_id" class="control-label mb-1"> Size</label>
                                          <select id="size_id" name="size_id[]" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($sizes as $list)
                                            <option value="{{$list->id}}">{{$list->size}}</option>
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
                                       
                                          <input id="msrp" name="msrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                          @error('msrp.*')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}		
                                            </div>
                                            @enderror
                                       </div>
                                       <div class="col-md-2">
                                          
                                        <label for="price" class="control-label mb-1"> Price</label>
                                       
                                          <input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                          @error('price')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}		
                                            </div>
                                            @enderror
                                       </div>
                                       <div class=" form-group col-4 col-sm-2">
                                            <label for="button">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                          <button type="button" class="add_form_field form-control mt-2 btn btn-outline-primary btn-sm">
                                          <i class="fa fa-plus"></i>&nbsp; Add</button> 
                                       </div>
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
            {{-- END Product Attributes --}}
           <div class="col-sm-1">
               <button type="submit" class="btn btn-primary">
               Submit
               </button>
           </div>
       </form>
   </div>
</div>

<script>

    //Product Attributes Buttons
$(document).ready(function() {
    var max_fields = 6;
    var wrapper = $("#product_attr_box");
    var add_button = $(".add_form_field");
    var x = 1;
   

    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append('<div class="card" id="product_attr_'+x+'"><div class="card-body"><div class="form-group"><div class="row"><div class="col-md-2"><label for="sku" class="control-label mb-1"> SKU</label><input name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div><div class="col-md-3"><label for="size_id" class="control-label mb-1"> Size</label><select name="size_id[]" class="form-control"><option value="">Select</option>@foreach($sizes as $list)<option value="{{$list->id}}">{{$list->size}}</option>@endforeach</select></div><div class="col-md-2"><label for="msrp" class="control-label mb-1"> MSRP</label><input id="msrp" name="msrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false"></div><div class="col-md-2"><label for="price" class="control-label mb-1"> Price</label><input name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div><div class=" col-5 col-sm-2"><label for="button">&nbsp;&nbsp;&nbsp;&nbsp;</label><button type="button" class="btn btn-outline-danger form-control btn-sm mt-2" onclick=remove("'+x+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div></div></div></div></div>'); //add input box
        } else {
            alert('You Reached the limits');
        }
    });


    //Product Images Buttons
    var max_fields_image = 6;
    var wrapper_image = $("#product_image_box");
    var add_button_image = $(".add_image_field");
    var y = 1;
   

    $(add_button_image).click(function(e) {
        e.preventDefault();
        if (y < max_fields_image) {
            y++;
            $(wrapper_image).append('<div id="product_image_'+y+'"><div class="form-group"><input type="hidden" name="piid[]"><label for="image" class="control-label mb-1"> Image</label><input name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required>@error("images")<div class="alert alert-danger" role="alert">{{$message}}</div>@enderror</div><div class="form-group col-4 col-sm-2"><button type="button" class="btn btn-outline-danger form-control mt-2 btn-sm mt-2" onclick=remove_image("'+y+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div></div></div>'); //add input box
        } else {
            alert('You Reached the limits');
        }
    });

 

});
//product Attribute Remove
function remove(loop_count){
           jQuery('#product_attr_'+loop_count).remove();
      }
      
//product Attribute Remove
function remove_image(image_num){
           jQuery('#product_image_'+image_num).remove();
      }




 
</script>
@endsection