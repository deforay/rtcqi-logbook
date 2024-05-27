<h1>Reset Password</h1>
   
You or someone using your login id, requested for password reset on <span style='font-weight:bold;'>{{env('APP_URL')}}</span>.
<div style="margin-top:10px;">
    Please click the link or copy and paste in the browser
</div>
<div style="margin-top:10px; margin-bottom:30px">
    <a href="{{ env("APP_URL").'/reset-password/'.$token }}">{{ env("APP_URL").'/reset-password/'.$token }}</a>
</div>
<hr/>
<div style="margin-top:10px;">
    Please note this is a system generated email
</div>
