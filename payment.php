<?php
require 'vendor/autoload.php'; // Include Stripe PHP SDK
require 'resources/config.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY); // Your secret key

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);

// Extract data
$token = $input['stripeToken'];
$amount = $input['amount'];
$user = $input['user'];

try {
    // Create charge
    $charge = \Stripe\Charge::create([
        "amount" => $amount, // Amount in cents
        "currency" => "usd",
        "source" => $token,
        "description" => "Payment by " . $user['name'],
        "receipt_email" => $user['email'],
        "shipping" => [
            "name" => $user['name'],
            "address" => [
                "line1" => $user['address'],
                "city" => $user['city'],
                "postal_code" => $user['post_code'],
                "country" => "GB"
            ]
        ]
    ]);

    echo json_encode(["status" => "success", "charge_id" => $charge->id]);

} catch (\Stripe\Exception\CardException $e) {
    echo json_encode(["status" => "error", "message" => $e->getError()->message]);
}
?>
