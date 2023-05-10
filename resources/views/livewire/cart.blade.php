{{-- @php
prx($list);
@endphp --}}
<div class="margin_left_auto">
<div class="nav-actions">
    <div class="search-bar-mobile">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#search-bar-collapse-wrapper" aria-expanded="false" aria-controls="search-bar-collapse-wrapper">
            <ion-icon name="search-outline"></ion-icon>
        </button>
    </div>
        
    <div class="profile">
        <button id="profile_button" type="button">
        <i class="fa fa-user"></i>
        </button>
    </div>
    
    <div class="cart">
        {{-- @php
            $result=topNavCart();
            $miniCart=$result['list'];
            $subTotal=$result['subTotal'];
            $total=$result['total'];
            $cartCount=count($miniCart);
        @endphp --}}
        <button id="cart-button" type="button">
            <i class="fa fa-shopping-cart"></i>
            <span id="badgeNum">{{$cartCount}}</span>
        </button>
    </div>
    <i class="fa fa-sort-up mini-up-1"></i>
    <i class="fa fa-sort-up profile-mini-up-1"></i>
</div>
{{-- Mini Cart --}}
<div class="mini-cart">
    <div class="mini-cart-content">
        @if ($cartCount>0)
       
        @foreach ($list as $miniPrd)

        <div class="item">
            <div class="mini-cart-img">
                <img src="{{asset('storage/media/product_img')}}/{{$miniPrd->image}}" alt="">
            </div>
            <div class="mini-cart-product-info">
                <a href="/product/{{$miniPrd->slug}}">{{$miniPrd->name}}</a>
             
                <div class="mini-cart-pricelist">
                    <span>Size: {{$miniPrd->size}}</span><br>
                    <span>${{$miniPrd->price}} X {{$miniPrd->qty}}</span>
                </div>
            </div>
            <div class="miniCart_side">
                {{-- <button wire:key="item-{{$miniPrd->cart_id}}" wire:click.prevent="remove_item({{$miniPrd->cart_id}})" type="button" class="remove-item gray">Remove</button> --}}
                <span class="subTotal">${{$subTotal[$miniPrd->cart_id]}}<span>
            </div>
                
        </div>
        @endforeach
        @else
        <div class="item">
            <p class="mx-auto">EMPTY!</p>
        </div>
        @endif
        
    </div>
    <div class="mini-cart-recap">
        <div class="mini-cart-recap-price">
            <span>Total</span>
            <span>${{$total}}</span>
        </div>
        <div class="mini-cart-recap-buttons">
            <a style="all: unset" href="{{url('/cart')}}"><button class="btn">View Order</button></a>
            <a style="all: unset" href="{{url('/checkout')}}"><button class="btn">Checkout</button></a>
        </div>
    </div>
</div>
{{--  End Mini Cart --}}

{{-- Profile --}}
<div class="mini_profile">
    @php
        if(isset ($_COOKIE['login_email']) && isset($_COOKIE['login_pwd'])){
        $login_email=$_COOKIE['login_email'];
        $login_pwd=$_COOKIE['login_pwd'];
        $is_remember="checked='checked'";
        }else{
            $login_email='';
            $login_pwd='';
            $is_remember='';
        }
    @endphp
    @if (session()->has('FRONT_USER_LOGIN')==true)
    <ul>
        {{-- <h5>HI!</h5>
        <li><a href="javascript:void(0)">Login</a></li>
        <li><a href="{{url('/registration')}}">Create account</a></li> --}}
        
       <h5>HI {{strtoupper(session()->get('FRONT_USER_NAME'))}}</h5>
       <li><a href="{{url('/my_account')}}">My Account</a></li>
        <li><a href="{{url('/orders')}}">My Orders</a></li>
        <li><a href="{{url('/logout')}}">Logout</a></li>
    </ul>
    
    @else
    
    <div class="login_form">
        <h4 class="orange">Login to my account</h4>
        <h6>Enter your e-mail and password:</h6>
        <form id="login_frm">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="str_login_email" name="str_login_email" placeholder="name@example.com" value="{{$login_email}}">
                <label for="str_login_email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="str_login_password" name="str_login_password" placeholder="Password" value="{{$login_pwd}}">
                <label for="str_login_password">Password</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme" {{$is_remember}}>
                <label class="form-check-label" for="rememberme">
                  Remember Me
                </label>
              </div>
              @csrf
            <span class="text-danger" id="incorrect"></span>
            <img src="{{asset('front_assets/carousel/slick/ajax-loader.gif')}}" id="login_gif">
            <button type="submit" class="login-btn">LOGIN</button>
            
                {{-- <label for="">Email address</label>
                <input type="email" class="form-control" placeholder="name@example.com">
                <br>
                <label for="">Password</label>
                <input type="password" class="form-control" placeholder="Password"> --}}

        </form>
        <span class="gray">New customer? </span><span><a class="orange" href="{{url('registration')}}">Create your account</a></span><br>
        <span class="gray">Lost password? </span><span><button type="button" id="forgotPassword" class="orange">Recover password</button></span>

    </div>
    <div class="forgotPassword">
        <h4 class="orange">Forgot Password</h4>
        <h6>Enter your email address to <br> reset password:</h6>

        
        <form id="reset_frm">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="resetEmail" name="str_reset_email" placeholder="name@example.com" value="{{$login_email}}">
                <label for="resetEmail">Email address</label>
            </div>
            @csrf
            <span class="text-danger" id="resetMsg"></span>
            <img src="{{asset('front_assets/carousel/slick/ajax-loader.gif')}}" id="gif">
            <button type="submit" class="resetPassword">Reset Password</button>
            
                {{-- <label for="">Email address</label>
                <input type="email" class="form-control" placeholder="name@example.com">
                <br>
                <label for="">Password</label>
                <input type="password" class="form-control" placeholder="Password"> --}}

        </form>
        <span><button type="button" id="loginInstead" class="orange">Login instead!</button></span>

    </div>
    @endif
</div>
{{-- end Profile --}}

</div>

