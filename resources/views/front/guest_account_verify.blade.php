<style>
     p, td{
          font-size: 18px;
     }
</style>
<h1>Hello {{$name}},</h1>
<p style="font-size: 18px">Thank you for choosing us!<br>
We will ship your order as soon as possible. You can track your order on our website through your account.<br>
This is your username and system-generated password:</p>
<table style="font-size:18px;">
    <tr>
         <td>Username:</td>
         <td><b>&#40;{{$email}}&#41;<b></td>
    </tr>           
    <tr>
         <td>Password:</td>
         <td><b>{{$rand_pass}}</b></td>
    </tr>
</table>
<p style="font-size: 18px"><a href="{{url('/verification')}}/{{$rand_id}}">Click here </a>to verify your email.</p>
<p style="font-size: 18px">We look forward to seeing you around again soon.</p>
<p style="font-size: 18px">Sincerely,<br>
Your friends at AJ Foods & Spices</p>