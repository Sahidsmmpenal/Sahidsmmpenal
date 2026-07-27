let checkInterval = null;

document.addEventListener("DOMContentLoaded", () => {
    const paymentForm = document.getElementById("paymentForm");
    const formCard = document.getElementById("formCard");
    const qrCard = document.getElementById("qrCard");
    const showAmount = document.getElementById("showAmount");
    const cancelBtn = document.getElementById("cancelBtn");
    
    let qrInstance = null;

    paymentForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const amount = document.getElementById("amount").value;
        const phone = document.getElementById("phone").value;

        showAmount.innerText = `₹${amount}`;
        formCard.style.display = "none";
        qrCard.style.display = "block";

        // Clear old QR
        document.getElementById("qrcode").innerHTML = "";

        // UPI Intent String (Apnar Merchant UPI ID ebong Name ekhane din)
        const merchantUpi = "yourmerchantupi@paytm"; 
        const merchantName = "SahidSMM";
        const transactionId = "TXN" + Date.now();
        
        // UPI Deep Link with exact amount
        const upiString = `upi://pay?pa=${merchantUpi}&pn=${encodeURIComponent(merchantName)}&tr=${transactionId}&am=${amount}&cu=INR`;

        // Generate QR
        qrInstance = new QRCode(document.getElementById("qrcode"), {
            text: upiString,
            width: 200,
            height: 200
        });

        // Start polling server to check if payment is received
        startPaymentStatusChecker(transactionId, amount, phone);
    });

    cancelBtn.addEventListener("click", () => {
        clearInterval(checkInterval);
        qrCard.style.display = "none";
        formCard.style.display = "block";
    });
});

// Real-time payment verification checker (Polls backend every 5 seconds)
function startPaymentStatusChecker(txnId, amount, phone) {
    let timeLeft = 300; // 5 minutes timer
    const countdownEl = document.getElementById("countdown");

    checkInterval = setInterval(async () => {
        timeLeft--;
        countdownEl.innerText = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(checkInterval);
            alert("Payment session expired!");
            location.reload();
            return;
        }

        try {
            // Server-e check korbe ei transaction success hoyeche kina
            const response = await fetch(`https://your-backend-server.com/api/check-payment?txnId=${txnId}`);
            const data = await response.json();

            if (data.status === "SUCCESS") {
                clearInterval(checkInterval);
                alert(`Payment of ₹${amount} successful! Balance added to your account.`);
                window.location.href = "home.html"; // Dashboard-e niye jabe
            }
        } catch (error) {
            console.error("Checking payment status...", error);
        }
    }, 5000); // প্রতি ৫ সেকেন্ডে চেক করবে
}
