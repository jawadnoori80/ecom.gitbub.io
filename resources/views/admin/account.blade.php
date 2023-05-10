@extends('admin.layout')
@section('page_title','Account')
@section('container')

@if(session('message'))
    <div class="alert alert-success" role="alert">
        {{session('message')}}
    </div>
@endif


<div class="m-t-10">
    <div class="">
        <div class="container py-2">
            <div class="update_account">
                <h3 class="orange">My Account</h3>
                {{-- <h6>Please fill in the information below</h6> --}}
                <form id="update_account" action="" >
                    <div class="form-floating">
                        <input type="text" class="form-control" id="update_F_name" name="firstName" placeholder="First Name" value="{{$user['firstName']}}">
                        <label for="update_F_name">First Name</label>
                    </div>
                    <span class="text-danger" id="update_firstName"></span>
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="update_L_name" name="lastName" placeholder="Last Name" value="{{$user['lastName']}}">
                        <label for="L_name">Last Name</label>
                    </div>
                    <span class="text-danger" id="update_lastName"></span>
                    <div class="form-floating mt-3">
                        <input type="email" class="form-control" id="update_email" name="email" placeholder="name@example.com" value="{{$user['email']}}">
                        <label for="update_email">Email address</label>
                    </div>
                    <span class="text-danger" id="update_emailError"></span>
        
                    <div class="dash_div"><span class="dash_span">PASSWORD CHANGE</span></div>
                    
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password">
                        <label for="currentPassword">Current Password</label>
                    </div>
                    <span class="text-danger" id="password"></span>
        
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password">
                        <label for="regPassword">New Password</label>
                    </div>
                    <span class="text-danger" id="newPasswordError"></span>
        
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password">
                        <label for="regPassword">Confirm New Password</label>
                    </div>
                    <span class="text-danger" id="confirmPasswordError"></span>
                    @csrf
                    <button type="submit" id="regBtn" class="login-btn">Save Changes</button>
                </form>
                <div id="success-alert" class="d-none alert alert-success"></div>
                <div id="danger-alert" class="d-none alert alert-danger"></div>
            </div>
        </div>
        
    </div>
</div>

<script>
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
            url:'   account/update_account',
            data: $('#update_account').serialize(),
            type:'post',
            success:function(response){
                if(response.status ==='success') {
                    $('#success-alert').text(response.msg);
                    $("#success-alert").removeClass('d-none');
                    setTimeout(function() {
                        window.location.href="/admin";
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
</script>
@endsection
