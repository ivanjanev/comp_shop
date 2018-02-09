<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 10-Aug-17
 * Time: 15:57
 */
require_once('vendor/autoload.php');
$stripe = array(
    'secret_key'      => 'sk_test_a6NGVEaYRNBc7EtydKGRD7C8',
    'publishable_key' => 'pk_test_OUTSOD4dik3cfY2fWZffHfx7'
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>