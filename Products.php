<?php

session_start();

class Product{
    public $id;
    public $image;
    public $name;
    public $price;
    public $category;

    public function __construct($id, $image, $name, $price, $category){
        $this->id= $id;
        $this->image = $image;
        $this->name=$name;
        $this-> price=$price;
        $this->category =$category;

    }


   //Gjenerimi i HTML per çdo produkt
   public function render() {
    $inCart = isset($_SESSION['cartItems'][$this->id]);
    $inWishlist = isset($_SESSION['wishlistItems'][$this->id]);

    $cartText = $inCart ? "Remove from Cart" : "Add to Cart";
    $cartClass = $inCart ? "in-cart" : "";
    $wishlistClass = $inWishlist ? "selected" : "";

    return "
    <div class='product' data-id='{$this->id}'>
        <img src='{$this->image}' alt='{$this->name}'>
        <form method='post' style='display:inline'>
            <input type='hidden' name='wishlistId' value='{$this->id}'>
            <input type='hidden' name='category' value='{$this->category}'>
            <button class='heart-button {$wishlistClass}' name='add_to_wishlist' type='submit' aria-label='Add to wishlist'>
                <svg viewBox='0 0 24 24' width='22px' height='22px' xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='xMidYMid meet'>
                    <path fill-rule='evenodd' clip-rule='evenodd' d='M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z'
                      stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                </svg>
            </button>
        </form>
        <div class='product-details'>
            <h3>{$this->name}</h3>
            <p class='price'>\${$this->price}</p>
        </div>
        <form method='post'>
            <input type='hidden' name='cartId' value='{$this->id}'>
            <input type='hidden' name='category' value='{$this->category}'>
            <button class='add-to-cart {$cartClass}' type='submit'>{$cartText}</button>
        </form>
    </div>";
}
}

    //Krijimi i produkteve
    $products = [
        new Product ("running-shoes-1","images/RunningShoes11.jpg", "Speed Racer 2000", 79.99 , "running-shoes"),
        new Product ("running-shoes-2","images/RunningShoes2.jpg", "Runner X-Pro", 89.99, "running-shoes"),
        new Product ("running-shoes-3","images/RunningShoes33.jpg", "Race Flex", 85.99, "running-shoes"),
        new Product ("running-shoes-4","images/RunningShoes4.jpg", "Speed Goat", 75.99, "running-shoes"),
        new Product ("running-shoes-5","images/RunningShoes5.jpg", "Ultraboost", 69.99 ,"running-shoes"),
        new Product ("running-shoes-6","images/RunningShoes6.jpg", "Infinity Run", 65.99, "running-shoes"),
        new Product ("casual-shoes-1", "images/CasualShoes11.jpg", "Urban Loafers", 59.99, "casual-shoes"),
        new Product ("casual-shoes-2", "images/CasualShoes2.jpg", "Easy Walk", 49.99, "casual-shoes"),
        new Product ("casual-shoes-3", "images/CasualShoes3.jpg", "Daily Flex", 39.99, "casual-shoes"),
        new Product ("casual-shoes-4", "images/CasualShoes4.jpg", "Timeless Tread", 59.99, "casual-shoes"),
        new Product ("casual-shoes-5", "images/CasualShoes5.jpg", "Heritage Step", 55.00, "casual-shoes"),
        new Product ("casual-shoes-6", "images/CasualShoes6.jpg", "Prestige Glide", 79.99, "casual-shoes"),
        new Product ("formal-shoes-1", "images/FormalShoes1.jpg", "Executive Apex", 119.99, "formal-shoes"),
        new Product ("formal-shoes-2", "images/FormalShoes2.jpg", "Classic Brogue", 129.99, "formal-shoes"),
        new Product ("formal-shoes-3", "images/FormalShoes3.jpg", "Patent Leather", 159.99, "formal-shoes"),
        new Product ("formal-shoes-4", "images/FormalShoes7.jpg", "Classic Black", 199.99, "formal-shoes"),
        new Product ("formal-shoes-5", "images/FormalShoes5.jpg", "Cognac Classic Oxford", 124.99, "formal-shoes"),
        new Product ("formal-shoes-6", "images/FormalShoes6.jpg", "Ebony Elegance Oxford", 140.00, "formal-shoes")
    ];

    if (isset($_POST['cartId'])) {
        $id = $_POST['cartId'];
        $productCategory = $_POST['category'] ?? '';
        if (isset($_SESSION['cartItems'][$id])) {
            unset($_SESSION['cartItems'][$id]);
        } else {
            $_SESSION['cartItems'][$id] = true;
        }
        header("Location: " . $_SERVER['PHP_SELF'] . "#$productCategory");
        exit();
    }
    
    if (isset($_POST['wishlistId'])) {
        $id = $_POST['wishlistId'];
        $productCategory = $_POST['category'] ?? '';
        if (isset($_SESSION['wishlistItems'][$id])) {
            unset($_SESSION['wishlistItems'][$id]);
        } else {
            $_SESSION['wishlistItems'][$id] = true;
        }
        header("Location: " . $_SERVER['PHP_SELF'] . "#$productCategory");
        exit();
    }

    function getCartCount() {
        return count($_SESSION['cartItems'] ?? []);
    }
    
    function getWishlistCount() {
        return count($_SESSION['wishlistItems'] ?? []);
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
     
    <title>Products</title>
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
                    <li><a href="#products">Products</a></li>
                    <li><a href="./About.html">About</a></li>
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

    <header class="product-header">
        <div class="product-container">
            <nav>
                <ul class="nav-links">
                    <li><a href="#running-shoes">Running Shoes</a></li>
                    <li><a href="#casual-shoes">Casual Shoes</a></li>
                    <li><a href="#formal-shoes">Formal Shoes</a></li>
                </ul>
            </nav>
        </div>
        
       
    </header>

    <div class="products">
    <?php
    $categories = ["running-shoes" => "Running Shoes", "casual-shoes" => "Casual Shoes", "formal-shoes" => "Formal Shoes"];
    foreach ($categories as $cat => $label) {
        echo "<section id='{$cat}'>";
        echo "<h2>{$label}</h2>";
        echo "<div class='product-grid scrollable-grid'>";
        foreach ($products as $product) {
            if ($product->category === $cat) {
                echo $product->render();
            }
        }
        echo "</div></section>";
    }
    ?>
</div>
    

  <footer class="footer">
        <div class="container">
            <p>© 2024 Laced Lifestyle. All Rights Reserved.</p>
        </div>
    </footer>




    




</body>
</html>

