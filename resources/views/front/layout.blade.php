<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="theme-color" content="#fff3e1">

    <!-- Title Page-->
    <title>@yield('page_title')</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset('admin_assets/css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin_assets/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    {{-- font family --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Ionicons --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i&display=swap" rel="stylesheet">
    @if(isset($page))
        @if($page== 'home' || $page== 'product')
            {{-- Carousel Assets --}}
            <link rel="stylesheet" href="{{asset('front_assets/carousel/css/owl.carousel.min.css')}}">
            <link rel="stylesheet" href="{{asset('front_assets/carousel/css/owl.theme.default.min.css')}}">
        @endif
    @endif
            <link rel="stylesheet" href="{{asset('front_assets/carousel/css/style.css')}}">

    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/carousel/slick/slick.css')}}"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/carousel/slick/slick-theme.css')}}"/>
    
    
    <!-- Jquery JS-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <!-- Main CSS-->
    <link href="{{asset('front_assets/css/main.css')}}" rel="stylesheet" media="all">
    

    @livewireStyles

</head>

<body>

 <!-- HEADER MOBILE-->
<div class="header-wrapper">
    {{-- <div class="new_logo">
        <a href="/">
            <img class="logo" src="{{asset('front_assets/images/new_logo.png')}}" alt="" />
        </a>
    </div> --}}
    <header class="header header-mobile d-block ">
       <div class="container-lg">
        
          <div class="header-mobile-inner">

                <div class="header_mobile-nav"> 
                    <button class="btn hamburger_icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasWithBackdrop">
                    <img src="{{asset('front_assets/images/hum.svg')}}" alt="">
                    </button>
                </div>

                <div class="new_logo">
                    <a href="/">
                        <img class="logo_img" src="{{asset('front_assets/images/new_logo.png')}}" alt="" />
                    </a>
                </div>
                
                {{-- <div class="header_logo">
                    <a href="/">
                    <img class="logo" src="{{asset('front_assets/images/logo.png')}}" alt="" />
                    </a>
                </div> --}}

                <form id="search_desk" action="{{url('/search')}}/">
                    <div id="search-bar">
                    <div class="search input-group mx-3">
                        <input id="search_input_desk" name="q" type="search" class="form-control search-bar-control" placeholder="Search for..." aria-describedby="button-addon2">
                </form>
                
                <button id="search_btn_desk" type="button" class="btn search-btn"><i class="fa fa-search"></i></button>
                </div>
                </div>
             <livewire:cart />
          </div>
       </div>
    </header>
    <div id="search-bar-collapse-wrapper" class="collapse">
       <div id="search-bar-collapse">
          <form id="search_mobile" action="{{url('/search')}}/">
             <div class="search input-group mx-3">
                <input id="search_input_mobile" name="q" type="search" class="form-control search-bar-control" placeholder="Search Product" aria-describedby="button-addon2">
          </form>
          <button id="search_btn_mobile" type="button" class="btn search-btn"><i class="fa fa-search"></i></button>
          </div>
    </div>
</div>


    {{-- end mobile Nav-bar --}}
<div class="header-desktop-nav">
    <div class="container-lg">
        <ul id="desktop-ul">
            <span id="aisle">SHOP BY AISLE:</span>
            @php
                $aisLoop = 1;    
            @endphp
            @foreach($aisles as $aisle)
            <li>
                <a id="aisle-list-{{$aisLoop}}" href="javascript:void()">{{$aisle->aisle_name}} <i class="fa fa-angle-down"></i></a>
                <i class="fa fa-sort-up up-{{$aisLoop}}"></i>
                <ul class="aisle-dropdown-ul-{{$aisLoop}}">
                    @foreach ($categories as $category)
                    @if($category->aisle_id==$aisle->id)
                    <li><a href="{{url('listing')}}/{{$aisle->aisle_slug}}/{{$category->category_slug}}">{{$category->category_name}}</a></li>
                    @endif   
                    @endforeach

                </ul>
            </li>
            @php
                $aisLoop++;
            @endphp
            @endforeach

            
        </ul>
    </div>
  </div>
</div>
<!-- END HEADER MOBILE-->

</div>
   
{{-- end Header Wrapper --}}




{{-- mobile Nav-bar --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Aisles</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <div class="accordion accordion-flush" id="accordionFlushExample">
        @php
        $aisLoop = 1;    
        @endphp
        @foreach($aisles as $aisle)
          <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading-{{$aisLoop}}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$aisLoop}}" aria-expanded="false" aria-controls="flush-collapse-{{$aisLoop}}">
                    {{$aisle->aisle_name}}
                  </button>
              </h2>
              <div id="flush-collapse-{{$aisLoop}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$aisLoop}}" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                      <ul class="accordion-ul">
                        @foreach ($categories as $category)
                            @if($category->aisle_id==$aisle->id)
                                <a href="{{url('listing')}}/{{$aisle->aisle_slug}}/{{$category->category_slug}}"><li>{{$category->category_name}}</li></a>
                            @endif   
                        @endforeach
                      </ul>
                  </div>
              </div>
          </div>
        @php
        $aisLoop++;
        @endphp
        @endforeach
      </div>
  </div>
</div>

<!-- MAIN CONTENT-->
<div class="main-content">
        @section('container')
        @show
</div>

<!-- END PAGE CONTAINER-->










@livewireScripts

    {{-- Main JS --}}
    <script src="{{asset('front_assets/js/main.js')}}"></script>


<footer class="layout_footer">
    <div class="container">
        <div class="footer">
            <div class="about_us">
                <h3 class="orange">About Us</h3>
                <p class="footer_par">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit soluta sequi ad quam accusamus porro vero praesentium adipisci est minima.</p>
            </div>
            <div class="business_hours">
                <h3 class="orange">Business Hours</h3>
                <p class="footer_par">
                    Mon: 8:30 am &ndash; 10:00 pm<br>
                    Tue: 8:30 am &ndash; 10:00 pm<br>
                    Wed: 8:30 am &ndash; 10:00 pm<br>
                    Thu: 8:30 am &ndash; 10:00 pm<br>
                    Fri: 8:30 am &ndash; 10:00 pm<br>
                    Sat: 8:30 am &ndash; 10:00 pm<br>
                    Sun: 8:30 am &ndash; 10:00 pm<br>

                </p>
            </div>
            <div class="contact_us">
                <h3 class="orange">Contact Us</h3>
                <p class="footer_par">
                    <a href="tel:0411 319 828">0411 319 828</a><br>
                    <a href="mailto:ajeebsohrabi@gmail.com">ajeebsohrabi@gmail.com</a><br>
                    6 Civic Road, Auburn NSW 2144
                </p>
            </div>
            
            
        </div>
        <div class="additional_info">
            <div class="payment_icons orange">
                <i class="fab fa-cc-paypal"></i><i class="fab fa-cc-mastercard"></i><i class="fab fa-cc-visa"></i>
            </div>
            ABN: 28 641 263 505<br>
            SOHRABI PTY LTD &#169; 2022<br>
            All rights reserved
        </div>
    </div>

</footer>
  
</body>

</html>
<!-- end document-->