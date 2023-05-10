<div wire:ignore>
{{-- Best Selling Products  --}}
<div class="prd-slider-container">
    <div class="mt-4">
        <h4 class="mb-0">Best Selling</h4>
        <hr class="home-products">
    </div>
<div class="prd-slider" >
        @foreach ($best_selling_products as $item)
        <div class="box" >
            <div class="p-wrapper">
                <div class="prd-wrapper">

                    <a href="{{url('product')}}/{{$item->slug}}"><div class="prd-card-img">
                        <img src="{{asset('storage/media/product_img')}}/{{$item->image}}">
                    </div></a>
                    <div class="prd-card-category">
                        <a href="{{url('listing')}}/{{$links[$item->id]->aisle_slug}}/{{$links[$item->id]->category_slug}}"><span>{{$item->category_name}}</span></a>
                    </div>
                    <div class="prd-card-name">
                        <a href="{{url('/product')}}/{{$item->slug}}"><span>{{$item->name}}</span></a>
                    </div>
                </div>
                <div class="prd-wrapper">
                    <div class="prd-card-sizes">

                        <span>{{$sizeArr[$item->id]}}</span>

                    </div>
                    <div class="prd-card-price">
                        <span>${{$minPrice[$item->id]}}</span>
                    </div>
                    <button wire:click="addToCart({{$item->id}},{{$best_product_attr[$item->id][0]->id}},1)" type="button" class="add-cart" >
                        {{-- ADD TO CART --}}
                        <span class="icon-container">
                            <i class="fas fa-shopping-cart icon-c"></i>
                          </span>
                          <span class="primary-text">ADD TO CART</span>
                          <span class="secondary-text">ITEM ADDED</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach

    </div>  
           
</div>
{{-- End best selling Products --}}


{{-- DISCOUNTED PRODUCTS --}}
<div class="prd-slider-container">
    <div class="mt-4">
        <h4 class="mb-0">Discounted Products</h4>
        <hr class="home-products">
    </div>
    <div class="prd-slider">

        @foreach($discounted_products as $item)
        <div class="box">
            <div class="p-wrapper">
                <div class="prd-wrapper">
                    <a href="{{url('product')}}/{{$item->slug}}">
                        <div class="prd-card-img">
                            <img src="{{asset('storage/media/product_img')}}/{{$item->image}}" alt="">
                        </div>
                    </a>
                    <div class="prd-card-category">
                        <a href="{{url('listing')}}/{{$links[$item->id]->aisle_slug}}/{{$links[$item->id]->category_slug}}"><span>{{$item->category_name}}</span></a>
                    </div>
                    <div class="prd-card-name">
                        <a href="{{url('product')}}/{{$item->slug}}"><span>{{$item->name}}</span></a>
                    </div>
                </div>
                <div class="prd-wrapper">
                    <div class="prd-card-sizes">
                        <span>{{$sizeArr[$item->id]}}</span>
                    </div>
                    <div class="prd-card-price">
                        <span id="discount-msrp"><s>${{$minMsrp[$item->id]}}</s></span>&nbsp;
                        <span>${{$minPrice[$item->id]}}</span>
                    </div>
                    
                    {{-- <button wire:click="addToCart({{$item->id}},{{$discounted_products_attr[$item->id][0]->id}},1)" type="button" class="add-cart" >ADD TO CART</button> --}}
                    <button wire:click="addToCart({{$item->id}},{{$discounted_products_attr[$item->id][0]->id}},1)" type="button" class="add-cart" >
                        {{-- ADD TO CART --}}
                        <span class="icon-container">
                            <i class="fas fa-shopping-cart icon-c"></i>
                          </span>
                          <span class="primary-text">ADD TO CART</span>
                          <span class="secondary-text">ITEM ADDED</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        
        
        
    </div>
</div>
{{-- End discounted products --}}

{{-- Popular Now --}}
<div class="prd-slider-container">
    <div class="mt-4">
        <h4 class="mb-0">Popular Now</h4>
        <hr class="home-products">
    </div>
    <div class="prd-slider">

        @foreach($popular_products as $item)
        <div class="box">
            <div class="p-wrapper">
                <div class="prd-wrapper">
                    <a href="{{url('product')}}/{{$item->slug}}">
                        <div class="prd-card-img">
                            <img src="{{asset('storage/media/product_img')}}/{{$item->image}}" alt="">
                        </div>
                    </a>
                    <div class="prd-card-category">
                        <a href="{{url('listing')}}/{{$links[$item->id]->aisle_slug}}/{{$links[$item->id]->category_slug}}"><span>{{$item->category_name}}</span></a>
                    </div>
                    <div class="prd-card-name">
                        <a href="{{url('product')}}/{{$item->slug}}"><span>{{$item->name}}</span></a>
                    </div>
                </div>
                <div class="prd-wrapper">
                    <div class="prd-card-sizes">
                        <span>{{$sizeArr[$item->id]}}</span>
                    </div>
                    <div class="prd-card-price">
                        <span>${{$minPrice[$item->id]}}</span>
                    </div>
                    {{-- <button wire:click="addToCart({{$item->id}},{{$popular_products_attr[$item->id][0]->id}},1)" type="button" class="add-cart" >ADD TO CART</button> --}}
                    <button wire:click="addToCart({{$item->id}},{{$popular_products_attr[$item->id][0]->id}},1)" type="button" class="add-cart" >
                        {{-- ADD TO CART --}}
                        <span class="icon-container">
                            <i class="fas fa-shopping-cart icon-c"></i>
                          </span>
                          <span class="primary-text">ADD TO CART</span>
                          <span class="secondary-text">ITEM ADDED</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach 
        
        
    </div>
</div>
{{-- END Popular Now --}}

</div>