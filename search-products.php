<?php
session_start();
header('Content-Type: application/json');

require 'db.php';

$query = $_GET['query'] ?? '';
$escaped = mysqli_real_escape_string($con, $query);

$sql = "SELECT * FROM products WHERE name LIKE '%$escaped%'";
$result = mysqli_query($con, $sql);

$products = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $products[] = [
            'id' => $id,
            'image' => $row['image'],
            'name' => $row['name'],
            'price' => $row['price'],
            'category' => $row['category'],
            'description' => $row['description'],
            'inCart' => isset($_SESSION['cartItems'][$id]),
            'inWishlist' => isset($_SESSION['wishlistItems'][$id])
        ];
    }
}

echo json_encode([
    'success' => true,
    'products' => $products
]);
