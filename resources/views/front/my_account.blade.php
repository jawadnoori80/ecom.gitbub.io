{{-- Account Information --}}
{{-- Password Change for logged in users --}}

@extends('front.layout')
@section('page_title','My Account')
@section('container')
{{-- @php
    prx($user)
@endphp --}}
<div class="container py-2">
    <div class="update_account">
        <h3 class="orange">My Account</h3>
        {{-- <h6>Please fill in the information below</h6> --}}
        <form id="update_account" action="">
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
            <div style="display: flex; align-items:center;">
                <input type="checkbox" onclick="show_password()">&nbsp;&nbsp;<span> Show Password</span>
            </div>
            <button type="submit" id="regBtn" class="login-btn">Save Changes</button>
        </form>
        <div id="success-alert" class="d-none alert alert-success"></div>
        <div id="danger-alert" class="d-none alert alert-danger"></div>
    </div>
</div>

@endsection
