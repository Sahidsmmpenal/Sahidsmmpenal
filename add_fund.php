<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Funds - Secure Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            width: 100%;
            max-width: 450px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header-box {
            background: #ffffff;
            border: 2px solid #00bcd4;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header-box h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 16px;
        }
        .qr-img {
            width: 100%;
            max-height: 250px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .upi-id {
            background: #e0f7fa;
            color: #00838f;
            padding: 8px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 6px;
            word-break: break-all;
        }
        .instruction-box {
            background: #fff8e1;
            border: 1px solid #ffe0b2;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
        }
        .instruction-box h4 {
            margin: 0 0 8px 0;
            color: #d32f2f;
            text-align: center;
            font-size: 15px;
        }
        .instruction-box ol {
            margin: 0;
            padding-left: 20px;
            font-size: 12px;
            color: #d32f2f;
            font-weight: bold;
        }
        .instruction-box ol li {
            margin-bottom: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12px;
            margin-bottom: 20px;
            color: #555;
        }
        .checkbox-group input {
            margin-top: 2px;
        }
        .btn-pay {
            width: 100%;
            background: #2196F3;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }
        .btn-pay:hover {
            background: #0b7dda;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- QR Code & Header Section -->
    <div class="header-box">
        <h3>FamPay / Secure UPI <br><span style="color: #ff9800;">Payment Gateway</span></h3>
        <!-- তোর আপলোড করা কিউআর কোডের ইমেজ লিংক এখানে বসানো হলো -->
        <img src="https://i.ibb.co.com/example/qr.png" alt="QR Code" class="qr-img" id="qrImage">
        <div class="upi-id">9749401427@fam</div>
    </div>

    <!-- How To Pay Section -->
    <div class="instruction-box">
        <h4>How To Pay ?</h4>
        <ol>
            <li>STEP 1 : SCAN ANY BARCODE</li>
            <li>STEP 2 : PAY AMOUNT (MINIMUM ₹1)</li>
            <li>STEP 3 : PUT AMOUNT & ORDER/ TRANSACTION ID</li>
            <li>STEP 4 : CLICK ON PAY BUTTON</li>
        </ol>
    </div>

    <!-- Payment Form -->
    <form id="paymentForm" method="POST" action="process_payment.php">
        <div class="form-group">
            <label>UTR Number</label>
            <input type="text" id="utr" name="utr_number" class="form-control" placeholder="Enter UTR / Transaction ID" required>
        </div>

        <div class="form-group">
            <label>Amount (INR)</label>
            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter Amount" required>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="terms" required>
            <label for="terms" style="font-weight:normal; font-size:12px; display:inline;">I understand after the funds added I will not ask fraudulent dispute or charge-back.</label>
        </div>

        <button type="submit" class="btn-pay">Pay</button>
    </form>
</div>

<script>
    // কিউআর কোডের ছবিটি সরাসরি এখানে বসিয়ে দেওয়া হলো যাতে কোনো লিংক ফেল না করে
    document.getElementById('qrImage').src = document.querySelector('.qr-img').src = "data:image/png;base64,..."; // (অথবা তোর ছবির ডিরেক্ট লিংক ব্যবহার করতে পারিস)
</script>

</body>
</html>
