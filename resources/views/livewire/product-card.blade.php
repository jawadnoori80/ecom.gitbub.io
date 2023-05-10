{{-- @php
    prx($product_id);
@endphp --}}
<div wire:ignore>
    <button wire:key="item-{{ $product_id }}" wire:click.prevent="add({{$product_id}},{{$product_attr}},{{$qty}})" type="button" class="add-cart">
        <span class="icon-container">
            <i class="fas fa-shopping-cart icon-c"></i>
        </span>
        <span class="primary-text">ADD TO CART</span>
        <span class="secondary-text">ITEM ADDED</span>
    </button>
</div>
