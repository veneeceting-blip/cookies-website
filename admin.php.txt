<?php
include 'db_connect.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: admin.php");
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $image_path_for_db = 'https://via.placeholder.com/600x400?text=No+Image';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "img/";
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file_path = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_path)) {
            $image_path_for_db = $target_file_path;
        }
    }

    $sql = "INSERT INTO products (name, description, price, image_url)
            VALUES ('$name', '$desc', '$price', '$image_path_for_db')";
    $conn->query($sql);
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f7f2ed, #eee3d7);
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            color: #6f4e37;
            font-weight: 800;
        }

        .card {
            border-radius: 18px;
        }

        .card-header {
            border-radius: 18px 18px 0 0;
            font-weight: 600;
        }

        .btn-theme {
            background-color: #8b5e3c;
            border: none;
            color: #fff;
        }

        .btn-theme:hover {
            background-color: #5e3b26;
            color: #fff;
        }

        .table thead {
            background-color: #f3e8dd;
        }

        img.menu-img {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body class="p-5">

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">🍪 Admin Dashboard</h1>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill">
            Back to User View
        </a>
    </div>

    <!-- ADD ITEM -->
    <div class="card mb-4 shadow">
        <div class="card-header text-white" style="background-color:#8b5e3c;">
            Add New Menu Item
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>

                <button type="submit" name="add"
                        class="btn btn-theme w-100 mt-4 rounded-pill">
                    Add to Menu
                </button>
            </form>
        </div>
    </div>

    <!-- MANAGE ITEMS -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Manage Menu Items
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT * FROM products");
                while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td>
                            <img src="<?php echo $row['image_url']; ?>" class="menu-img">
                        </td>
                        <td class="fw-semibold"><?php echo $row['name']; ?></td>
                        <td class="text-truncate" style="max-width: 220px;">
                            <?php echo $row['description']; ?>
                        </td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-sm btn-warning rounded-pill px-3">
                                Edit
                            </a>
                            <a href="admin.php?delete=<?php echo $row['id']; ?>"
                               class="btn btn-sm btn-danger rounded-pill px-3"
                               onclick="return confirm('Delete this item?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
