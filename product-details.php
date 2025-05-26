<?php
session_start();
require 'db.php'; 
require_once 'productData.php';

if (!isset($_GET['id'])) {
    echo "<p>Produkti nuk u gjet.</p>";
    exit;
}

$id = $_GET['id'];  
$stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("s", $id);  
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "<p>Produkti nuk ekziston.</p>";
    exit;
}

$inCart = isset($_SESSION['cartItems'][$product['id']]);
$inWishlist = isset($_SESSION['wishlistItems'][$product['id']]);

$cartText = $inCart ? "Remove from Cart" : "Add to Cart";
$cartClass = $inCart ? "in-cart" : "";
$wishlistText = $inWishlist ? "Remove from Wishlist" : "Add to Wishlist";
$wishlistClass = $inWishlist ? "selected" : "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cartId']) && $_POST['cartId'] == $product['id']) {
        if ($inCart) {
            unset($_SESSION['cartItems'][$product['id']]);
            $inCart = false;
        } else {
            $_SESSION['cartItems'][$product['id']] = ['quantity' => 1];
            $inCart = true;
        }
        $cartText = $inCart ? "Remove from Cart" : "Add to Cart";
        $cartClass = $inCart ? "in-cart" : "";
    }

    if (isset($_POST['wishlistId']) && $_POST['wishlistId'] == $product['id']) {
        if ($inWishlist) {
            unset($_SESSION['wishlistItems'][$product['id']]);
            $inWishlist = false;
        } else {
            $_SESSION['wishlistItems'][$product['id']] = true;
            $inWishlist = true;
        }
        $wishlistText = $inWishlist ? "Remove from Wishlist" : "Add to Wishlist";
        $wishlistClass = $inWishlist ? "selected" : "";
    }
}
?>

<div id="product-detail-modal-content" style="padding: 20px;">


    <img
        src="<?= htmlspecialchars($product['image']) ?>"
        alt="<?= htmlspecialchars($product['name']) ?>"
        style="max-width: 300px; display: block; margin-bottom: 20px;"
    />
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <p><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>

    <form method="post" class="wishlist-form" style="margin-bottom: 20px;">
        <input type="hidden" name="wishlistId" value="<?= $product['id'] ?>" />
        <input type="hidden" name="category" value="<?= htmlspecialchars($product['category']) ?>" />
        <button class="heart-button <?= $wishlistClass ?>" type="submit">
          <svg viewBox='0 0 24 24' width='22px' height='22px' xmlns='http://www.w3.org/2000/svg'>
                    <path fill-rule='evenodd' clip-rule='evenodd' d='M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z'/>
                </svg>
        
        </button>
    </form>

    <form method="post" class="cart-form">
        <input type="hidden" name="cartId" value="<?= $product['id'] ?>" />
        <input type="hidden" name="category" value="<?= htmlspecialchars($product['category']) ?>" />
        <button class="add-to-cart <?= $cartClass ?>" type="submit"><?= $cartText ?></button>
    </form>
</div>



