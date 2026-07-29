<?php
// সেশন শুরু করো (যদি ইউজারের লগইন করা থাকে)
session_start();

// ডেটাবেজ কানেকশন ফাইল ইনক্লুড করো (তোর প্রজেক্টে ডেটাবেজ ফাইলের যে নাম দেওয়া আছে, যেমন db.php বা connection.php সেটা এখানে বসাবে)
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ফর্ম থেকে আসা ডেটাগুলো ফিল্টার করে নাও
    $utr_number = trim($_POST['utr_number']);
    $amount = floatval($_POST['amount']);
    
    // ইউজার আইডি সেশন থেকে নেওয়া (তোর প্রজেক্টে সেশনের নাম যা দেওয়া আছে, যেমন $_SESSION['user_id'])
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    if (empty($utr_number) || $amount <= 0) {
        echo "<script>alert('দয়া করে সঠিক UTR নম্বর এবং অ্যামাউন্ট দিন!'); window.history.back();</script>";
        exit();
    }

    if ($user_id == 0) {
        echo "<script>alert('আগে লগইন করুন!'); window.location.href='login.php';</script>";
        exit();
    }

    // চেক করো এই UTR নম্বরটি আগে ব্যবহার করা হয়েছে কি না (ডিপোজিট জালিয়াতি বা স্ক্যাম রোধ করতে)
    $check_utr = mysqli_query($conn, "SELECT * FROM add_funds WHERE utr_number = '$utr_number'");
    if (mysqli_num_rows($check_utr) > 0) {
        echo "<script>alert('এই UTR নম্বরটি ইতিমধ্যে ব্যবহার করা হয়েছে! ডুপ্লিকেট ট্রানজেকশন গ্রহণ করা হয় না।'); window.history.back();</script>";
        exit();
    }

    // ডেটাবেজে ডিপোজিট রিকোয়েস্ট সেভ করো বা সরাসরি ব্যালেন্স অ্যাড করে দাও
    // এখানে তোর ডেটাবেজের টেবিল স্ট্রাকচার অনুযায়ী কুয়েরি একটু এডিট করতে হতে পারে
    $insert = mysqli_query($conn, "INSERT INTO add_funds (user_id, utr_number, amount, status) VALUES ('$user_id', '$utr_number', '$amount', 'Pending')");

    if ($insert) {
        echo "<script>alert('পেমেন্ট রিকোয়েস্ট সফলভাবে জমা হয়েছে! ভেরিফিকেশন হওয়ার পর ব্যালেন্স যোগ করে দেওয়া হবে।'); window.location.href='add_fund.php';</script>";
    } else {
        echo "<script>alert('কিছু একটা সমস্যা হয়েছে, আবার চেষ্টা করুন।'); window.history.back();</script>";
    }
}
?>
