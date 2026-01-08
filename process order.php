<?php
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $item_name     = htmlspecialchars($_POST['cookie_name']);
    $quantity      = (int) $_POST['quantity'];

    // Insert into the database
    $sql = "INSERT INTO orders (customer_name, item_name, quantity) 
            VALUES ('$customer_name', '$item_name', '$quantity')";
    
    if ($conn->query($sql)) {
        setcookie("customer_name", $customer_name, time() + 3600, "/");
        setcookie("item_name", $item_name, time() + 3600, "/");
        setcookie("quantity", $quantity, time() + 3600, "/");
    } else {
        die("Error saving order: " . $conn->error);
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white text-center">
                        <h3>✅ Order Successful</h3>
                    </div>
                    <div class="card-body text-center">
                        <p class="fs-5">Thank you, <strong><?= $customer_name ?></strong>!</p>
                        <p>You have ordered:</p>
                        <h5 class="fw-bold"><?= $quantity ?> × <?= $item_name ?></h5>
                        <a href="index.php" class="btn btn-primary mt-3">Back to Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
