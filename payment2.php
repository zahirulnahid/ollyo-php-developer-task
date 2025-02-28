<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        #card-element { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Stripe Payment</h2>
    <form id="payment-form">
        <div id="card-element"></div>
        <button type="submit">Pay Now</button>
    </form>
    <div id="payment-message"></div>

    <script>
        var stripe = Stripe("pk_test_51QxNVABM0cOMPXGcDLAzXfjD2X6KdmiKlF3NA4ppefBXh5spMc0RNIxCbFzqiS18r2jsRAMwIzRxt4xM9ONj0mgw001gHTFEJV");
        var elements = stripe.elements();
        var card = elements.create("card");
        card.mount("#card-element");

        var form = document.getElementById("payment-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    document.getElementById("payment-message").innerText = result.error.message;
                } else {
                    fetch("payment.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "stripeToken=" + result.token.id
                    })
                    .then(response => response.text())
                    .then(data => document.getElementById("payment-message").innerText = data);
                }
            });
        });
    </script>
</body>
</html>
