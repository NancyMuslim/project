<?php
// Include the database configuration file
include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a3a; /* Darker background for a sophisticated look */
            color: #dfe6e9; /* Soft, off-white text for better readability */
            margin: 0;
            padding: 0;
        }

        /* Centered Heading */
        .center h3 {
            font-size: 30px;
            color: #95a5a6; /* Muted gray for the title */
            margin-top: 30px;
        }

        /* Container Styles */
        .container {
            margin-top: 40px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between; /* Ensures four items per row */
        }

        /* Card Styles */
        .card {
            border: 1px solid #2c3e50; /* Darker, deep border color */
            border-radius: 8px;
            background-color: #34495e; /* Deep grayish-blue for the card background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1 1 calc(25% - 20px); /* Ensures 4 cards per row and space between them */
            margin-bottom: 20px;
            min-width: 230px; /* Ensure consistent size for smaller screens */
        }

        .card:hover {
            transform: scale(1.05); /* Slight scaling on hover */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.4); /* Deeper shadow on hover */
        }

        /* Card Image */
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        /* Card Body */
        .card-body {
            padding: 15px;
            text-align: center;
        }

        .card-title {
            font-size: 18px;
            color: #ecf0f1; /* Lighter text for the title, contrasts with the dark background */
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
            color: #ecf0f1; /* Light text for the price */
        }

        /* Buttons */
        .btn {
            margin: 5px;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #e74c3c; /* Deep red */
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b; /* Darker red on hover */
        }

        .btn-primary {
            background-color: #2980b9; /* Deep blue */
            color: white;
        }

        .btn-primary:hover {
            background-color: #1f618d; /* Darker blue on hover */
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 1024px) {
            .card {
                flex: 1 1 calc(48% - 20px); /* Adjust for medium screens, two items per row */
            }
        }

        @media (max-width: 768px) {
            .card {
                flex: 1 1 100%; /* Stack cards vertically for mobile screens */
            }
        }
    </style>
</head>
<body>
    <center>
        <h3>All Products Currently Available</h3>
    </center>

    <div class="container mt-4">
        <div class="row">
            <?php
            // Fetch products from the database
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            // Display products in cards
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                            <p class="card-text">Price: $' . htmlspecialchars($row['price']) . '</p>
                            <a href="delete.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger">Delete Product</a>
                            <a href="update.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Update Product</a>
                        </div>
                    </div>
                </div>
                ';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
