<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <!-- Main CSS-->
    {{-- <link href="{{asset('front_assets/css/main.css')}}" rel="stylesheet" media="all"> --}}
    <style>
      .checkout{
        max-width: 500px;
        margin-inline: auto;
      }
      #CK_name, #CK_email{
        height: 45px;
        padding: 0;
        padding-top: 17px;
        padding-left: 10px;
      }
      .form-floating > label{
        padding: 9px;
      }
      .guest_info{
        margin-block: 30px;
      }
      .guest_info > p{
        display: flex;
        justify-content: end;
      }
      .guest_info > p > a{
        text-decoration: none;
      }
      .successfull_order_div{
        height: 100vh;
        width: 100vw;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        position: fixed;
        z-index: 1;
      }
      .successfull_order{
        margin-top: 30px;
        padding: 25px;
        border-radius: 15px;
        display: flex;
        height: 210px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #ff9431;
      }
      .successfull_order h1{
        color: white;
      }
      .successfull_order h6{
        color: white;
      }
      .successfull_order img{
        z-index: 3;
        width: 45px;
      }
      .successfull_order p{
        color: white;
      }
      #gif{
        width: 30px;
        position: relative;
        bottom: 12px;
      }
      #ck_img{
        position: relative;
        right: 20px;
      }
    </style>

  <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT')}}&currency=AUD"></script>
  {{-- <script src="https://www.paypal.com/sdk/js?client-id=AfXMmLz8FVlpc5tCGqAkhNJ6lGHTUINbpyn_4-_0xlC18cSKcmrJcRNC9lFYFuDu2SHBfedX17p-ITuT&locale=en_US"></script>   --}}
</head>
<div class="successfull_order_div d-none">
  <div class="successfull_order">
    <img src="{{asset('front_assets/images/check-solid.svg')}}" alt="">
    
    <h1>Thank You</h1>
    <h6>For Your Order</h6>
    <p>Redirecting to Main Menu</p>
    <img src="{{asset('front_assets/images/Spinners.gif')}}" id="gif">
  </div>
</div>
  <body>
    
    <div class="container">
        <div class="py-5 text-center">
          <img id="ck_img" class="d-block mx-auto mb-4" src="{{asset('front_assets/images/new_logo.png')}}" alt="" width="300">
          {{-- <h2>Checkout Page</h2> --}}
        </div>
  
        <div class="checkout">
          <div class=" mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted">Your cart</span>
            </h4>
            <ul class="list-group mb-3">
            @foreach ($list as $item)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">{{$item->name}}</h6>
                    <small class="text-muted">${{$item->price}} &nbsp;&nbsp;X&nbsp;&nbsp;{{$item->qty}}</small>
                </div>
                <span class="text-muted">${{$subTotal[$item->cart_id]}}</span>
                </li>
            @endforeach
              <li class="list-group-item d-flex justify-content-between">
                <span>Total (AUD)</span>
                <strong>${{$total}}</strong>
              </li>
            </ul>

          </div>
          {{-- @if (!session()->has('FRONT_USER_LOGIN'))
              <div class="guest_info">
                <h4 class="d-flex justify-content-between align-items-center ">
                  <span class="text-muted">Contact Information</span>
                </h4>
                <p class="mb-1">Already have an account? <a href="javascript:void()">log in</a></p>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="CK_name" name="CK_name" placeholder="Name" required >
                  <label for="str_login_password">Name</label>
                </div>
                <div class="form-floating">
                  <input type="email" class="form-control" id="CK_email" name="CK_email" placeholder="name@example.com" required>
                  <label for="str_login_email">Email address</label>
                </div>
              
              </div>
          @endif --}}
          <p class="text-muted note alert alert-info">NOTE: You can choose your preferred shipping address directly with PAYPAL account. Or you can provide your shipping address below when you checkout with Debit/Credit Card.</p>
          <div>
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted">Payment Methods</span>
            </h4>
            <div id="paypal-button-container"></div>
          </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
          <div class="additional_info">
            <div class="payment_icons orange">
                <i class="fab fa-cc-paypal"></i><i class="fab fa-cc-mastercard"></i><i class="fab fa-cc-visa"></i>
            </div>
            ABN: 28 641 263 505<br>
            SOHRABI PTY LTD &#169; 2022<br>
            All rights reserved
        </div>
        </footer>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script>
      paypal.Buttons({
        // Order is created on the server and the order id is returned
        createOrder: (data, actions) => {
          return fetch("/api/orders", {
            method: "post",
            // use the "body" param to optionally pass additional order information
            // like product ids or amount
          })
          .then((response) => response.json())
          .then((order) => order.id);
        },
        // Finalize the transaction on the server after payer approval
        onApprove: (data, actions) => {
          return fetch(`/api/orders/${data.orderID}/capture`, {
            method: "post",
          })
          .then((response) => response.json())
          .then((orderData) =>  {
            // Successful capture! For dev/demo purposes:
            // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            // Get the element with the class 'successfull_order_div'
            var successDiv = document.querySelector('.successfull_order_div');

            // Remove the 'd-none' class from the element
            successDiv.classList.remove('d-none');

            // Set a timeout to redirect to the root page after 2000ms
            setTimeout(function() {
              window.location.href = '/';
            }, 3000);

            // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        }
      }).render('#paypal-button-container');
    </script>

  </body>
</html>