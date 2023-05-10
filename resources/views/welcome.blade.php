<div class="col-md-8 order-md-1">
    <h4 class="mb-3">Billing address</h4>
    <form class="needs-validation" novalidate="">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="firstName">First name</label>
          <input type="text" class="form-control" id="firstName" placeholder="" value="{{$customers['firstName']}}" required>
          <div class="invalid-feedback">
            Valid first name is required.
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastName">Last name</label>
          <input type="text" class="form-control" id="lastName" placeholder="" value="{{$customers['lastName']}}" required="">
          <div class="invalid-feedback">
            Valid last name is required.
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="username">Email</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <input type="text" class="form-control" id="username" placeholder="Email" value="{{$customers['email']}}" required="">
          <div class="invalid-feedback" style="width: 100%;">
            Your username is required.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="firstName">Mobile Number</label>
          <input type="text" class="form-control" id="Mobile" placeholder="" value="{{$customers['mobile']}}" required>
          <div class="invalid-feedback">
            Valid first name is required.
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastName">Company</label>
          <input type="text" class="form-control" id="Company" placeholder="" value="{{$customers['company']}}" required="">
          <div class="invalid-feedback">
            Valid last name is required.
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" placeholder="1234 Main St" value="{{$customers['address']}}" required>
        <div class="invalid-feedback">
          Please enter your shipping address.
        </div>
      </div>

      <div class="mb-3">
        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
        <input type="text" class="form-control" id="address2" value="{{$customers['optionalAdd']}}" placeholder="Apartment or suite">
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="state">State</label>
          <select class="custom-select d-block w-100" id="state" required="">
            <option value="">Choose...</option>
            @if ($customers['state']=='Australian Capital Territory')
                <option value="Australian Capital Territory" selected>Australian Capital Territory</option>
            @else
                <option value="Australian Capital Territory">Australian Capital Territory</option>
            @endif
            
            @if ($customers['state']=='New South Wales')
                <option value="New South Wales" selected>New South Wales</option>
            @else
                <option value="New South Wales">New South Wales</option>
            @endif

            @if ($customers['state']=='Northern Territory')
                <option value="Northern Territory" selected>Northern Territory</option>
            @else
                <option value="Northern Territory">Northern Territory</option>
            @endif

            @if ($customers['state']=='Queensland')
                <option value="Queensland" selected>Queensland</option>
            @else
                <option value="Queensland">Queensland</option>
            @endif
            
            @if ($customers['state']=='South Australia')
                <option value="South Australia" selected>South Australia</option>
            @else
                <option value="South Australia">South Australia</option>
            @endif

            @if ($customers['state']=='Tasmania')
                <option value="Tasmania" selected>Tasmania</option>
            @else
                <option value="Tasmania">Tasmania</option>
            @endif

            @if ($customers['state']=='Victoria')
                <option value="Victoria" selected>Victoria</option>
            @else
                <option value="Victoria">Victoria</option>
            @endif

            @if ($customers['state']=='Western Australia')
                <option value="Western Australia" selected>Western Australia</option>
            @else
                <option value="Western Australia">Western Australia</option>
            @endif
            
          </select>
          <div class="invalid-feedback">
            Please provide a valid state.
          </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="zip">City</label>
            <input type="text" class="form-control" id="city" value="{{$customers['city']}}" required>
            <div class="invalid-feedback">
                city required.
            </div>
          </div>
        <div class="col-md-3 mb-3">
          <label for="zip">Zip</label>
          <input type="text" class="form-control" id="zip" value="{{$customers['postCode']}}" required>
          <div class="invalid-feedback">
            Zip code required.
          </div>
        </div>
      </div>
      <hr class="mb-4">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="same-address">
        <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
      </div>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="save-info">
        <label class="custom-control-label" for="save-info">Save this information for next time</label>
      </div>
      <hr class="mb-4">

      <h4 class="mb-3">Payment</h4>

      <div class="d-block my-3">
        <div class="custom-control custom-radio">
          <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
          <label class="custom-control-label" for="credit">Credit card</label>
        </div>
        <div class="custom-control custom-radio">
          <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
          <label class="custom-control-label" for="debit">Debit card</label>
        </div>
        <div class="custom-control custom-radio">
          <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
          <label class="custom-control-label" for="paypal">Paypal</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="cc-name">Name on card</label>
          <input type="text" class="form-control" id="cc-name" placeholder="" required="">
          <small class="text-muted">Full name as displayed on card</small>
          <div class="invalid-feedback">
            Name on card is required
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="cc-number">Credit card number</label>
          <input type="text" class="form-control" id="cc-number" placeholder="" required="">
          <div class="invalid-feedback">
            Credit card number is required
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="cc-expiration">Expiration</label>
          <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
          <div class="invalid-feedback">
            Expiration date required
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="cc-expiration">CVV</label>
          <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
          <div class="invalid-feedback">
            Security code required
          </div>
        </div>
      </div>
          <!-- Set up a container element for the button -->

      {{-- <hr class="mb-4">
      <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button> --}}
    </form>
    
  </div>