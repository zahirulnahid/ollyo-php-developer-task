<?php

use Ollyo\Task\Routes;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helper.php';

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', baseUrl());

$products = [
    [
        'name' => 'Minimalist Leather Backpack',
        'image' => BASE_URL . '/resources/images/backpack.webp',
        'qty' => 1,
        'price' => 120,
    ],
    [
        'name' => 'Wireless Noise-Canceling Headphones',
        'image' => BASE_URL . '/resources/images/headphone.jpg',
        'qty' => 1,
        'price' => 250,
    ],
    [
        'name' => 'Smart Fitness Watch',
        'image' => BASE_URL . '/resources/images/watch.webp', 
        'qty' => 1,
        'price' => 199,
    ],
    [
        'name' => 'Portable Bluetooth Speaker',
        'image' => BASE_URL . '/resources/images/speaker.webp',
        'qty' => 1,
        'price' => 89,
    ],
];
$shippingCost = 10;

$data = [
    'products' => $products,
    'shipping_cost' => $shippingCost,
    'address' => [
        'name' => 'Sherlock Holmes',
        'email' => 'sherlock@example.com',
        'address' => '221B Baker Street, London, England',
        'city' => 'London',
        'post_code' => 'NW16XE',
    ]
];
$URL = $_GET['url']??'app';
$URL = explode("/",$URL);

if($URL[0]=='app')
return view('app', []);
// Routes::get('/', function () {
//     return view('app', []);
// });
if ($URL[0] == 'checkout') {
    if (isset($_POST['email'])) {
        return view('confirmation', $data);
    } else {
        return view('checkout', $data);
    }
}
if($URL[0]=='success')
return view('success', $data);//passing data for validating
if($URL[0]=='failure')
return view('failure', []);
if($URL[0]=='subscription')
return view('subscription', $data);
Routes::post('/checkout', function ($request) {
    echo "hi";
    // @todo: Implement PayPal payment gateway integration here
    // 1. Initialize PayPal API client with credentials
    // 2. Create payment with order details from $data
    // 3. Execute payment and handle response
    // 4. If payment successful, save order and redirect to thank you page
    // 5. If payment fails, redirect to error payment page with message

    // Consider creating a dedicated controller class to handle payment processing
    // This helps separate payment logic from routing and keeps code organized
});

// Register thank you & payment failed routes with corresponding views here.

// Create a singleton instance of Routes and dispatch requests
$route = Routes::getInstance();
$route->dispatch();


?>
