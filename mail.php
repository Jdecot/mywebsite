<?php
    $to = 'jdecotpro@gmail.com';
    $firstname = $_POST["firstname"];
    $email= $_POST["email"];
    $message= $_POST["message"];
    $subject= $_POST["subject"];
    


    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= "From: " . $email . "\r\n"; // Sender's E-mail
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $subject= 'Mywebsite : '.$subject;
    $message ='<table style="width:100%">
        <tr>
            <td>'.$firstname.'</td>
        </tr>
        <tr><td>Email: '.$email.'</td></tr>
        <tr><td>subject: '.$subject.'</td></tr>
        <tr><td>Text: '.$message.'</td></tr>
        
    </table>';
    if (@mail($to, $subject, $message, $headers))
    {
        echo 'The message has been sent.';
    }else{
        echo 'failed';
    }

?>
