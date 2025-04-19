<?php
$products = [
    [
        "id" => 1,
        "name" => "Speed Racer 2000",
        "price" => 79.99,
        "image" => "images/RunningShoes11.jpg",
        "alt" => "Speed Racer 2000"
    ],
    [
        "id" => 2,
        "name" => "Runner X-Pro",
        "price" => 89.99,
        "image" => "images/RunningShoes2.jpg",
        "alt" => "Runner X-Pro"
    ],
    [
        "id" => 3,
        "name" => "Race Flex",
        "price" => 85.99,
        "image" => "images/RunningShoes33.jpg",
        "alt" => "Race Flex"
    ],
    [
        "id" => 4,
        "name" => "Speed Goat",
        "price" => 75.99,
        "image" => "images/RunningShoes4.jpg",
        "alt" => "Speed Goat"
    ],
    [
        "id" => 5,
        "name" => "Ultraboost",
        "price" => 69.99,
        "image" => "images/RunningShoes5.jpg",
        "alt" => "Ultraboost"
    ],
    [
        "id" => 6,
        "name" => "Infinity Run",
        "price" => 65.99,
        "image" => "images/RunningShoes1.jpg",
        "alt" => "Infinity Run"
    ]
];

$casual_shoes = [
    [
        "id" => 1,
        "name" => "Daily Flex",
        "price" => 39.99,
        "image" => "images/CasualShoes11.jpg",
        "alt" => "Daily Flex"
    ],
    [
        "id" => 2,
        "name" => "Easy Walk",
        "price" => 49.99,
        "image" => "images/CasualShoes2.jpg",
        "alt" => "Easy Walk"
    ],
    [
        "id" => 3,
        "name" => "Urban Loafers",
        "price" => 59.99,
        "image" => "images/CasualShoes3.jpg",
        "alt" => "Urban Loafers"
    ],
    [
        "id" => 4,
        "name" => "Timeless Tread",
        "price" => 59.99,
        "image" => "images/CasualShoes4.jpg",
        "alt" => "Timeless Tread"
    ],
    [
        "id" => 5,
        "name" => "Heritage Step",
        "price" => 59.99,
        "image" => "images/CasualShoes5.jpg",
        "alt" => "Heritage Step"
    ],
    [
        "id" => 6,
        "name" => "Prestige Glide",
        "price" => 79.99,
        "image" => "images/CasualShoes6.jpg",
        "alt" => "Prestige Glide"
    ]
];
$formal_shoes = [
    [
        "id" => 1,
        "name" => "Executive Apex",
        "price" => 119.99,
        "image" => "images/FormalShoes1.jpg",
        "alt" => "Executive Apex"
    ],
    [
        "id" => 2,
        "name" => "Cognac Classic Oxford",
        "price" => 124.99,
        "image" => "images/FormalShoes5.jpg",
        "alt" => "Cognac Classic Oxford"
    ],
    [
        "id" => 3,
        "name" => "Classic Brogue",
        "price" => 129.99,
        "image" => "images/FormalShoes2.jpg",
        "alt" => "Classic Brogue"
    ],
    [
        "id" => 4,
        "name" => "Patent Leather",
        "price" => 159.99,
        "image" => "images/FormalShoes3.jpg",
        "alt" => "Patent Leather"
    ],
    [
        "id" => 5,
        "name" => "Ebony Elegance Oxford",
        "price" => 159.99,
        "image" => "images/FormalShoes6.jpg",
        "alt" => "Ebony Elegance Oxford"
    ],
    [
        "id" => 6,
        "name" => "Classic Black",
        "price" => 199.99,
        "image" => "images/FormalShoes7.jpg",
        "alt" => "Classic Black"
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <script>
        function sortProductsByPriceAsc() {
            const productGrids = document.querySelectorAll('.product-grid');
    
            productGrids.forEach(grid => {
                const products = Array.from(grid.querySelectorAll('.product'));
    
                products.sort((a, b) => {
                    const priceA = parseFloat(a.querySelector('.price').dataset.price);
                    const priceB = parseFloat(b.querySelector('.price').dataset.price);
                    return priceA - priceB;
                });
    
                products.forEach(product => grid.appendChild(product));
            });
        }
    
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
    
            const productId = productString.split(',')[0];
    
            if (action === 'add') {
                if (!productsArray.some(item => item.startsWith(productId))) {
                    productsArray.push(productString);
                }
            } else if (action === 'remove') {
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
                    button.classList.contains('in-cart') ? removeFromCart(button) : addToCart(button);
                });
            });
    
            const heartButtons = document.querySelectorAll('.heart-button');
            heartButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.classList.contains('selected') ? removeFromWishlist(button) : addToWishlist(button);
                });
            });
        });
    
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
    </script>
    
    
        
        
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
                    <a id="cart-link" href="cart.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                          </svg>
                          <span>0</span>
                    </a>
                    <a id="wishlist-link" href="wishlist.html">
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
               
                </a>
            </nav>
        </div>
        
       
    </header>

    <section id="running-shoes">
    <div class="text" style="display:flex;justify-content:space-between">
        <h2>Running Shoes</h2>
        <form method="get">
            <label for="sort">Sort by:</label>
            <select style="font-size: 1.2rem;" name="sort" id="sort" onchange="this.form.submit()">
                <option value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'selected' : ''; ?>>
                    Price: Low to High
                </option>
                <option value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'selected' : ''; ?>>
                    Price: High to Low
                </option>
                <option value="az" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'az') ? 'selected' : ''; ?>>
        Name: A to Z
    </option>
    <option value="za" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'za') ? 'selected' : ''; ?>>
        Name: Z to A
    </option>
            </select>
        </form>
    </div>

    <div class="product-grid scrollable-grid">
        <?php
        $sortOption = $_GET['sort'] ?? 'asc';
        
        if ($sortOption === 'asc' || $sortOption === 'desc') {
            $temp = [];
            foreach ($products as $index => $product) {
                $key = $product['price'] . "_" . $index;
                $temp[$key] = $product;
            }
        
            if ($sortOption === 'asc') {
                ksort($temp); 
            } else {
                krsort($temp); 
            }
        
            $products = array_values($temp);
        
        } elseif ($sortOption === 'az' || $sortOption === 'za') {
            $names = [];
            foreach ($products as $key => $product) {
                $names[$key] = $product['name'];
            }
        
            if ($sortOption === 'az') {
                asort($names); 
            } else {
                arsort($names); 
            }
        
            $sortedProducts = [];
            foreach ($names as $key => $name) {
                $sortedProducts[] = $products[$key];
            }
        
            $products = $sortedProducts;
        }
    
        ?>

        <?php
            foreach($products as $product): ?>

            <div class="product" data-id="running-shoe-<?php echo htmlspecialchars($product['id']); ?>">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['alt']); ?>" />

                <button class="heart-button" aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to wishlist">
                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/>
                    </svg>
                </button>

                <div class="product-details">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price" data-price="<?php echo htmlspecialchars($product['price']); ?>">
                        $<?php echo htmlspecialchars($product['price']); ?>
                    </p>
                </div>

                <button class="add-to-cart" aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to cart">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<section id="casual-shoes">
    <div class="text">
        <h2>Casual Shoes</h2>
        <form method="get">
            <label for="sort_casual">Sort by:</label>
            <select style="font-size: 1.2rem;" name="sort_casual" id="sort_casual" onchange="this.form.submit()">
                <option value="asc" <?php echo (isset($_GET['sort_casual']) && $_GET['sort_casual'] === 'asc') ? 'selected' : ''; ?>>
                    Price: Low to High
                </option>
                <option value="desc" <?php echo (isset($_GET['sort_casual']) && $_GET['sort_casual'] === 'desc') ? 'selected' : ''; ?>>
                    Price: High to Low
                </option>
                <option value="az" <?php echo (isset($_GET['sort_casual']) && $_GET['sort_casual'] === 'az') ? 'selected' : ''; ?>>
                    Name: A to Z
                </option>
                <option value="za" <?php echo (isset($_GET['sort_casual']) && $_GET['sort_casual'] === 'za') ? 'selected' : ''; ?>>
                    Name: Z to A
                </option>
            </select>
        </form>
    </div>

    <div class="product-grid scrollable-grid">
        <?php
        $sortOption = $_GET['sort_casual'] ?? 'asc';

        if ($sortOption === 'asc' || $sortOption === 'desc') {
            $temp = [];
            foreach ($casual_shoes as $index => $shoe) {
                $key = $shoe['price'] . "_" . $index;
                $temp[$key] = $shoe;
            }

            if ($sortOption === 'asc') {
                ksort($temp); 
            } else {
                krsort($temp); 
            }

            $casual_shoes = array_values($temp);
        } elseif ($sortOption === 'az' || $sortOption === 'za') {
            $names = [];
            foreach ($casual_shoes as $key => $shoe) {
                $names[$key] = $shoe['name'];
            }

            if ($sortOption === 'az') {
                asort($names); 
            } else {
                arsort($names); 
            }

            $sortedCasualShoes = [];
            foreach ($names as $key => $name) {
                $sortedCasualShoes[] = $casual_shoes[$key];
            }

            $casual_shoes = $sortedCasualShoes;
        }
        ?>

        <?php
            foreach($casual_shoes as $shoe): ?>
            <div class="product" data-id="casual-shoe-<?php echo htmlspecialchars($shoe['id']); ?>">
                <img src="<?php echo htmlspecialchars($shoe['image']); ?>" alt="<?php echo htmlspecialchars($shoe['alt']); ?>" />

                <button class="heart-button" aria-label="Add <?php echo htmlspecialchars($shoe['name']); ?> to wishlist">
                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/>
                    </svg>
                </button>

                <div class="product-details">
                    <h3><?php echo htmlspecialchars($shoe['name']); ?></h3>
                    <p class="price" data-price="<?php echo htmlspecialchars($shoe['price']); ?>">
                        $<?php echo htmlspecialchars($shoe['price']); ?>
                    </p>
                </div>

                <button class="add-to-cart" aria-label="Add <?php echo htmlspecialchars($shoe['name']); ?> to cart">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</section>


   
