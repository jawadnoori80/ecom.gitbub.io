{{-- Change Password for users who forgot theirs --}}


@extends('front.layout')
@section('page_title','Change Password')
@section('container')
<div class="container">
    <br><br><br><br>
<div style="width:350px; margin-inline: auto; text-align:center">
    <h6>Enter your new password:</h6>
        <form id="change_password" method="POST">
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password">
                <label for="new_password">New Password</label>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Password">
                <label for="new_password">Confirm Password</label>
            </div>
              @csrf
            <span class="text-danger" id="mismatch"></span>
            <button type="submit" class="resetPassword">Reset Password</button>
            
                {{-- <label for="">Email address</label>
                <input type="email" class="form-control" placeholder="name@example.com">
                <br>
                <label for="">Password</label>
                <input type="password" class="form-control" placeholder="Password"> --}}

        </form>

    </div> 
    <br><br><br><br>
</div>
@endsection