@extends('front.layout')
@section('page_title','Home')
@section('container')

{{-- Carousel Start --}}
<section class="ftco-section">
        <div class="row">
            <div class="col-md-12">
                <div class="featured-carousel owl-carousel">

                    @foreach($home_banner as $item)
                    <div class="item">
                        <div class="work">
                            <div class="img d-flex  align-items-end justify-content-center" style="background-image: url({{asset('storage/media/banners/')}}/{{$item->image}});">
                                <div class="text w-100">
                                    <span class="cat">{{$item->tag}}</span>
                                    <h3><a href="{{$item->link}}">{{$item->text}}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
</section>

{{-- End Carousel --}}


    <livewire:products /> 


{{-- <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<form action="/add_to_cart" id="hFrmAddToCart">
    <input type="hidden" id="hCart_product_id"  name="cart_product_id">
    <input type="hidden" id="hCart_attr_id" name="cart_attr_id">
    <input type="hidden" id="hCart_qty" name="cart_qty" value="1">
    @csrf
</form> --}}
        <!-- Jquery JS-->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>

{{-- <script src="{{asset('front_assets/carousel/js/popper.js')}}"></script> --}}
<script src="{{asset('front_assets/carousel/js/bootstrap.min.js')}}"></script>
<script src="{{asset('front_assets/carousel/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('front_assets/carousel/js/main.js')}}"></script>


<script type="text/javascript" src="{{asset('front_assets/carousel/slick/slick.js')}}"></script>
<script type="text/javascript" src="{{asset('front_assets/carousel/slick/slick.min.js')}}"></script>

<script>
    $(document).ready(function() {
        
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


    //   $('.add-cart').click( function(e){
    //     e.preventDefault();
    //     var id = $(this).data('prd-id');
    //     var attr_id = $(this).data('prdattr-id');
    //     var token= $('#token').val()
    //     var qty= 1;
    //     // $("#hCart_product_id").val(id);
    //     // $("#hCart_attr_id").val(attr_id);
        
    //     $.ajax({
    //         url:"{{url('add_to_cart')}}",
    //         data: {id: id, attr_id: attr_id, qty: qty, "_token": token},
    //         type:'post',
    //         // success:function(){
                
    //         // }
    //      });
    });



    



      

 
    </script>
@endsection
