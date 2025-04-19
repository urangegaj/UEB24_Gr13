<?php
session_start();

require_once 'productData.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $id = $_POST['product_id'];
        $_SESSION['cartItems'][$id] = true;
        $_SESSION['message'] = "Item added to cart!";
        header("Location: wishlist.php");
        exit();
    }

    if (isset($_POST['remove'])) {
        $id = $_POST['product_id'];
        unset($_SESSION['wishlistItems'][$id]); 
        header("Location: wishlist.php");
        exit();
    }
}

$wishlistIds = array_keys($_SESSION['wishlistItems'] ?? []);
$wishlistItems = array_filter($products, fn($p) => in_array($p->id, $wishlistIds));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <title>Favourites</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        main {
            padding: 20px;
            text-align: center;
        }
        
     
        
       
        #explore-btn {
            padding: 15px 30px;
            background-color: #f5f5f5;
            color: #333;
            font-size: 18px;
            cursor: pointer;
            border: 2px solid #ccc;
            border-radius: 2px;
            text-transform: uppercase;
            transition: background-color 0.3s, border-color 0.3s;
            box-sizing: border-box;
        }
        
        #explore-btn:hover {
            background-color: #add1db;
            border-color: #888;
        }
        
       
        #wishlist-items {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        
       
        .wishlist-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            gap: 20px; 
        }
        
        .wishlist-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .wishlist-item-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .wishlist-item h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .wishlist-item p {
            color: #28a745;
            font-size: 16px;
        }
        
        
        .product-image img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
       
        .product-info h3 {
            font-size: 18px;
            color: #333;
            margin: 0 0 10px 0;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
       
        .product-info p.price {
            font-size: 16px;
            color: #28a745;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .remove-from-wishlist {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        
        .remove-from-wishlist:hover {
            background-color: #d32f2f;
        }

        .add-to-cart {
    background-color: #4CAF50; 
    color: white;            
    font-size: 16px;         
    padding: 10px 20px;        
    border: none;              
    border-radius: 5px;        
    cursor: pointer;          
    transition: background-color 0.3s ease; 
}

button.add-to-cart:hover {
    background-color: #45a049; 
}


        .no-favorites-message {
            margin-top: 20px;
            font-size: 18px;
            color: #888;
            font-style: italic;
            text-align: center;
        }
        
        
        
        @media (max-width: 768px) {
            #wishlist-items {
                flex-direction: column;
            }
        
        }
        .divider {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0; 
        }

}
            </style>
        </head>
        
        <body>
            <header class="header">
                <div class="container1">
                    <div class="logo" >
                    <img src="images/logo.png" alt="Laced Lifestyle Logo">
                    <h1> Laced Lifestyle</h1>
                </div>
                    <nav>
                        <ul class="nav-links">
                            <li><a href="./index.html">Home</a></li>
                            <li><a href="./Products.php">Products</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="./Contact.html">Contact</a></li>
                        </ul>
                        <div id="navbar-tools">
                            <a id="cart-link" href="cart.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                                  </svg>
                                  <span><?php echo count($_SESSION['cartItems'] ?? []); ?></span>
                            </a>
                            <a id="wishlist-link" href="wishlist.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                  </svg>
                                  <span><?php echo count($_SESSION['wishlistItems'] ?? []); ?></span>
                            </a>
                        </div>
                    </nav>
                </div>
            </header>
        
        
            <main>
<<<<<<< HEAD:wishlist.html
                <h1>Favourites</h1>
                <p>SAVE YOUR FAVOURITE ITEMS</p>
                <p>Want to save the items that you love? Just click on the heart symbol beside the item and it will appear here.</p>
        
                <button id="explore-btn" onclick="window.location.href='./Products.php';">Explore Now</button>
        
                <hr class="divider">
        
                <h2>Your Saved Favourites</h2>
                <ul id="wishlist-items"></ul> 
        
                <div id="no-favorites-message" class="no-favorites-message" style="display: none;">
                    <p>No items have been added to your Favourites yet.</p>
                </div>
            </main>
            <div class="cart-message" style="display:none;"></div>
=======
            <h1>Favourites</h1>
    <p>SAVE YOUR FAVOURITE ITEMS</p>
    <p>Want to save the items that you love? Just click on the heart symbol beside the item and it will appear here.</p>
>>>>>>> deeba08300a494b89ebb5a9755c5d706468bd497:wishlist.php

    <?php if (empty($wishlistItems)): ?>
        <button id="explore-btn" onclick="window.location.href='./Products.php';">Explore Now</button>
    <?php endif; ?>

    <hr class="divider">

    <?php if (isset($_SESSION['message'])): ?>
    <div id="mesazhi" class="cart-message">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>


    <h2>Your Saved Favourites</h2>
    <ul id="wishlist-items">
        <?php
        if (!empty($wishlistItems)) {
            foreach ($wishlistItems as $item) {
                echo "
                <li class='wishlist-item'>
                    <div class='product-card'>
                        <div class='product-image'>
                            <img src='{$item->image}' alt='{$item->name}'>
                            <p class='price'>{$item->price}</p>
                        </div>
                        <div class='product-info'>
                            <h3>{$item->name}</h3>
                            <form method='post'>
                                <input type='hidden' name='product_id' value='{$item->id}'>
                                <button class='button remove-from-wishlist' name='remove'>Remove from Favourites</button>
                            </form>
                            <form method='post'>
                                <input type='hidden' name='product_id' value='{$item->id}'>
                                <button class='button add-to-cart' name='add_to_cart'>Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </li>";
            }
        } else {
            echo "<div class='no-favorites-message'><p>No items have been added to your Favourites yet.</p></div>";
        }
        ?>
    </ul>


 </main>
        

        
            <footer class="footer">
                <div class="container">
                    <p>© 2024 Laced Lifestyle. All Rights Reserved.</p>
                </div>
            </footer>
            

            <script>
                setTimeout(() => {
                    const mesazhi = document.getElementById('mesazhi');
                    if(mesazhi){
                        mesazhi.style.opacity='0';
                        setTimeout(() => {
                            mesazhi.remove();
                            
                        }, 500);
                    }
                    
                }, 2500);
                </script>

</body>





</html>