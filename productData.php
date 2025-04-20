<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cartItems'])) {
    $_SESSION['cartItems'] = [];
}
if (!isset($_SESSION['wishlistItems'])) {
    $_SESSION['wishlistItems'] = [];
}

class Product {
    public $id;
    public $image;
    public $name;
    public $price;
    public $category;

    public function __construct($id, $image, $name, $price, $category) {
        $this->id = $id;
        $this->image = $image;
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
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
$products = [
    new Product("running-shoes-1", "images/RunningShoes11.jpg", "Speed Racer 2000", 79.99, "running-shoes"),
    new Product("running-shoes-2", "images/RunningShoes2.jpg", "Runner X-Pro", 89.99, "running-shoes"),
    new Product("running-shoes-3", "images/RunningShoes33.jpg", "Race Flex", 85.99, "running-shoes"),
    new Product("running-shoes-4", "images/RunningShoes4.jpg", "Speed Goat", 75.99, "running-shoes"),
    new Product("running-shoes-5", "images/RunningShoes5.jpg", "Ultraboost", 69.99, "running-shoes"),
    new Product("running-shoes-6", "images/RunningShoes6.jpg", "Infinity Run", 65.99, "running-shoes"),
    new Product("casual-shoes-1", "images/CasualShoes11.jpg", "Urban Loafers", 59.99, "casual-shoes"),
    new Product("casual-shoes-2", "images/CasualShoes2.jpg", "Easy Walk", 49.99, "casual-shoes"),
    new Product("casual-shoes-3", "images/CasualShoes3.jpg", "Daily Flex", 39.99, "casual-shoes"),
    new Product("casual-shoes-4", "images/CasualShoes4.jpg", "Timeless Tread", 59.99, "casual-shoes"),
    new Product("casual-shoes-5", "images/CasualShoes5.jpg", "Heritage Step", 55.00, "casual-shoes"),
    new Product("casual-shoes-6", "images/CasualShoes6.jpg", "Prestige Glide", 79.99, "casual-shoes"),
    new Product("formal-shoes-1", "images/FormalShoes1.jpg", "Executive Apex", 119.99, "formal-shoes"),
    new Product("formal-shoes-2", "images/FormalShoes2.jpg", "Classic Brogue", 129.99, "formal-shoes"),
    new Product("formal-shoes-3", "images/FormalShoes3.jpg", "Patent Leather", 159.99, "formal-shoes"),
    new Product("formal-shoes-4", "images/FormalShoes7.jpg", "Classic Black", 199.99, "formal-shoes"),
    new Product("formal-shoes-5", "images/FormalShoes5.jpg", "Cognac Classic", 124.99, "formal-shoes"),
    new Product("formal-shoes-6", "images/FormalShoes6.jpg", "Ebony Elegance ", 14.00, "formal-shoes")
];
?>