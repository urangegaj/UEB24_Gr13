<?php
 session_start();

 if (!isset($_SESSION['cartItems'])) {
    $_SESSION['cartItems'] = [];
}
if (!isset($_SESSION['wishlistItems'])) {
    $_SESSION['wishlistItems'] = [];
}

require_once 'productData.php';


if (isset($_POST['checkout'])) {
    header("Location: bin.php");
    exit();
}


$cartIds = array_keys($_SESSION['cartItems'] ?? []);
$cartItems = array_filter($products, fn($p) => in_array($p->id, $cartIds));


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <script src="cart-wishlist.js"></script>
    <title>Shopping Cart</title>
    <style>
        main {
            padding: 20px;
            text-align: center;
        }

        #cart-items {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            flex-direction: column;
            gap: 10px;
        }

        .cart-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cart-item h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .cart-item p {
            color: #28a745;
            font-size: 16px;
        }

        .quantity-control {
            display: flex;
            gap: 5px;
            align-items: center;
            margin: 10px 0;
        }

        .quantity-control button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
        }

        .quantity-control button:hover {
            background-color: #0056b3;
        }

        .quantity-control span {
            font-size: 16px;
        }

        .remove-from-cart {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .remove-from-cart:hover {
            background-color: #d32f2f;
        }

        #total-price {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
            color: #333;
        }
        #checkout-btn {
    padding: 15px 40px;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    border: none;
    font-size: 18px;
    cursor: pointer;
    border-radius: 8px;
    text-align: center;
    display: inline-block;
    width: fit-content;
    max-width: 100%;
    margin: 20px auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease-in-out;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
}

#checkout-btn:hover {
    transform: scale(1.05);
    background: linear-gradient(135deg, #3e8e41, #388e3c);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

        #empty-cart-message {
            margin-top: 20px;
            font-size: 18px;
            color: #777;
        }

        #continue-shopping-btn {
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
        
        #continue-shopping-btn:hover {
            background-color: #add1db;
            border-color: #888;
        }
       
        #cart-actions {
            text-align: center;
            margin-top: 20px;
        }

    </style>


</head>

<body>
    <header class="header">
        <div class="container1">
            <div class="logo" >
            <img src="images/logo.png" alt="Laced Lifestyle Logo">
            <h1>Laced Lifestyle</h1>
        </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./Products.php">Products</a></li>
                    <li><a href="/About.html">About</a></li>
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
    <h1>Your Cart</h1>
    <div id="cart-container">
        <ul id="cart-items">
        <?php
    if (isset($_SESSION['cartItems']) && count($_SESSION['cartItems']) > 0) {
        $totalPrice = 0;
        foreach ($_SESSION['cartItems'] as $id => $true) {
            foreach ($products as $product) {
                if ($product->id === $id) {
                    echo "<li class='cart-item'>
                            <img src='{$product->image}' alt='{$product->name}'>
                            <div class='cart-item-details'>
                                <h3>{$product->name}</h3>
                                <p class='price'>\$" . number_format($product->price, 2) . "</p>
                               <button class='remove-from-cart' data-id='{$product->id}'>Remove</button>

                            </div>
                          </li>";
                    $totalPrice += floatval($product->price);
                    break;
                }
            }
        }
        echo "<div id='total-price'>Total Price: \$" . number_format($totalPrice, 2) . "</div>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
?>
 

        </ul>

        
    <?php if (isset($_SESSION['message'])): ?>
    <div id="mesazhi" class="cart-message">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

        <?php if (!empty($_SESSION['cartItems'])): ?>
            <div id="cart-actions">
                <form method="post" action="cart.php">
                    <button onclick="window.location.href='bin.php'"id="checkout-btn" type="submit" name="checkout">Proceed to Checkout</button>
                </form>
            </div>
        <?php else: ?>
            <div id="empty-cart-message">
            
                <button  id="continue-shopping-btn" onclick="window.location.href='products.php';">Continue Shopping</button>
            </div>
        <?php endif; ?>
    </div>
    </main>

    <?php include 'footer.php'; ?>

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
            

                
document.addEventListener('DOMContentLoaded', () => {
    const removeButtons = document.querySelectorAll('.remove-from-cart');
    removeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id');

            fetch('actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `removeFromCartId=${productId}`
            })
            .then(res => res.json())
            .then(data => {
                // Hiq artikullin nga DOM
                const item = button.closest('.cart-item');
                if (item) item.remove();

                // Përditëso numrin në ikonën e shportës
                const cartLink = document.querySelector('#cart-link span');
                if (cartLink) cartLink.textContent = data.cartCount;

                // Përditëso çmimin total
                const totalEl = document.getElementById('total-price');
                if (data.cartCount > 0 && totalEl) {
                    totalEl.textContent = `Total Price: $${parseFloat(data.totalPrice).toFixed(2)}`;
                } else if (totalEl) {
                    totalEl.remove();
                    document.getElementById('cart-actions')?.remove();
                    document.getElementById('cart-container').innerHTML += `
                        <div id="empty-cart-message">
                            <button id="continue-shopping-btn" onclick="window.location.href='products.php';">Continue Shopping</button>
                        </div>`;
                }
            });
        });
    });
});


                </script>
</body>
</html>