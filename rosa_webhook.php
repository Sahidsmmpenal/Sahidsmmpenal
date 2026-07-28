<?php
$firebaseUrl = "https://sahidsmmpenal-default-rtdb.firebaseio.com";

$inputPayload = file_get_contents('php://input');
$data = json_decode($inputPayload, true);

if (!empty($data)) {
    $paymentEntity = $data['payload']['payment']['entity'] ?? null;
    $status = $data['event'] ?? ($data['status'] ?? null);
    
    $notes = $paymentEntity['notes'] ?? ($data['notes'] ?? null);
    $userId = $notes['user_id'] ?? ($data['user_id'] ?? null);
    $amountPaid = $paymentEntity['amount'] ?? ($data['amount'] ?? null);

    $amount = $amountPaid ? floatval($amountPaid) / 100 : 0;

    $isCaptured = false;
    if ($status == 'payment.captured' || $status == 'success' || ($paymentEntity && $paymentEntity['status'] == 'captured')) {
        $isCaptured = true;
    }

    if ($isCaptured && !empty($userId) && $amount > 0) {
        $getUserUrl = $firebaseUrl . "/users/" . $userId . ".json";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getUserUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $userData = json_decode($response, true);
        $currentBalance = isset($userData['balance']) ? floatval($userData['balance']) : 0;
        $newBalance = $currentBalance + $amount;

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
            echo json_encode(["status" => "success", "message" => "Verified and balance updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update balance"]);
        }
    } else {
        echo json_encode(["status" => "failed", "message" => "Unverified or invalid payment"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No data received"]);
}
?>
