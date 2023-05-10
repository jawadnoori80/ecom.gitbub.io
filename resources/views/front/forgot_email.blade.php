<style>
    p{
         font-size: 18px;
    }
</style>

<div style="font-size: 18px;">
<h1>Hello {{$name}},</h1>
<p>A request to reset your password for your SOHRAB FOODS & SPICES 
account was lodged from our website. To reset your password, click the button below.</p>

<button style="display: block; background-color: #ff7a00; text-align:center; padding:5px 20px; color:white; border:none" type="button"><a style="color:white; text-decoration:none; font-size: 18px;" href="{{url('/reset_password')}}/{{$rand_id}}">Reset Password</a></button>
<br><br>
<p>If you did not request this password reset, please disregard this message and your password will remain unchanged.</p>
<p style="font-size: 18px">Sincerely,<br>
    Your friends at AJ Foods & Spices</p>
</div>