
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Subscription</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 400px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        #card-element { padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #008CBA; color: white; padding: 10px; border: none; cursor: pointer; }
        button:disabled { background: gray; }
    </style>
</head>
<body>

<div class="container">
    <h2>Subscribe to a Plan</h2>
    <form id="subscription-form">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" id="email" value='<?php echo $data['address']['email']?>' required>
        </div>
        
        <div class="form-group">
            <label>Select Plan:</label>
            <select id="plan">
                <option value="plan_monthly">Monthly ($10/month)</option>
                <option value="plan_yearly">Yearly ($100/year)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Card Details:</label>
            <div id="card-element"></div>
        </div>
        <button type="submit" id="subscribe-btn">Subscribe</button>
    </form>
    <p id="status-message"></p>
</div>

<script>
    const stripe = Stripe("pk_test_51QxNVABM0cOMPXGcDLAzXfjD2X6KdmiKlF3NA4ppefBXh5spMc0RNIxCbFzqiS18r2jsRAMwIzRxt4xM9ONj0mgw001gHTFEJV");  // Replace with your Stripe Publishable Key
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    document.getElementById("subscription-form").addEventListener("submit", async (e) => {
        e.preventDefault();
        document.getElementById("subscribe-btn").disabled = true;

        const { token, error } = await stripe.createToken(card);
        if (error) {
            document.getElementById("status-message").textContent = error.message;
            document.getElementById("subscribe-btn").disabled = false;
        } else {
            fetch("subscribe.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    stripeToken: token.id,
                    email: document.getElementById("email").value,
                    plan: document.getElementById("plan").value
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("status-message").textContent = data.message;
                document.getElementById("subscribe-btn").disabled = false;
            });
        }
    });
</script>

</body>
</html>