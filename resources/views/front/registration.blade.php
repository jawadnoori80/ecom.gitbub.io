@extends('front.layout')
@section('page_title','Registration')
@section('container')
<div class="container py-2">
    <div class="registration">
        <h3 class="orange">Create My Account</h3>
        <h6>Please fill in the information below</h6>
        <form id="regForm" action="">
            <div class="form-floating">
                <input type="text" class="form-control" id="F_name" name="firstName" placeholder="First Name">
                <label for="F_name">First Name</label>
            </div>
            <span class="text-danger" id="firstName"></span>
            <div class="form-floating mt-3">
                <input type="text" class="form-control" id="L_name" name="lastName" placeholder="Last Name">
                <label for="L_name">Last Name</label>
            </div>
            <span class="text-danger" id="lastName"></span>
            <div class="form-floating mt-3">
                <input type="email" class="form-control" id="regEmail" name="email" placeholder="name@example.com">
                <label for="regEmail">Email address</label>
            </div>
            <span class="text-danger" id="emailError"></span>
            
            <div class="form-floating mt-3">
                <input type="password" class="form-control" id="regPassword" name="password" placeholder="Password">
                <label for="regPassword">Password</label>
            </div>
            <span class="text-danger" id="password"></span>
            @csrf
            <button type="submit" id="updateBtn" class="login-btn">Create My Account</button>
        </form>
    </div>
</div>

@endsection
