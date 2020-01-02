<?php 
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "leif@lindercreative.com";
    //$to = "web-zs459@mail-tester.com";
    //$to = "st-3-ckbc0be5xa@glockapps.com";
    $to = "leif@leiflinder.com";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "Try again";
?>