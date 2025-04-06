<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .payment-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        #stripe-button {
            background-color: #6772e5;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        #stripe-button:hover {
            background-color: #5469d4;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Complete Your Payment</h1>
        <p>Please fill in all the necessary details to proceed with the payment.</p>
        <button id="stripe-button">Pay with Stripe</button>
    </div>

    <script type="text/javascript">
        var stripe = Stripe('pk_test_51R9OKPQTxFpWivLcO8uXr6S3R2b3vERfvwNWzelbRgd7aUCZzQBSWvokwFSfmWoRqEtNNvMJWABX86YiohBL2YJV00uDvKVLku');

        var stripeButton = document.getElementById('stripe-button');

        stripeButton.addEventListener('click', function () {
            fetch('/Ai_driven_ecommerce/stripe_payment.php', {
                method: 'POST',
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (sessionId) {
                return stripe.redirectToCheckout({ sessionId: sessionId.id });
            })
            .then(function (result) {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
        });
    </script></body>
</html>
