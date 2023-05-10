$(document).ready(function() {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //layout Functions------------------------------------------------------------------
    var a = [".aisle-dropdown-ul-1",".aisle-dropdown-ul-2",".aisle-dropdown-ul-3",".aisle-dropdown-ul-4",".aisle-dropdown-ul-5",".aisle-dropdown-ul-6",".aisle-dropdown-ul-7",".aisle-dropdown-ul-8",".aisle-dropdown-ul-9"];
    var b = [".up-1",".up-2",".up-3",".up-4",".up-5",".up-6",".up-7",".up-8",".up-9"];
    var c = ["#aisle-list-1","#aisle-list-2","#aisle-list-3","#aisle-list-4","#aisle-list-5","#aisle-list-6","#aisle-list-7","#aisle-list-8","#aisle-list-9"];
    
    
    for(let i=0; i < 9; i++){     
      $(c[i]).mouseover(
        function(e){
            $(a[i]).addClass('show-mini');
            $(b[i]).addClass('show-mini');

        }
      );

      $(c[i]).parent().mouseleave(
        function(e){
            $(a[i]).stop(true, true).removeClass('show-mini');
            $(b[i]).stop(true, true).removeClass('show-mini');   

        }
      );
    }
    // hide some divs when click on window
    var actionwindowclick = function(e){
        if (!$(".mini-cart, #cart-button").is(e.target) // if the target of the click isn't the container...
            && $(".mini-cart, #cart-button").has(e.target).length === 0) // ... nor a descendant of the container
        {
            
            $(".mini-cart").removeClass('show-mini');

            
            $(".mini-up-1").removeClass('show-mini');
        }
        if (!$(".mini_profile, #profile_button").is(e.target) // if the target of the click isn't the container...
            && $(".mini_profile, #profile_button").has(e.target).length === 0) // ... nor a descendant of the container
        {
            
            $(".mini_profile").removeClass('show-mini');

            
            $(".profile-mini-up-1").removeClass('show-mini');
        }
    }

    $(window).on('click',function(e){
    actionwindowclick (e);
    });



    $('#cart-button').click(function(e){
        $('.mini-cart').toggleClass('show-mini');
        $('.mini-up-1').toggleClass('show-mini');
        // $('.margin_left_auto').load(window.location.href + " .margin_left_auto" );
    });

    $('#profile_button').click(function(e){
        $('.mini_profile').toggleClass('show-mini');
        $('.profile-mini-up-1').toggleClass('show-mini');
        // $('.margin_left_auto').load(window.location.href + " .margin_left_auto" );
    });

    




    //Product Page-------------------------------------------------------------------------
    $(".thumbnails").children(":first").addClass('selected');

    var $first = $('.selected').data('big');
    $('.primary').css("background-image","url(" + $first + ")");


    $('.thumbnail').on('click', function() {
        var clicked = $(this);
        var newSelection = clicked.data('big');
        var $img = $('.primary').css("background-image","url(" + newSelection + ")");
        clicked.parent().find('.thumbnail').removeClass('selected');
        clicked.addClass('selected');
        $('.primary').empty().append($img.hide().fadeIn());
    });

    $('.add-cart').on('click', function() {
        $(this).closest('.prd-wrapper').find(".add-cart").addClass('clicked');
        $(this).closest('.prd-wrapper').find(".add-cart").attr('disabled','disabled');
        // $('.add-cart').addClass('clicked');
    })
  

    //product Page Functions---------------------------------------------------------
    var optionSelected = $("option:selected", '#product-page-size');
    var price = optionSelected.data("attr-price");
    var msrp = optionSelected.data("attr-msrp");
    var attrId = optionSelected.data("attr-id");
    
    $('#cart_attr_id').val(attrId);
    $('#product-page-price').html("$"+price);

    if(msrp !=='' ){
        $('#msrp').html("$"+msrp);
    }else{
        $('#msrp').html('');
    }

    $('#product-page-size').on('change', function (e) {
        optionSelected = $("option:selected", this);
        price = optionSelected.data("attr-price");
        msrp = optionSelected.data("attr-msrp");
        attrId = optionSelected.data("attr-id");

        $('#cart_attr_id').val(attrId);
        $('#product-page-price').html("$"+price);
        if(msrp !=='' ){
            $('#msrp').html("$"+msrp);
        }
        else{
            $('#msrp').html('');
        }
        alert('Product '+result.msg);
    });


    //cart-page functions----------------------

    $('.cart-page-size').on('change', function (e) {

        optionSelectedC = $(this).closest('.size').find("option:selected");
        var priceC = optionSelectedC.data('attr-price');
        var msrpC = optionSelectedC.data('attr-msrp');
        // var itemId = optionSelectedC.data('item-id');
        // $(this).closest('tr').find("#product_id").val(itemId);

        var attrId = optionSelectedC.data('attr-id');
        $(this).closest('tr').find("#attr_id").val(attrId);

        $(this).closest('.product-desc').find(".priceC").html("$"+priceC);
        

        if(msrpC !=='' ){
            $(this).closest('.product-desc').find(".disc").html("$"+msrpC);
        }else{
            $(this).closest('.product-desc').find(".disc").html('');
        }
    });

    $('#update').on('click', function(e) {
        $.ajax({
              url:"/update_cart",
              data: $('.update').serialize(),
              type:'post',
              success:function(result){
                location.reload();
              }
           });
      });
      
    //   $(document).on('click','.remove-item', function(e) {
    //         // $('.mini-cart').load();
    //         // location.reload();
    //         // document.getElementById("youriframeid").contentWindow.location.reload(true);
    //         // $(".mini-cart").html(htmlData);
    //     });
    //   $('.remove-item').on('click', function(e) {
    //     var cartId=$(this).data('item-id');
    //     var element=$(this).closest('tr');
    //     var miniCart=$('.header-mobile-inner');
    //     var X_CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
    //     $.ajax({
    //           url:"/delete_cart_item",
    //           data: { _token: X_CSRF_TOKEN, cartId: cartId},
    //           type:'post',
    //           success:function(){
    //             $(element).remove();
    //             $(miniCart).load();
    //             // $(miniCart).load(window.location.href + miniCart );
    //           }
    //        });
    //   });




    // quantity increment
    $('.btn-number').click(function(e){
      
        e.preventDefault();
      
      fieldName = $(this).attr('data-field');
      type      = $(this).attr('data-type');
      var input = $("input[name='"+fieldName+"']");
      var currentVal = parseInt(input.val());
      if (!isNaN(currentVal)) {
          if(type == 'minus') {
              
              if(currentVal > input.attr('min')) {
                  input.val(currentVal - 1).change();
              } 
              if(parseInt(input.val()) == input.attr('min')) {
                  $(this).attr('disabled', true);
              }

          } else if(type == 'plus') {

              if(currentVal < input.attr('max')) {
                  input.val(currentVal + 1).change();
              }
              if(parseInt(input.val()) == input.attr('max')) {
                  $(this).attr('disabled', true);
              }

          }
      } else {
          input.val(0);
      }
   });
  $('.input-number').focusin(function(){
    $(this).data('oldValue', $(this).val());
  });
  $('.input-number').change(function() {
      
      minValue =  parseInt($(this).attr('min'));
      maxValue =  parseInt($(this).attr('max'));
      valueCurrent = parseInt($(this).val());
      
      name = $(this).attr('name');
      if(valueCurrent >= minValue) {
          $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
      } else {
          alert('Sorry, the minimum value was reached');
          $(this).val($(this).data('oldValue'));
      }
      if(valueCurrent <= maxValue) {
          $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
      } else {
          alert('Sorry, the maximum value was reached');
          $(this).val($(this).data('oldValue'));
      }
      
      $(this).closest('tr').find("#product_qty").val(valueCurrent);
  });
  $(".input-number").keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
              // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
              // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
                  // let it happen, don't do anything
                  return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      });



    //   $('#prd_addtoCart').on('click', function() {
        
        
    // })

      $("#prd_addtoCart").on('click',function (e) {
        e.preventDefault();
        
        $('#prd_addtoCart').addClass('clicked');
        setTimeout(function() {
          
        var qty =$('#cart_product_qty').val();
        $("#cart_qty").val(qty);
        $.ajax({
            url:'/add_to_cart',
            data: $('#frmAddToCart').serialize(),
            type:'post',
            enctype: 'mutipart/form-data',
            success:function(result){
                location.reload();
            }

        });
        $('#prd_addtoCart').attr('disabled','disabled');
    }, 1000);
        
    });
    

    // $(document).on("click", ".add-cart", function(e){
    //     e.preventDefault();
    //     var id = $(this).data('prd-id');
    //     var attr_id = $(this).data('prdattr-id');
    //     var token= $('#token').val()
    //     var qty= 1;
    //     // $("#hCart_product_id").val(id);
    //     // $("#hCart_attr_id").val(attr_id);

    //     $.ajax({
    //         url:'/add_to_cart',
    //         data: {id: id, attr_id: attr_id, qty: qty, "_token": token},
    //         type:'post',
    //         success:function(result){
    //             $(this).css("background-color", "blue");
    //         }
    //      });
    // });


    // product listing page-------------------------------------------------------------------------------------------------


    $('#sortBy').on('change', function(e) {
        optionSelected = $("option:selected", this);
        sortBy = optionSelected.val();

        $('#sort').val(sortBy);
        $('#categoryFilter').submit();
    })


    
    $('#search_btn_desk').on('click', function(){
        var q=$('#search_input_desk').val();
        if (q !=="") {
            $('#search_desk').submit();
        }
    });

    $('#search_btn_mobile').on('click', function(){
        var q=$('#search_input_mobile').val();
        if (q !=="") {
            $('#search_mobile').submit();
        }
    });


    // Registration Page----------------------------------------------------------------


    $('#regForm').submit(function(e) {
        e.preventDefault();
        $('#firstName').text('');
        $('#lastName').text('');
        $('#emailError').text('');
        $('#password').text('');
        $.ajax({
            url:'/registration_process',
            data: $('#regForm').serialize(),
            type:'post',
            success:function(response){
                window.location.href='/';
            },
            error:function (response) {
                $('#firstName').text(response.responseJSON.errors.firstName);
                $('#lastName').text(response.responseJSON.errors.lastName);
                $('#emailError').text(response.responseJSON.errors.email);
                $('#password').text(response.responseJSON.errors.password);
            }

        });

    });


    $('#login_frm').submit(function(e) {
        e.preventDefault();
        $('#incorrect').text("");
        $('#login_gif').show();
        $('#login_gif').css('visibility','visible');
        $.ajax({
            url:'/login_process',
            data: $('#login_frm').serialize(),
            type:'post',
            success:function(result){   
                if (result.status=="success") {
                    // window.location.href='/';
                    window.location.href=window.location.href;
                }
                if (result.status=="error") {
                    $('#login_gif').css('visibility','hidden');
                    $('#incorrect').text(result.error);

                }
                
            },
            error:function (response) {
                console.log(response.responseJSON.message);

                $('#incorrect').text("Too Many failed Attempts! &lt;br&gt; Please Try Again In 5 Minutes \n");

                // $('#update_firstName').text(response.responseJSON.errors.firstName);
                // $('#update_lastName').text(response.responseJSON.errors.lastName);
                // $('#update_emailError').text(response.responseJSON.errors.email);
                // $('#password').text(response.responseJSON.errors.currentPassword);
                // $('#newPasswordError').text(response.responseJSON.errors.newPassword);
                // $('#confirmPasswordError').text(response.responseJSON.errors.confirmPassword);
            }

        });

    });

    $('#reset_frm').submit(function(e) {
        e.preventDefault();
        $('#resetMsg').text('');
        $('#gif').show();
        $('#gif').css('visibility','visible');
        $.ajax({
            url:'/forgot_password',
            data: $('#reset_frm').serialize(),
            type:'post',
            success:function(response){  
                if (response.status=='found') {
                    $('#gif').css('visibility','hidden');
                    $('#resetMsg').text(response.msg);
                }if (response.status=='not found'){
                    $('#gif').css('visibility','hidden');
                    $('#resetMsg').text(response.msg);
                }
                // if (result.status=="success") {
                //     window.location.href='/';
                // }
                // if (result.status=="error") {
                //     $('#incorrect').text(result.error);
                // }
            }

        });

    });


    $('#forgotPassword').on('click', function(e) {
        e.preventDefault();
        $('.login_form').hide();
        $('.forgotPassword').show();

    });

    $('#loginInstead').on('click', function(e) {
        e.preventDefault();
        $('.forgotPassword').hide();
        $('.login_form').show();

    });


    $('#confirm_password').on('keyup', function () {
        if ($('#confirm_password').val() == $('#new_password').val()) {
        $('#mismatch').html('Matching').css('color', 'green');
        } else 
        $('#mismatch').html('Not Matching').css('color', 'red');
    });

    $('#change_password').submit(function(e) {

    if ($('#mismatch').html()=='Matching') {        
        e.preventDefault();
        $.ajax({
            url:'/reset_password_process',
            data: $('#change_password').serialize(),
            type:'post',
            success:function(response){  
                
                $('#mismatch').removeClass('text-danger');
                $('#mismatch').addClass('alert alert-success');
                $('#mismatch').text(response.msg);


                setTimeout(function() {
                    window.location.href = "/";
                }, 4000);
            }

        });
    }
        

    });



    // Change Account info Page_________________________________________

    // $('#confirmPassword').on('keyup', function () {
    //     // $('#update_account').attr('disabled','disabled');
    //     if ($('#confirmPassword').val() == $('#newPassword').val()) {
    //     $('#pass_mismatch').html('Matching').css('color', 'green');
    //     // $('#update_account').removeAttr('disabled');
    //     } else 
    //     $('#pass_mismatch').html('Not Matching').css('color', 'red');
        
    // });

    

    // $('#change_password').submit(function(e) {

    // if ($('#mismatch').html()=='Matching') {        
    //     e.preventDefault();
    //     $.ajax({
    //         url:'/reset_password_process',
    //         data: $('#change_password').serialize(),
    //         type:'post',
    //         success:function(response){  
                
    //             $('#mismatch').removeClass('text-danger');
    //             $('#mismatch').addClass('alert alert-success');
    //             $('#mismatch').text(response.msg);


    //             setTimeout(function() {
    //                 window.location.href = "/";
    //             }, 4000);
    //         }

    //     });
    // }
        

    // });


    $('#update_account').submit(function(e) {
        e.preventDefault();
        $('#update_firstName').text('');
        $('#update_lastName').text('');
        $('#update_emailError').text('');
        $('#password').text('');
        $('#newPassword').text('');
        $('#confirmPassword').text('');
        $("#danger-alert").addClass('d-none');
        $("#success-alert").addClass('d-none');
        $.ajax({
            url:'/my_account/update_account',
            data: $('#update_account').serialize(),
            type:'post',
            success:function(response){
                if(response.status ==='success') {
                    $('#success-alert').text(response.msg);
                    $("#success-alert").removeClass('d-none');
                    setTimeout(function() {
                        window.location.href="/";
                    }, 2000);
                }
                if(response.status ==='error') {
                    $('#danger-alert').text(response.msg);
                    $("#danger-alert").removeClass('d-none');
                }
                
            },
            error:function (response) {
                // console.log(response.responseJSON);
                $('#update_firstName').text(response.responseJSON.errors.firstName);
                $('#update_lastName').text(response.responseJSON.errors.lastName);
                $('#update_emailError').text(response.responseJSON.errors.email);
                $('#password').text(response.responseJSON.errors.currentPassword);
                $('#newPasswordError').text(response.responseJSON.errors.newPassword);
                $('#confirmPasswordError').text(response.responseJSON.errors.confirmPassword);
            }
    
        });
    
    });


      
});


// function hAddToCart(id,attr_id){
//     $("#hCart_product_id").val(id);
//     $("#hCart_attr_id").val(attr_id);
    
//     $.ajax({
//          url:'/add_to_cart',
//          data: $('#hFrmAddToCart').serialize(),
//          type:'post',
//          success:function(result){
//             alert('Product '+result.msg);
//          }

//       });
// }

function show_password() {
    if($('#confirmPassword').attr('type')==='text') {
        $('#confirmPassword').attr('type', 'password')
        $('#newPassword').attr('type', 'password')
    } else {
        $('#confirmPassword').attr('type', 'text')
        $('#newPassword').attr('type', 'text')
    }
  }

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