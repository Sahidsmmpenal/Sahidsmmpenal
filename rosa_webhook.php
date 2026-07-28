<?php
header('Content-Type: application/json');

// ইনকামিং ডেটা রিড করা
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data && isset($data['status']) && $data['status'] == 'success') {
    $paymentId = $data['payment_id'];
    $amountPaid = $data['amount'];
    $userId = $data['user_id'];

    // ফায়ারবেস ডেটাবেজ ইউআরএল (তোর দেওয়া ফায়ারবেস লিঙ্ক)
    $firebaseUrl = "https://sahidsmmpenal-default-rtdb.firebaseio.com";

    // ইউজারের বর্তমান ব্যালেন্স ফেচ করা (যদি ফায়ারবেসে আগে থেকে থাকে)
    $getUserCh = curl_init();
    curl_setopt($getUserCh, CURLOPT_URL, $firebaseUrl . "/users/" . $userId . "/balance.json");
    curl_setopt($getUserCh, CURLOPT_RETURNTRANSFER, true);
    $currentBalance = curl_exec($getUserCh);
    curl_close($getUserCh);

    $currentBalance = is_numeric($currentBalance) ? floatval($currentBalance) : 0;
    $newBalance = $currentBalance + floatval($amountPaid);

    // ফায়ারবেসে নতুন ব্যালেন্স আপডেট করা
    $updateCh = curl_init();
    curl_setopt($updateCh, CURLOPT_URL, $firebaseUrl . "/users/" . $userId . "/balance.json");
    curl_setopt($updateCh, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($updateCh, CURLOPT_POSTFIELDS, json_encode($newBalance));
    curl_setopt($updateCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($updateCh, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $updateResponse = curl_exec($updateCh);
    curl_close($updateCh);

    if ($updateResponse) {
        echo json_encode(["status" => "success", "message" => "Balance updated successfully"]);
        exit;
    }
}

echo json_encode(["status" => "error", "message" => "Failed to update balance"]);
?>
