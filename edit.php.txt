<?php
include 'db_connect.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $conn->query("UPDATE products SET name='$name', price='$price', description='$desc' WHERE id=$id");
    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f3ee, #efe2d3);
            font-family: 'Segoe UI', sans-serif;
        }

        .edit-card {
            width: 420px;
            border-radius: 20px;
        }

        .edit-header {
            color: #6f4e37;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #5a3e2b;
        }

        .btn-primary-custom {
            background-color: #8b5e3c;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #5e3b26;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="card edit-card shadow-lg p-4">
        <h3 class="edit-header text-center mb-4">☕ Edit Product</h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control form-control-lg"
                       value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3"
                          class="form-control"><?php echo $row['description']; ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Price (RM)</label>
                <input type="number" step="0.01" name="price"
                       class="form-control"
                       value="<?php echo $row['price']; ?>" required>
            </div>

            <button type="submit" name="update"
                    class="btn btn-primary-custom w-100 btn-lg rounded-pill">
                Save Changes
            </button>

            <a href="admin.php"
               class="btn btn-outline-secondary w-100 mt-3 rounded-pill">
                Cancel
            </a>
        </form>
    </div>

</body>
</html>
