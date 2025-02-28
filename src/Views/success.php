<?php
require ('verification.php');
$chargeId = $_GET['charge_id'] ?? null;
$paymentDetails = getPaymentDetails($chargeId);

$subtotal = 10;
if (isset($data['products'])) {
    foreach ($data['products'] as $product) {
        $subtotal += $product['price'] * $product['qty'];
    }
}

if ($paymentDetails->amountPaid == $subtotal) {
    // Payment successful, continue processing
} else {
    header('Location: failure');
    exit(); // Ensure script execution stops after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-green-600">Order Confirmed!</h2>
        <p class="mt-2 text-gray-700">Your order has been placed successfully.</p>
        
        <div class="mt-4 p-4 bg-gray-50 rounded-md">
            <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
            <p class="text-sm text-gray-600">Transaction ID: <span class="font-medium text-gray-900"><?php echo $paymentDetails->transactionId ?></span></p>
            <p class="text-sm text-gray-600">Total Amount: <span class="font-medium text-gray-900">$<?php echo $paymentDetails->amountPaid ?></span></p>
            <p class="text-sm text-gray-600">Currency: <span class="font-medium text-gray-900"><?php echo $paymentDetails->currency ?></span></p>
            <p class="text-sm text-gray-600">Payment Method: <span class="font-medium text-gray-900"><?php echo $paymentDetails->paymentMethod ?></span></p>
        </div>

        <?php if ($paymentDetails->customerName || $paymentDetails->customerEmail): ?>
            <div class="mt-4 p-4 bg-gray-50 rounded-md">
                <h3 class="text-lg font-semibold text-gray-800">Customer Details</h3>
                <?php if ($paymentDetails->customerName): ?>
                    <p class="text-sm text-gray-600">Name: <span class="font-medium text-gray-900"><?php echo $paymentDetails->customerName ?></span></p>
                <?php endif; ?>
                <?php if ($paymentDetails->customerEmail): ?>
                    <p class="text-sm text-gray-600">Email: <span class="font-medium text-gray-900"><?php echo $paymentDetails->customerEmail ?></span></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <p class="mt-4 text-gray-700">Thank you for your purchase! 🎉</p>
        <a href="<?php echo $paymentDetails->receiptUrl?>" target='_blank' class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">
            Stripe Invoice
        </a><br>
        <a href="./" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            Continue Shopping
        </a>
    </div>

</body>
</html>
