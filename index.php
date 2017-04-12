<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

// Domain list to monitor
$domains = [
    'domain' => ['due_date' => 'dd/mm/yyyy'],
    'domain2' => ['due_date' => 'dd/mm/yyyy'],
    'domain3' => ['due_date' => 'dd/mm/yyyy']
];

// set email admin
$email = 'admin@admin.com';

// set today date based on timezone
$today = Carbon::now('Asia/Kuala_Lumpur');

echo '<h1>Report as of ' . $today ;

foreach ($domains as $key => $value) {
    $due_date = Carbon::createFromFormat('d/m/Y', $value['due_date']);
    $message = "<p>" . $key . ' will expired in ' . $today->diffInDays($due_date) . " day(s) on " . $value['due_date'] . "</p>";
    if($today->diffInDays($due_date) < 10) {
        emailTo($email, $key, $message);
    }
    echo $message;
}


echo '<h3>End of report.</h3>';

function emailTo ($email, $domain, $message) {
    $to = $email;
    $subject = 'SSL Certificate Expiring - ' . $domain;
    $headers = "MIME-Version: 1.0\r\n" . 
    "Content-type: text/html; charset=iso-8859-1\r\n" . 
    'From: no-reply@admin.com';
    
    mail($to, $subject, $message, $headers);
}