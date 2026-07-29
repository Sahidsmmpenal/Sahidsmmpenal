<?php
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data && isset($data['status']) && $data['status'] == 'success') {
    $paymentId = $data['payment_id'];
    $amountPaid = $data['amount'];
    $userId = $data['user_id'];

    $firebaseUrl = "https://sahidsmmpenal-default-rtdb.firebaseio.com";

    $getUserCh = curl_init();
    curl_setopt($getUserCh, CURLOPT_URL, $firebaseUrl . "/users/" . $userId . "/balance.json");
    curl_setopt($getUserCh, CURLOPT_RETURNTRANSFER, true);
    $currentBalance = curl_exec($getUserCh);
    curl_close($getUserCh);

    $currentBalance = is_numeric($currentBalance) ? floatval($currentBalance) : 0;
    $newBalance = $currentBalance + floatval($amountPaid);

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
