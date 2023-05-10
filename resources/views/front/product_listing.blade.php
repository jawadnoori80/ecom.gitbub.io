@extends('front.layout')
@section('page_title','Products')
@section('container')

<section class="section-container">

    <div class="listing-layout">
        <div class="listing-filter">
            <h4>Aisles</h4>
            <div class="category-list-desktop">
                <ul id="desktop-side-ul">
                    @foreach ($aisles as $aisle)
                        <li>
                            @if ($aisle->aisle_slug==$aisle_slug)
                            <button type="button" class="gray accordion-button" data-bs-toggle="collapse" data-bs-target="#filter-{{$aisle->id}}" aria-controls="filter-{{$aisle->id}}" aria-expanded="true">{{$aisle->aisle_name}}</button>
                            <div id="filter-{{$aisle->id}}" class="accordion-collapse collapse show" data-bs-parent="#desktop-side-ul" aria-hidden="true" aria-expanded="false">
                            @else
                            <button type="button" class="gray accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#filter-{{$aisle->id}}" aria-controls="filter-{{$aisle->id}}" aria-expanded="false">{{$aisle->aisle_name}}</button>
                            <div id="filter-{{$aisle->id}}" class="accordion-collapse collapse" data-bs-parent="#desktop-side-ul" aria-hidden="true" aria-expanded="false">
                            @endif
                                <ul class="side-ul-{{$aisle->id}}">
                                    @foreach ($categories as $category)
                                    @if($category->aisle_id===$aisle->id)
                                        @if ($category->category_slug==$category_slug)
                                        <li><a class="active" href="{{url('listing')}}/{{$aisle->aisle_slug}}/{{$category->category_slug}}">{{$category->category_name}}</a></li>
                                        @else
                                        <li><a href="{{url('listing')}}/{{$aisle->aisle_slug}}/{{$category->category_slug}}">{{$category->category_name}}</a></li>
                                        @endif
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                    @endforeach
                </ul>

            </div>
            
        </div>
        <div class="listing-products">
            <div class="listing-products-header-title">
                <span>{{$aisle_name}} > {{$category_name}}</span>
            </div>
            <div class="listing-products-header">
                {{-- <div class="display">
                    <span>Display:</span>
                    <select>
                        <option value="24" selected>24 per page</option>
                        <option value="36">36 per page</option>
                        <option value="48">48 per page</option>
                    </select>
                </div> --}}
                <div class="sort">
                    <span>Sort By:</span>
                    <select id="sortBy">
                        <option value="" selected="Default">default</option>
                        @if ($sort=='name')
                           <option value="name" selected>Name</option>
                           @else
                           <option value="name">Name</option>
                           @endif
                           @if ($sort=='price_asc')
                           <option value="price_asc" selected>Price - asc</option>
                           @else
                           <option value="price_asc">Price - asc</option>
                           @endif
                           @if ($sort=='price_desc')
                           <option value="price_desc" selected>Price - Desc</option>
                           @else
                           <option value="price_desc">Price - Desc</option>
                           @endif
                    </select>
                </div>
            </div>

            

                
                {{-- <livewire:product-card $product/>  --}}
                {{-- <livewire:product-card :product="$product,$sizeArr"/> --}}
                    {{-- @livewire('product-card', $product) --}}
                    {{-- , :sizeArr="$sizeArr" --}}
                {{-- @if (isset($minPrice)) --}}
                <div class="product-list" wire:ignore >   
                    @foreach ($product as $item)
                        <div class="product-card" >
                            {{-- @php
                                    prx($item->id);
                                @endphp --}}
                            <div class="prd-wrapper">
                                <div class="prd-card-img">
                                    <img src="{{asset('storage/media/product_img')}}/{{$item->image}}">
                                </div>
                                
                                <div class="prd-card-category">
                                    <a href="{{url('listing')}}/{{$item->aisle_slug}}/{{$item->category_slug}}"><span>{{$item->category_name}}</span></a>
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
                            
                                
                    
                @livewire('product-card',[
                    'product'  => $item->id,
                    'product_attr'  => $product_attr[$item->id][0]->id,
                    'qty'  => 1,
                    ])
                
                {{-- @endif --}}
                
            </div>
        </div>
    @endforeach
    
    {{-- wire:click="addToCart" --}}
 </div>
 @if (count($product)<1)
    <div class="empty_result">
        <h3 class="gray">No Results</h3>
    </div>
    @endif
 <div class="mt-6 d-flex justify-content-center">
    {{$product->links()}}
</div>
                

        </div>
    </div>

</section>


<form id="categoryFilter">
    <input type="hidden" id="sort" name="sort" value="{{$sort}}"/>
</form>
@endsection