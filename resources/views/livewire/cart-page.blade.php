<div class="cart-wrapper">
    <div class="cart-products">
      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th class="allign-center">Quantity</th>
            <th class="allign-center">Total</th>
          </tr>
        </thead>
        <tbody>
          
          
              
          @if(isset($list[0]))
          @foreach ($list as $item)
              
          
          <tr>
            <td>
              <div class="product-info-wrapper">
                <div class="img">
                  <img src="{{asset('storage/media/product_img')}}/{{$item->image}}" alt="">
                </div>
                <div class="product-desc">
                  <a href="#"><h5>{{$item->name}}</h5></a>
                  <div class="product-price">
                    @foreach ($list_attr[$item->id] as $attr)
                    @if ($attr->id==$item->product_attr_id)
                      @if ($attr->msrp!==null)
                      <s class="gray"><span class="disc">${{$attr->msrp}}</span></s>
                      @endif
                    <span class="priceC">${{$attr->price}}</span>
                    @endif

                    @endforeach
                  </div>
                  <div class="size">
                    <span >Size:</span>
                    <select class="cart-page-size">
                      @foreach ($list_attr[$item->id] as $attr)
                      
                      <option value="{{$attr->size_id}}" data-item-id="{{$item->id}}" data-attr-id="{{$attr->id}}" data-attr-price="{{$attr->price}}" data-attr-msrp="{{$attr->msrp}}" <?php if($attr->id==$item->product_attr_id){echo 'selected';} ?> >{{$attr->size}}</option>

                      @endforeach
                    </select>
                  </div>

                  <div class="mobile-cart-td">
                    <div class="input-group">

                      <button type="button" class="btn btn-default btn-number"  data-type="minus" data-field="quant[{{$item->id}}]">
                        <span class="fa fa-minus"></span>
                      </button>

                      <input type="text" name="quant[{{$item->id}}]" class="form-control input-number" value="{{$item->qty}}" min="1" max="20">

                      <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[{{$item->id}}]">
                        <span class="fa fa-plus"></span>
                      </button>

                    </div>
                    <div class="gray">
                      <button wire:click.prevent="remove_item({{$item->cart_id}})" type="button" class="remove-item" data-item-id="{{$item->cart_id}}">Remove</button>
                    </div>
                    
                  </div>
                  <div class="product-total">
                    <span>${{$item->qty*$item->price}}</span>
                  </div>

                </div>
                
              </div>
            </td>
            <td class="desktop-cart-td">
              <div class="quantity-wrapper">
                <div class="input-group">

                  <button type="button" class="btn btn-default btn-number"  data-type="minus" data-field="quant[{{$item->id}}]">
                    <span class="fa fa-minus"></span>
                  </button>

                  <input type="text" name="quant[{{$item->id}}]" class="form-control input-number" value="{{$item->qty}}" min="1" max="20">

                  <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[{{$item->id}}]">
                    <span class="fa fa-plus"></span>
                  </button>

                </div>
                <div class="gray">
                  <button wire:click.prevent="remove_item({{$item->cart_id}})" type="button" class="remove-item">Remove</button>
                </div>
              </div>
            </td>
            <td class="desktop-cart-td bold"><span>${{$item->qty*$item->price}}</span></td>
            
            
            <form action="/update_cart" class="update" method="POST">
              <input type="hidden" id="product_id" name="product_id[]" value="{{$item->id}}">
              <input type="hidden" id="attr_id" name="product_attr_id[]" value="{{$item->product_attr_id}}">
              <input type="hidden" id="product_qty" name="product_qty[]" value="{{$item->qty}}">
              @csrf
            </form>

          </tr>


          
       
          @endforeach
          @else
          <tr>
            <td><h3>EMPTY CART!</h3>
            <A href="/">SHOP NOW</A></td>
          </tr>
          @endif
          
          <tr>
            <td colspan="3" id="btn-area" >

              <button type="button" id="update" class="orange_button" style="width:150px; height:50px">Update Cart</button>
            </td>

          </tr>
        </tbody>
      </table>



          
    </div>
    <div class="cart-total">
      <h5>Cart Totals</h5>
      <hr>
      <div class="totals-wrapper">
        <table>
          <tbody>
            <tr>
              <th class="bold">Subtotal</th>
              <td>${{$total}}</td>
            </tr>
            <tr>
              <th class="bold">Shipping</th>
              <td>FREE</td>
            </tr>
            <tr>
              <th class="bold">Total</th>
              <td>${{$total}}</td>
            </tr>
          </tbody>
        </table>
        <a style="all: unset" href="{{url('/checkout')}}"><button type="button" class="orange_button mt-3">CHECKOUT</button></a>
      </div>

    </div>
</div>