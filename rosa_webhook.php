<?php
// ফায়ারবেস রিয়েলটাইম ডাটাবেজ ইউআরএল
$firebaseUrl = "https://sahidsmmpenal-default-rtdb.firebaseio.com";

// পেমেন্ট গেটওয়ে বা ওয়েব হুক থেকে আসা পোস্ট ডেটা রিসিভ করা
$inputPayload = file_get_contents('php://input');
$data = json_decode($inputPayload, true);

if (!empty($data)) {
    // ইউজারের আইডি, অ্যামাউন্ট এবং পেমেন্ট স্ট্যাটাস রিসিভ করা
    $userId = $data['user_id'] ?? null; 
    $amount = $data['amount'] ?? null; 
    $status = $data['status'] ?? null; 

    // পেমেন্ট সফল হয়েছে কি না চেক করা
    if ($status == 'success' && !empty($userId) && !empty($amount)) {
        
        // ১. ফায়ারবেস থেকে ইউজারের বর্তমান ব্যালেন্স আনা
        $getUserUrl = $firebaseUrl . "/users/" . $userId . ".json";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getUserUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $userData = json_decode($response, true);
        $currentBalance = isset($userData['balance']) ? floatval($userData['balance']) : 0;
        
        // ২. নতুন ব্যালেন্স হিসাব করা
        $newBalance = $currentBalance + floatval($amount);

        // ৩. ফায়ারবেসে নতুন ব্যালেন্স আপডেট করা
        $updateData = json_encode(["balance" => $newBalance]);
        $updateUserUrl = $firebaseUrl . "/users/" . $userId . ".json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $updateUserUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $updateResponse = curl_exec($ch);
        curl_close($ch);

        if ($updateResponse) {
            echo json_encode(["status" => "success", "message" => "Balance updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update balance"]);
        }

    } else {
        echo json_encode(["status" => "failed", "message" => "Invalid payment data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No data received"]);
}
?>
