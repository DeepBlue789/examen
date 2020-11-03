<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "sk_test_oXr346WK2VnMnEjzZ8xwKejZ00rtfmNwTb",
  "publishable_key" => "pk_test_ghI6q1VZLcZrvQ6ke1LDi91h00mlL3RFQP",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>