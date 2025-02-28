<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./resources/css/style.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-md rounded-lg p-6 w-96">
        <h1 class="text-2xl font-bold text-center text-gray-700 mb-4">Stripe Payment</h1>
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Total Bill <?php echo "$ ". ($_POST['total']/100)." USDT";?></h2>
        
        <form id="payment-form" class="space-y-4">
            <div id="card-element" class="border border-gray-300 rounded p-3"></div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pay Now</button>
        </form>
        <div id="payment-message" class="mt-4 text-center text-red-500"></div>
    </div>
    
    <script>
    var stripe = Stripe("pk_test_51QxNVABM0cOMPXGcDLAzXfjD2X6KdmiKlF3NA4ppefBXh5spMc0RNIxCbFzqiS18r2jsRAMwIzRxt4xM9ONj0mgw001gHTFEJV");
    var elements = stripe.elements();
    var card = elements.create("card");
    card.mount("#card-element");

    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        // Get user details (You can fetch this dynamically from inputs if needed)
        var amount = <?php echo $_POST['total']?>; // Example: 5000 cents ($50.00)
        var userData = {
            name: "<?php echo $_POST['name']?>",
            email: "<?php echo $_POST['email']?>",
            address: "<?php echo $_POST['address']?>",
            city: "<?php echo $_POST['city']?>",
            post_code: "<?php echo $_POST['post_code']?>"
        };



        
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                document.getElementById("payment-message").innerText = result.error.message;
            } else {
                fetch("payment.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        stripeToken: result.token.id,
                        amount: amount,
                        user: userData
                    })
                })
                .then(response => response.json()) // Expecting a JSON response
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = "success?charge_id="+data.charge_id; // Redirect on success
                    } else {
                        window.location.href = "failure"; // Redirect on failure
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    document.getElementById("payment-message").innerText = "An error occurred. Please try again.";
                });
            }
        });
    });
</script>


</body>
</html>
