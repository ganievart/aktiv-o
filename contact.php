<?php

// configure
$from = 'aktiv-o.ru';
$sendTo = 'info@aktiv-o.ru';
$subject = 'Письмо с сайта aktiv-o.ru';
$fields = array('name' => 'Name', 'phone' => 'Phone','message' => 'Message'); // array variable name => Text to appear in email
$okMessage = 'Письмо успешно отправлено!';
$errorMessage = 'Возникла ошибка! Попробуйте позже';

// let's do the sending

try
{
    $emailText = "You have new message from contact form\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
