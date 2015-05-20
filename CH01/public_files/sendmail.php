<?php  
$now = date("Y-m-d h:i:s");  
$headers = 'From: name<luwenjie110@163.com>';  
$body = "hi, this is a test mail.\nMy email: luwenjie110@163.com";  
$subject = "test mail";  
$to = "269811553@qq.com";  
if (mail($to, $subject, $body, $headers))  
{  
echo 'success!';  
}   
else   
{  
echo 'fail';  
}  
