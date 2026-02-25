<?php
session_start();

if (!isset($_SESSION['contact_data'])) {
    header("Location: index.php");
    exit;
}

$data = $_SESSION['contact_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Message Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
    background:#f5f7fb;
    font-family: Arial, Helvetica, sans-serif;
    margin:0;
    padding:0;
    color:#111827;
}

.page-wrap{
    max-width:800px;
    margin:60px auto;
    padding:0 20px;
}

.card{
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 12px 30px rgba(0,0,0,.08);
    border:1px solid #e5e7eb;
}

.title{
    font-size:1.8rem;
    font-weight:800;
    margin-bottom:20px;
}

.row{
    margin-bottom:14px;
    line-height:1.6;
}

.label{
    font-weight:800;
    display:block;
    margin-bottom:4px;
    color:#111827;
}

.message-box{
    background:#f3f4f6;
    padding:14px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    line-height:1.6;
}

.btn-back{
    display:inline-flex;
    margin-top:24px;
    padding:12px 18px;
    border-radius:12px;
    background:#111827;
    color:white;
    text-decoration:none;
    font-weight:800;
    transition:.15s;
}

.btn-back:hover{
    background:#0b1220;
}

</style>
</head>

<body>

<div class="page-wrap">

<div class="card">

<h2 class="title">Message Sent Successfully ✅</h2>

<div class="row">
<span class="label">Name</span>
<?= htmlspecialchars($data['name']) ?>
</div>

<div class="row">
<span class="label">Email</span>
<?= htmlspecialchars($data['email']) ?>
</div>

<div class="row">
<span class="label">Message</span>

<div class="message-box">
<?= nl2br(htmlspecialchars($data['message'])) ?>
</div>

</div>

<a class="btn-back" href="index.php">
← Back to Home
</a>

</div>

</div>

</body>
</html>