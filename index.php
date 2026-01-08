<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMU Cookie Cloud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --cookie-primary: #8B5E3C;
            --cookie-secondary: #FFF3E0;
            --cookie-accent: #D7B899;
        }

        body {
            background-color: var(--cookie-secondary);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: var(--cookie-primary);
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,.55), rgba(0,0,0,.55)),
            url('https://images.unsplash.com/photo-1606313564200-e75d5e30476c');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            color: #fff;
            text-align: center;
        }

        .btn-cookie {
            background-color: var(--cookie-primary);
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
        }

        .btn-cookie:hover {
            background-color: #5e3b26;
            color: #fff;
        }

        .cookie-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .section-title {
            color: var(--cookie-primary);
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">🍪 Cookie Cloud</a>
        <div class="ms-auto">
            <a href="#menu" class="nav-link text-white d-inline mx-2">Menu</a>
            <a href="#order" class="nav-link text-white d-inline mx-2">Order</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <h1 class="display-4 fw-bold">Freshly Baked Happiness 🍪</h1>
        <p class="lead">Choose your favourite cookies anytime</p>
        <a href="#order" class="btn btn-cookie btn-lg mt-3">Order Cookies</a>
    </div>
</section>

<!-- MENU -->
<section id="menu" class="py-5">
    <div class="container">
        <h2 class="text-center section-title mb-5">Our Cookie Selection</h2>
        <div class="row g-4">

            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-md-4">
                    <div class="card cookie-card h-100 shadow-sm border-0 p-3">
                        <img src="<?= $row['image_url'] ?: 'https://via.placeholder.com/600x400'; ?>" class="card-img-top">
                        <div class="card-body text-center">
                            <h5 class="fw-bold"><?= $row['name']; ?></h5>
                            <p class="text-muted"><?= $row['description']; ?></p>
                            <h4 class="text-success">$<?= $row['price']; ?></h4>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p class='text-center'>Cookies coming soon 🍪</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- ORDER -->
<section id="order" class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-center text-white" style="background-color: var(--cookie-primary);">
                        <h3>🍪 Place Your Cookie Order</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="process_order.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Choose Cookie</label>
                                <select name="cookie_name" class="form-select">
                                    <?php
                                    $result->data_seek(0);
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['name']}'>{$row['name']} - \${$row['price']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                            </div>

                            <button type="submit" class="btn btn-cookie w-100 btn-lg">
                                Submit Order 🍪
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
