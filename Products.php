<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <script>
        
        function updateCartAndWishlist() {
            const cartCount = document.querySelector("#cart-link span");
            const wishlistCount = document.querySelector("#wishlist-link span");
    
            const cartItems = localStorage.getItem('cartItems') || '';
            const wishlistItems = localStorage.getItem('wishlistItems') || '';
    
            const cartItemCount = cartItems.split(';').filter(Boolean).length;
            const wishlistItemCount = wishlistItems.split(';').filter(Boolean).length;
    
            cartCount.textContent = cartItemCount;
            wishlistCount.textContent = wishlistItemCount;
        }
    
      
        function updateLocalStorage(type, productString, action) {
            let items = localStorage.getItem(type) || '';
            let productsArray = items.split(';').filter(Boolean);
    
            if (action === 'add') {
                const productId = productString.split(',')[0];
                if (!productsArray.some(item => item.startsWith(productId))) {
                    productsArray.push(productString);
                }
            } else if (action === 'remove') {
                const productId = productString.split(',')[0];
                productsArray = productsArray.filter(item => !item.startsWith(productId));
            }
    
            localStorage.setItem(type, productsArray.join(';'));
        }
    
       
        function addToCart(button) {
            const productId = button.getAttribute('data-Id');
            const productName = button.closest('.product').querySelector('h3').textContent;
            const productPrice = button.closest('.product').querySelector('.price').textContent;
            const productImage = button.closest('.product').querySelector('img').src;  
    
     
            const productString = `${productId},${productName},${productPrice},${productImage}`;
    
           
            updateLocalStorage('cartItems', productString, 'add');
    
          
            button.textContent = 'Remove from Cart';
            button.classList.add('in-cart');
    
            updateCartAndWishlist();
    
          
            showMessage('Item added to cart!');
        }
    
    
        function removeFromCart(button) {
            const productId = button.getAttribute('data-Id');
            updateLocalStorage('cartItems', `${productId},`, 'remove');
            button.textContent = 'Add to Cart';
            button.classList.remove('in-cart');
            updateCartAndWishlist();
            showMessage('Item removed from cart!');
        }
    
function addToWishlist(heartButton) {
    const productId = heartButton.getAttribute('data-Id');
    const productName = heartButton.closest('.product').querySelector('h3').textContent;
    const productPrice = heartButton.closest('.product').querySelector('.price').textContent;
    const productImage = heartButton.closest('.product').querySelector('img').src; 

    const productString = `${productId},${productName},${productPrice},${productImage}`;

   
    updateLocalStorage('wishlistItems', productString, 'add');
  
    heartButton.classList.add('selected');
    
  
    updateCartAndWishlist();

   
    showMessage('Item added to favourites!');
}

    
       
        function removeFromWishlist(heartButton) {
            const productId = heartButton.getAttribute('data-id');
            updateLocalStorage('wishlistItems', `${productId},`, 'remove');
            heartButton.classList.remove('selected');
            updateCartAndWishlist();
            showMessage('Item removed from favourites!');
        }
    
   
        function showMessage(messageText) {
            const message = document.createElement('div');
            message.classList.add('cart-message');
            message.textContent = messageText;
            document.body.appendChild(message);
    
            setTimeout(() => {
                message.remove();
            }, 3000);
        }
    

        function restoreSelections() {
            const cartItems = localStorage.getItem('cartItems') || '';
            const wishlistItems = localStorage.getItem('wishlistItems') || '';
    
            const cartIds = cartItems.split(';').map(item => item.split(',')[0]);
            const wishlistIds = wishlistItems.split(';').map(item => item.split(',')[0]);
    
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                const productId = button.getAttribute('data-Id');
                if (cartIds.includes(productId)) {
                    button.textContent = 'Remove from Cart';
                    button.classList.add('in-cart');
                }
            });
    
            const heartButtons = document.querySelectorAll('.heart-button');
            heartButtons.forEach(button => {
                const productId = button.getAttribute('data-Id');
                if (wishlistIds.includes(productId)) {
                    button.classList.add('selected');
                }
            });
        }
    
      
        document.addEventListener('DOMContentLoaded', () => {
            updateCartAndWishlist();
            restoreSelections();
    
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (button.classList.contains('in-cart')) {
                        removeFromCart(button);
                    } else {
                        addToCart(button);
                    }
                });
            });
    
            const heartButtons = document.querySelectorAll('.heart-button');
            heartButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (button.classList.contains('selected')) {
                        removeFromWishlist(button);
                    } else {
                        addToWishlist(button);
                    }
                });
            });
        });
    </script>
    
        
        
    <title>Products</title>
</head>
<body>

<?php
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
    public function render(){
        return "
        <div class='product' data-Id='{$this->id}'>
            <img src='{$this->image}' alt='{$this->name}'>
            <button class='heart-button' data-Id='{$this->id}' aria-label='Add to wishlist'>
                <svg viewBox='0 0 24 24' width='22px' height='22px' xmlns='http://www.w3.org/2000/svg'>
                    <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                    <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                    <g id='SVGRepo_iconCarrier'>
                        <path fill-rule='evenodd' clip-rule='evenodd' d='M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'></path>
                    </g>
                </svg>
            </button>
            <div class='product-details'>
                <h3>{$this->name}</h3>
                <p class='price' data-price='{$this->price}'>\${$this->price}</p>
            </div>
            <button class='add-to-cart' data-Id='{$this->id}' aria-label='Add to cart'>Add to Cart</button>
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

?>

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
                          <span>0</span>
                    </a>
                    <a id="wishlist-link" href="wishlist.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                          </svg>
                              <span>0</span>
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
    <section id="running-shoes">
        <h2>Running Shoes</h2>
        <div class="product-grid scrollable-grid">
            <?php
            foreach ($products as $product) {
                if ($product->category === "running-shoes") {
                    echo $product->render();
                }
            }
            ?>
        </div>
    </section>

    <section id="casual-shoes">
        <h2>Casual Shoes</h2>
        <div class="product-grid scrollable-grid">
            <?php
            foreach ($products as $product) {
                if ($product->category === "casual-shoes") {
                    echo $product->render();
                }
            }
            ?>
        </div>
    </section>

    <section id="formal-shoes">
        <h2>Formal Shoes</h2>
        <div class="product-grid scrollable-grid">
            <?php
            foreach ($products as $product) {
                if ($product->category === "formal-shoes") {
                    echo $product->render();
                }
            }
            ?>
        </div>
    </section>
</div>
    

  <footer class="footer">
        <div class="container">
            <p>© 2024 Laced Lifestyle. All Rights Reserved.</p>
        </div>
    </footer>




</body>
</html>
