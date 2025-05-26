<?php

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
    <div class='product' data-id='{$this->id}'>
        <img src='{$this->image}' alt='{$this->name}'>
        <div class='product-details'>
            <h3>{$this->name}</h3>
            <p class='price'>\${$this->price}</p>
        </div>

        <form method='post' style='display:inline'>
            <input type='hidden' name='wishlistId' value='{$this->id}'>
            <input type='hidden' name='category' value='{$this->category}'>
            <button class='heart-button {$wishlistClass}' name='add_to_wishlist' type='submit'>
                <svg viewBox='0 0 24 24' width='22px' height='22px' xmlns='http://www.w3.org/2000/svg'>
                    <path fill-rule='evenodd' clip-rule='evenodd' d='M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z'/>
                </svg>
            </button>
        </form>

        <form method='post'>
            <input type='hidden' name='cartId' value='{$this->id}'>
            <input type='hidden' name='category' value='{$this->category}'>
            <button class='add-to-cart {$cartClass}' type='submit'>{$cartText}</button>
        </form>
    </div>";
}
}

$query = $_GET['query'] ?? '';
$escaped = mysqli_real_escape_string($con, $query);


$sql = "SELECT * FROM products WHERE name LIKE '%$escaped%'";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product = new Product(
            $row['id'],
            $row['image'],
            $row['name'],
            $row['price'],
            $row['category'],
            $row['description']
        );
        echo $product->render();
    }
} else {
    echo "<p>No matching products found.</p>";
}
?>
