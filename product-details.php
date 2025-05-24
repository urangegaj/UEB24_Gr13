<?php
session_start();

require_once 'products.php';

$id = $_GET['id'] ?? null;
$product = null;

foreach ($products as $p) {
    if ($p->id === $id) {
        $product = $p;
        break;
    }
}

if (!$product) {
    echo "<p>Product not found!</p>";
    exit;
}

if (isset($_POST['cartId'])) {
    $id = $_POST['cartId'];
    if (isset($_SESSION['cartItems'][$id])) {
        unset($_SESSION['cartItems'][$id]);
        $message = "Item removed from cart!";
    } else {
        $_SESSION['cartItems'][$id] = true;
        $message = "Item added to cart!";
    }
 
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <title><?= $product->name ?> | Laced Lifestyle</title>
</head>
<body>
       <header id="navbar" class="header">
        <div class="container1">
            <div class="logo" >
            <img src="images/logo.png" alt="Laced Lifestyle Logo">
            <h1>Laced Lifestyle</h1>
        </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="./index.html">Home</a></li>
                    <li><a href="./Products.php">Products</a></li>
                    <li><a href="./About.php">About</a></li>
                    <li><a href="./Contact.html">Contact</a></li>
                </ul>
                <div id="navbar-tools">
                <a id="cart-link" href="cart.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
    </svg>
    <span><?= getCartCount(); ?></span>
</a>

<a id="wishlist-link" href="wishlist.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
    </svg>
    <span><?= getWishlistCount(); ?></span>
</a>
            </div>
            </nav>
        </div>
    
    </header>





    <a href="Products.php">← Go back to Products</a>

    <div class="product-detail">
        <img src="<?= $product->image ?>" alt="<?= $product->name ?>" style="max-width: 500px;">

        <h1><?= $product->name ?></h1>
        <p>Price: $<?= $product->price ?></p>

       <p><strong>Description:</strong> <?= $product->description ?></p>

        <form method="post">
            <label for="size">Choose size:</label>
            <select name="size" id="size" required>
                <option value="">Select</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
            </select>

            <input type="hidden" name="cartId" value="<?= $product->id ?>">

            <button type="submit">Add to Cart</button>
        </form>
    </div>
<?php include 'footer.php'; ?>

</html>