<section id="formal-shoes">
    <div class="text">
        <h2>Formal Shoes</h2>
        <form method="get">
            <label for="sort_formal">Sort by:</label>
            <select style="font-size: 1.2rem;" name="sort_formal" id="sort_formal" onchange="this.form.submit()">
                <option value="asc" <?php echo (isset($_GET['sort_formal']) && $_GET['sort_formal'] === 'asc') ? 'selected' : ''; ?>>
                    Price: Low to High
                </option>
                <option value="desc" <?php echo (isset($_GET['sort_formal']) && $_GET['sort_formal'] === 'desc') ? 'selected' : ''; ?>>
                    Price: High to Low
                </option>
                <option value="az" <?php echo (isset($_GET['sort_formal']) && $_GET['sort_formal'] === 'az') ? 'selected' : ''; ?>>
                    Name: A to Z
                </option>
                <option value="za" <?php echo (isset($_GET['sort_formal']) && $_GET['sort_formal'] === 'za') ? 'selected' : ''; ?>>
                    Name: Z to A
                </option>
            </select>
        </form>
    </div>

    <div class="product-grid scrollable-grid">
        <?php
        $sortOptionFormal = $_GET['sort_formal'] ?? 'asc';

        if ($sortOptionFormal === 'asc' || $sortOptionFormal === 'desc') {
            
            $tempFormal = [];
            foreach ($formal_shoes as $index => $shoe) {
                $key = $shoe['price'] . "_" . $index;
                $tempFormal[$key] = $shoe;
            }

            if ($sortOptionFormal === 'asc') {
                ksort($tempFormal); 
            } else {
                krsort($tempFormal); 
            }

            $formal_shoes = array_values($tempFormal);

        } elseif ($sortOptionFormal === 'az' || $sortOptionFormal === 'za') {
            
            $namesFormal = [];
            foreach ($formal_shoes as $key => $shoe) {
                $namesFormal[$key] = $shoe['name'];
            }

            if ($sortOptionFormal === 'az') {
                asort($namesFormal); 
            } else {
                arsort($namesFormal); 
            }

            $sortedFormalShoes = [];
            foreach ($namesFormal as $key => $name) {
                $sortedFormalShoes[] = $formal_shoes[$key];
            }

            $formal_shoes = $sortedFormalShoes;
        }

        //shfaqja e produkteve te sortuara
        foreach ($formal_shoes as $shoe): ?>
            <div class="product" data-id="formal-shoe-<?php echo htmlspecialchars($shoe['id']); ?>">
                <img src="<?php echo htmlspecialchars($shoe['image']); ?>" alt="<?php echo htmlspecialchars($shoe['alt']); ?>" />

                <button class="heart-button" aria-label="Add <?php echo htmlspecialchars($shoe['name']); ?> to wishlist">
                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/>
                    </svg>
                </button>

                <div class="product-details">
                    <h3><?php echo htmlspecialchars($shoe['name']); ?></h3>
                    <p class="price" data-price="<?php echo htmlspecialchars($shoe['price']); ?>">
                        $<?php echo htmlspecialchars($shoe['price']); ?>
                    </p>
                </div>

                <button class="add-to-cart" aria-label="Add <?php echo htmlspecialchars($shoe['name']); ?> to cart">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</section>


  <footer class="footer">
        <div class="container">
            <p>© 2024 Laced Lifestyle. All Rights Reserved.</p>
        </div>
    </footer>




</body>
</html>
