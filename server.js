const express = require('express');
const app = express();
app.use(express.json());

// Temporary database storage (Apni Firebase ba MongoDB use korben)
let transactions = {}; 

// 1. Payment Gateway Webhook (Gateway theke eta call hobe payment sesh hole)
app.post('/api/payment-webhook', (req, res) => {
    const { txnId, amount, customerPhone, status } = req.body;

    if (status === "SUCCESS") {
        // Transaction store kore rakhlam jate frontend check korte pare
        transactions[txnId] = { status: "SUCCESS", amount: amount };

        // TODO: Database (Firebase/MySQL) theke user-er account khuje balance update korun
        // Example: updateUserBalance(customerPhone, amount);
        
        return res.status(200).json({ success: true, message: "Balance updated successfully" });
    }
    
    res.status(400).json({ success: false, message: "Payment failed or pending" });
});

// 2. Frontend theke status check korar API
app.get('/api/check-payment', (req, res) => {
    const { txnId } = req.query;
    if (transactions[txnId] && transactions[txnId].status === "SUCCESS") {
        return res.json({ status: "SUCCESS" });
    }
    res.json({ status: "PENDING" });
});

app.listen(3000, () => console.log('SMM Auto-Pay server running on port 3000'));
