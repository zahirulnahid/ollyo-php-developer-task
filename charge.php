<?php
require_once 'vendor/autoload.php';
require 'resources/config.php';
\Stripe\Stripe::setApiKey('STRIPE_SECRET_KEY');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['stripeToken'];
    $amount = 1000; // Amount in cents

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
        ]);

        echo 'Payment successful! Charge ID: ' . $charge->id;
    } catch (\Stripe\Exception\CardException $e) {
        // Since it's a decline, \Stripe\Exception\CardException will be caught
        echo 'Status is:' . $e->getHttpStatus() . '\n';
        echo 'Type is:' . $e->getError()->type . '\n';
        echo 'Code is:' . $e->getError()->code . '\n';
        echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\RateLimitException $e) {
        // Too many requests made to the API too quickly
        echo 'Rate limit error: ' . $e->getMessage();
    } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Invalid parameters were supplied to Stripe's API
        echo 'Invalid request error: ' . $e->getMessage();
    } catch (\Stripe\Exception\AuthenticationException $e) {
        // Authentication with Stripe's API failed
        echo 'Authentication error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiConnectionException $e) {
        // Network communication with Stripe failed
        echo 'Network error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Display a very generic error to the user
        echo 'Stripe error: ' . $e->getMessage();
    } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        echo 'Error: ' . $e->getMessage();
    }
}
?>