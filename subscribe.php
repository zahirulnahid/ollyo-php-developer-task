
<?php
require 'vendor/autoload.php'; // Load Stripe PHP SDK
require 'resources/config.php';
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY); // Replace with your Stripe Secret Key

$input = json_decode(file_get_contents("php://input"), true);
$token = $input['stripeToken'] ?? null;
$email = $input['email'] ?? null;
$plan = $input['plan'] ?? null; // Get the selected plan

if (!$token || !$email || !$plan) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

try {
    // Create a new customer
    $customer = \Stripe\Customer::create([
        "email" => $email,
        "source" => $token
    ]);

    // Subscribe the customer to the selected plan
    $subscription = \Stripe\Subscription::create([
        "customer" => $customer->id,
        "items" => [["plan" => $plan]] // Plan ID from dropdown
    ]);

    echo json_encode(["status" => "success", "message" => "Subscription successful", "subscription_id" => $subscription->id]);

} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
