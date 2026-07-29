<?php
session_start();
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $utr_number = trim($_POST['utr_number'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    if (empty($utr_number) || $amount <= 0) {
        echo "<script>alert('Please enter a valid UTR number and amount!'); window.history.back();</script>";
        exit();
    }

    if ($user_id == 0) {
        echo "<script>alert('Please login first!'); window.location.href='index.html';</script>";
        exit();
    }

    $check_utr = mysqli_query($conn, "SELECT * FROM add_funds WHERE utr_number = '$utr_number'");
    if ($check_utr && mysqli_num_rows($check_utr) > 0) {
        echo "<script>alert('This UTR number has already been used!'); window.history.back();</script>";
        exit();
    }

    $insert = mysqli_query($conn, "INSERT INTO add_funds (user_id, utr_number, amount, status) VALUES ('$user_id', '$utr_number', '$amount', 'Pending')");

    if ($insert) {
        echo "<script>alert('Payment request submitted successfully!'); window.location.href='add-funds.html';</script>";
    } else {
        echo "<script>alert('Something went wrong, please try again.'); window.history.back();</script>";
    }
}
?>
