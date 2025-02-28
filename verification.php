<?php

require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51QxNVABM0cOMPXGcPSRCELFFWtZmHIzodcoGtyaKK9mvlB0KEbgcniQIoll8uqJ70vqcKQ2E3Ne8zQiMnDNQSW9O00bVFtGruM');  // Replace with your secret key

// Function to get payment details by charge ID
function getPaymentDetails($chargeId) {
    try {
        // Retrieve the charge object from Stripe using the charge ID
        $charge = \Stripe\Charge::retrieve($chargeId);
        
        // Check if the payment was successful
        if ($charge->status == 'succeeded') {
            // Create an object or array with payment details
            $paymentDetails = new stdClass();
            $paymentDetails->status = ucfirst($charge->status);
            $paymentDetails->transactionId = $charge->id;
            $paymentDetails->amountPaid = number_format($charge->amount / 100, 2);
            $paymentDetails->currency = strtoupper($charge->currency);
            $paymentDetails->paymentMethod = ucfirst($charge->payment_method_details->type);
            $paymentDetails->receiptUrl = $charge->receipt_url;

            // Optionally, add more details to the object
            $paymentDetails->customerName = $charge->billing_details->name ?? null;
            $paymentDetails->customerEmail = $charge->billing_details->email ?? null;

            return $paymentDetails;  // Return the object with payment details
        } else {
            // If payment is not successful, return an error status object
            return (object) [
                'status' => ucfirst($charge->status),
                'error' => 'Payment failed.'
            ];
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle error (e.g., invalid charge ID)
        return (object) [
            'status' => 'Error',
            'error' => $e->getMessage()
        ];
    }
}
