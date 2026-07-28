<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Funds - Auto Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; display: flex; justify-content: center; }
        .container { background: #fff; width: 100%; max-width: 400px; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header-box { background: #e0f7fa; border: 2px dashed #00bcd4; border-radius: 10px; padding: 15px; text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .checkbox-group { display: flex; align-items: flex-start; gap: 8px; font-size: 12px; margin-bottom: 20px; }
        .btn-pay { width: 100%; background: #2196F3; color: white; border: none; padding: 12px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .btn-pay:hover { background: #0b7dda; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-box">
        <h3 style="margin-top:0; color:#00695c;">Instant Add Fund</h3>
        <p style="margin:0; font-size:13px; color:#004d40;">Enter amount and pay securely via Razorpay</p>
    </div>

    <div class="form-group">
        <label>Amount (INR)</label>
        <input type="number" id="amount" class="form-control" required placeholder="Enter Amount (e.g. 100)">
    </div>

    <div class="checkbox-group">
        <input type="checkbox" id="terms" required>
        <label for="terms" style="font-weight:normal; font-size: 12px; display:inline;">I understand after the funds added I will not ask fraudulent dispute or charge-back.</label>
    </div>

    <button type="button" id="rzp-button" class="btn-pay">Pay Now</button>
</div>

<script>
    document.getElementById('rzp-button').onclick = function(e){
        var amount = document.getElementById('amount').value;
        var termsChecked = document.getElementById('terms').checked;

        if(!amount || amount <= 0) {
            alert('Please enter a valid amount!');
            return;
        }
        if(!termsChecked) {
            alert('Please accept the terms and conditions checkbox.');
            return;
        }

        var options = {
            "key": "rzp_test_TJ0e60jDD1w7mt", // তোর দেওয়া Key ID
            "amount": amount * 100, // পয়সায় কনভার্ট করা
            "currency": "INR",
            "name": "SMM Panel",
            "description": "Add Fund to Wallet",
            "handler": function (response){
                alert('Payment Successful! Payment ID: ' + response.razorpay_payment_id);
                
                // ব্যাকএন্ডে ফায়ারবেসে ব্যালেন্স আপডেট করার জন্য পাঠানো
                fetch('rosa_webhook.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        payment_id: response.razorpay_payment_id,
                        amount: amount,
                        status: 'success',
                        user_id: '<?php echo isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "guest_user"; ?>'
                    })
                }).then(res => res.json()).then(data => {
                    alert('Balance updated successfully!');
                    window.location.reload();
                }).catch(err => {
                    console.error('Error updating balance:', err);
                });
            },
            "prefill": {
                "name": "User",
                "email": "user@example.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#2196F3"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    }
</script>

</body>
</html>
