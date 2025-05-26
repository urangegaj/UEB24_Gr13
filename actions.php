<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Toggle cart (add/remove)
if (isset($_POST['cartId'])) {
    $id = $_POST['cartId'];
    if (isset($_SESSION['cartItems'][$id])) {
        unset($_SESSION['cartItems'][$id]);
        $message = "Item removed from cart!";
    } else {
        $_SESSION['cartItems'][$id] = true;
        $message = "Item added to cart!";
    }

    echo json_encode([
        'cartCount' => count($_SESSION['cartItems']),
        'message' => $message
    ]);
    exit();
}

// Toggle wishlist (add/remove)
if (isset($_POST['wishlistId'])) {
    $id = $_POST['wishlistId'];
    if (isset($_SESSION['wishlistItems'][$id])) {
        unset($_SESSION['wishlistItems'][$id]);
        $message = "Item removed from favourites!";
    } else {
        $_SESSION['wishlistItems'][$id] = true;
        $message = "Item added to favourites!";
    }

    echo json_encode([
        'wishlistCount' => count($_SESSION['wishlistItems']),
        'message' => $message
    ]);
    exit();
}

// Add to cart (explicit)
if (isset($_POST['addToCartId'])) {
    $id = $_POST['addToCartId'];
    $_SESSION['cartItems'][$id] = true;

    echo json_encode([
        'message' => 'Item added to cart!',
        'cartCount' => count($_SESSION['cartItems'] ?? [])
    ]);
    exit;
}

// Remove from cart (explicit + total price)
if (isset($_POST['removeFromCartId'])) {
    $id = $_POST['removeFromCartId'];
    $totalPrice = 0;
    $message = "";

    if (isset($_SESSION['cartItems'][$id])) {
        unset($_SESSION['cartItems'][$id]);
        $message = "Item removed from cart!";

        if (!empty($_SESSION['cartItems'])) {
            require_once 'productData.php';
            foreach ($_SESSION['cartItems'] as $cartId => $_) {
                foreach ($products as $product) {
                    if ($product->id === $cartId) {
                        $totalPrice += floatval($product->price);
                        break;
                    }
                }
            }
        }
    } else {
        $message = "Item not found in cart.";
    }

    echo json_encode([
        'cartCount' => count($_SESSION['cartItems'] ?? []),
        'message' => $message,
        'totalPrice' => $totalPrice
    ]);
    exit();
}

// Remove from wishlist (explicit)
if (isset($_POST['removeFromWishlistId'])) {
    $id = $_POST['removeFromWishlistId'];
    unset($_SESSION['wishlistItems'][$id]);

    echo json_encode([
        'message' => 'Item removed from favourites!',
        'wishlistCount' => count($_SESSION['wishlistItems'] ?? [])
    ]);
    exit;
}
?>
