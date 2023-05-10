@extends('front.layout',['links' => 'true'])
@section('page_title',$product[0]->name)
@section('container')

<div class="container-lg">
    <div class="product-wrapper">
        
        
        <div class="product-images">
            <div class="image-gallery">
                <aside class="thumbnails">
                  @foreach ($products_images as $img)
                  <a href="#" class="thumbnail" data-big="{{asset('storage/media/product_img')}}/{{$img->images}}">
                    <div class="thumbnail-image" style="background-image: url({{asset('storage/media/product_img')}}/{{$img->images}})"></div>
                  </a>
                  @endforeach
                  
                  
                </aside>
              
                <main class="primary" style="background-image: url();"></main>
              </div>
        </div>
        
        
        
        <div class="product-info">
            <h2>{{$product[0]->name}}</h2>
            <span class="bold">{{$product[0]->category_name}}</span>
            <hr>
            <div class="brand">
              <span class="bold">Brand:</span>
              <span class="bold">{{$product[0]->brand}}</span>
            </div>
            <div class="Description">
              <span class="bold">Description:</span><p>{{$product[0]->desc}}</p>
              
            </div>
            <div class="size">
              <span class="bold">Size:</span>
              <select id="product-page-size">
                @foreach ($product_attr as $attr)
                
                @php
                    $attrLoop=0;
                @endphp
                <option value="{{$attr->size_id}}" data-attr-id="{{$attr->id}}" data-attr-price="{{$attr->price}}" data-attr-msrp="{{$attr->msrp}}" <?php if($attrLoop==1){echo 'selected';} ?> >{{$attr->size}}</option>
                @php
                    $attrLoop++;
                @endphp
                @endforeach
              </select>
            </div>

            <s><span id="msrp"></span></s>

                
            
            <span id="product-page-price"></span>
            <div class="quantity">
              

                    <span>Quantity:</span>
                    <div class="input-group">

                        <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                          <span class="fa fa-minus"></span>
                        </button>

                      <input type="text" id="cart_product_qty" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">

                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                          <span class="fa fa-plus"></span>
                        </button>

                    </div>


            </div>
            <form action="/add_to_cart" id="frmAddToCart">
              <input type="hidden" id="cart_product_id"  name="id" value="{{$product[0]->id}}">
              <input type="hidden" id="cart_attr_id" name="attr_id" >
              <input type="hidden" id="cart_qty" name="qty" >
              @csrf
            </form>
            
            <button id="prd_addtoCart" type="button" class="btn bold addtoCart">
              <span class="icon-container">
                <i class="fas fa-shopping-cart icon-c"></i>
              </span>
              <span class="primary-text">ADD TO CART</span>
              <span class="secondary-text">ITEM ADDED</span>
            </button>
        </div>
    </div>
    
  </div>
  {{-- Related Products  --}}
  <div class="prd-slider-container">
    <div class="mt-4">
        <h4 class="mb-0">Related Products</h4>
        <hr class="home-products">
    </div>
    <div class="prd-slider">
        @foreach ($related_products as $relProduct)
        <div class="box">
            <div class="p-wrapper">
                <div class="prd-wrapper">
                    <a href="{{url('/product')}}/{{$relProduct->slug}}"><div class="prd-card-img">
                        <img src="{{asset('storage/media/product_img')}}/{{$relProduct->image}}">
                    </div></a>
                    <div class="prd-card-category">
                        <a href="{{url('/listing')}}/{{$links[$relProduct->id]->aisle_slug}}/{{$links[$relProduct->id]->category_slug}}"><span>{{$relProduct->category_name}}</span>
                    </div>
                    <div class="prd-card-name">
                        <a href="/product/{{$relProduct->slug}}"><span>{{$relProduct->name}}</span></a>
                    </div>
                </div>
                <div class="prd-wrapper">
                    <div class="prd-card-sizes">

                        <span>{{$sizeArr[$relProduct->id]}}</span>

                    </div>
                    <div class="prd-card-price">
                        <span>${{$minPrice[$relProduct->id]}}</span>
                    </div>
                    {{-- @php
                        prx();
                    @endphp --}}
                    @livewire('product-card',[
                    'product'  => $relProduct->id,
                    'product_attr'  => $related_products_attr[$relProduct->id][0]->id,
                    'qty'  => 1,
                    ])
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
  </div>
  {{-- End best selling Products --}}
        <!-- Jquery JS-->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="{{asset('front_assets/carousel/slick/slick.js')}}"></script>
  <script type="text/javascript" src="{{asset('front_assets/carousel/slick/slick.min.js')}}"></script>
  
<script>
  $(document).ready(function() {
    // slickSlider for Product Page Image Thumbnails---------------------------
    $('.prd-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToScroll: 2,
        arrows:true,
  
        variableWidth: true,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
  
  
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });
      jQuery.event.special.touchstart = {
        setup: function( _, ns, handle ){
          if ( ns.includes("noPreventDefault") ) {
            this.addEventListener("touchstart", handle, { passive: false });
          } else {
            this.addEventListener("touchstart", handle, { passive: true });
          }
        }
      };
      jQuery.event.special.touchmove = {
        setup: function( _, ns, handle ){
          if ( ns.includes("noPreventDefault") ) {
            this.addEventListener("touchmove", handle, { passive: false });
          } else {
            this.addEventListener("touchmove", handle, { passive: true });
          }
        }
      };

      // $("#prd_addtoCart").on('click',function (e) {
      //   e.preventDefault();
      //   var qty =$('#cart_product_qty').val();
      //   $("#cart_qty").val(qty);
      //   $.ajax({
      //       url:"{{url('add_to_cart')}}",
      //       data: $('#frmAddToCart').serialize(),
      //       type:'post',
      //       enctype: 'mutipart/form-data',
      //       success:function(result){
      //           alert('shud');
      //       }

      //   });
      // });
  });
  </script>
@endsection
