<?php
session_start();
require 'db.php';

class Product {
    public $id, $image, $name, $price, $category, $description;

    public function __construct($id, $image, $name, $price, $category, $description) {
        $this->id = $id;
        $this->image = $image;
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->description = $description;
    }

    public function render() {
        $inCart = isset($_SESSION['cartItems'][$this->id]);
        $inWishlist = isset($_SESSION['wishlistItems'][$this->id]);
        $cartText = $inCart ? "Remove from Cart" : "Add to Cart";
        $cartClass = $inCart ? "in-cart" : "";
        $wishlistClass = $inWishlist ? "selected" : "";

        return "
        <div class='product'>
            <img src='{$this->image}' alt='{$this->name}'>
            <h3>{$this->name}</h3>
            <p class='price'>\${$this->price}</p>
        </div>";
    }
}

$query = $_GET['query'] ?? '';
$escaped = mysqli_real_escape_string($con, $query);
$sql = "SELECT * FROM products WHERE name LIKE '%$escaped%'";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $p = new Product($row['id'], $row['image'], $row['name'], $row['price'], $row['category'], $row['description']);
        echo $p->render();
    }
} else {
    echo "<p>No matching products found.</p>";
}
?>
