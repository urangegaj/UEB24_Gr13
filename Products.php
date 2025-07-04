

<?php
require_once 'error_handling.php';
/*
//disa rraste testimi
$emri = "";
if (empty($emri)) {
    trigger_error("Emri nuk është i plotësuar!", E_USER_NOTICE);
}

$pagesa = -50;

if ($pagesa < 0) {
    trigger_error("Shuma e pagesës nuk mund të jetë negative!", E_USER_ERROR);
}*/
?>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

class Product {
    public $id;
    public $image;
    public $name;
    public $price;
    public $category;
    public $description;


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

        <button class='add-to-cart {$cartClass}' data-id='{$this->id}' data-type='cart'>{$cartText}</button>
<button class='heart-button {$wishlistClass}' data-id='{$this->id}' data-type='wishlist'>
    <svg viewBox='0 0 24 24' width='22px' height='22px' xmlns='http://www.w3.org/2000/svg'>
                    <path fill-rule='evenodd' clip-rule='evenodd' d='M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z'/>
                </svg>
</button>

        

    </div>";
}

}

   
 




$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

$products = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = new Product(
            $row['id'],
            $row['image'],
            $row['name'],
            $row['price'],
            $row['category'],
            $row['description']
        );
    }
} else {
    echo "<p>No products found in database.</p>";
}
   



if (isset($_POST['cartId'])) {
    $id = $_POST['cartId'];
    $productCategory = $_POST['category'] ?? '';
    if (isset($_SESSION['cartItems'][$id])) {
        unset($_SESSION['cartItems'][$id]);
        $_SESSION['message'] = "Item removed from cart!";
    } else {
        $_SESSION['cartItems'][$id] = true;
        $_SESSION['message'] = "Item added to cart!";
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "#$productCategory");
    exit();
}

if (isset($_POST['wishlistId'])) {
    $id = $_POST['wishlistId'];
    $productCategory = $_POST['category'] ?? '';
    if (isset($_SESSION['wishlistItems'][$id])) {
        unset($_SESSION['wishlistItems'][$id]);
        $_SESSION['message'] = "Item removed from favourites!";
    } else {
        $_SESSION['wishlistItems'][$id] = true;
        $_SESSION['message'] = "Item added to favourites!";
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
     <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-styles.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   
     
  
    <header id="navbar" class="header">
        <div class="container1">
            <div class="logo" >
            <img src="images/logo.png" alt="Laced Lifestyle Logo">
            <h1>Laced Lifestyle</h1>
        </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="./About.php">About</a></li>
                    <li><a href="./contact.php">Contact</a></li>
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

            <form id="searchForm" style="margin-left: 20px;">
    <input 
        type="text" 
        id="searchInput" 
        placeholder="Search products..." 
        style="padding: 6px 15px; border-radius: 20px; border: 1px solid #ccc; font-size: 1rem;">
</form>
            </nav>
        </div>
    
    </header>
    </head>

<body>

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
    <?php if (isset($_SESSION['message'])): ?>
    <div id="mesazhi" class="cart-message">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

        <?php
        
        $categories = [
            "running-shoes" => ["label" => "Running Shoes", "sort_param" => "sort_running"],
            "casual-shoes" => ["label" => "Casual Shoes", "sort_param" => "sort_casual"],
            "formal-shoes" => ["label" => "Formal Shoes", "sort_param" => "sort_formal"]
        ];

        foreach ($categories as $cat => $data) {
            $categoryProducts = array_filter($products, fn($p) => $p->category === $cat);
            $categoryProducts = array_values($categoryProducts);
            $sortOption = $_GET[$data['sort_param']] ?? '';

            
            if ($sortOption) {
                if (in_array($sortOption, ['asc', 'desc'])) {
                    $temp = [];
                    foreach ($categoryProducts as $index => $product) {
                        $key = $product->price . "_" . $index;
                        $temp[$key] = $product;
                    }
                    $sortOption === 'asc' ? ksort($temp) : krsort($temp);
                    $categoryProducts = array_values($temp);
                } elseif (in_array($sortOption, ['az', 'za'])) {
                    $names = [];
                    foreach ($categoryProducts as $key => $product) {
                        $names[$key] = $product->name;
                    }
                    $sortOption === 'az' ? asort($names) : arsort($names);
                    $sorted = [];
                    foreach ($names as $key => $name) {
                        $sorted[] = $categoryProducts[$key];
                    }
                    $categoryProducts = $sorted;
                }
            }

            echo "<section id='{$cat}'>";
            echo "<div class='text' style='display:flex;justify-content:space-between'>";
            echo "<h2>{$data['label']}</h2>";
            
            echo "<form method='get'>";
            echo "<label for='sort'>Sort by:</label>";
            echo "<select style='font-size: 1.2rem;' name='{$data['sort_param']}' onchange='this.form.submit()'>";
            echo "<option value='asc' " . ($sortOption === 'asc' ? 'selected' : '') . ">Price: Low to High</option>";
            echo "<option value='desc' " . ($sortOption === 'desc' ? 'selected' : '') . ">Price: High to Low</option>";
            echo "<option value='az' " . ($sortOption === 'az' ? 'selected' : '') . ">Name: A to Z</option>";
            echo "<option value='za' " . ($sortOption === 'za' ? 'selected' : '') . ">Name: Z to A</option>";
            echo "</select>";
            echo "</form>";
            echo "</div>";

            echo "<div class='product-grid scrollable-grid '>";
            foreach ($categoryProducts as $product) {
                echo $product->render();
            }
            echo "</div></section>";
        }
        ?>
    </div>


    <!-- perdorimi i incude -->
     <?php include 'footer.php'; ?>



  <div id="productModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="modalClose" class="modal-close">&times;</span>
    <div id="modalBody">
      <!-- Detajet e produktit do ngarkohen këtu me AJAX -->
    </div>
  </div>
</div>




    <script>

        $(document).ready(function(){
    $(".add-to-cart, .heart-button").click(function(e){
        e.preventDefault();
        var button = $(this);
        var id = button.data("id");
        var type = button.data("type");

        $.ajax({
            url: 'actions.php',
            type: 'POST',
            data: (type === 'cart') ? {cartId: id} : {wishlistId: id},
            success: function(response){
                var data = JSON.parse(response);
                
         
                $("#mesazhi").remove();
                $(".products").prepend("<div id='mesazhi' class='cart-message'>" + data.message + "</div>");

               
                if(type === 'cart'){
                    $("#cart-link span").text(data.cartCount);
                    button.toggleClass("in-cart");
                    button.text(button.hasClass("in-cart") ? "Remove from Cart" : "Add to Cart");
                } else {
                    $("#wishlist-link span").text(data.wishlistCount);
                    button.toggleClass("selected");
                }
            }
        });
    });
});
                setTimeout(() => {
                    const mesazhi = document.getElementById('mesazhi');
                    if(mesazhi){
                        mesazhi.style.opacity='0';
                        setTimeout(() => {
                            mesazhi.remove();
                            
                        }, 500);
                    }
                    

                }, 2500);

                
document.getElementById('searchInput').addEventListener('input', async function () {
    const searchTerm = this.value.trim();

    try {
        const response = await fetch('search-products.php?query=' + encodeURIComponent(searchTerm));
        if (!response.ok) throw new Error('Network error');

        const data = await response.json();
        const container = document.querySelector('.products');
        container.innerHTML = '';

        if (data.products.length === 0) {
            container.innerHTML = '<p>No matching products found.</p>';
            return;
        }

        data.products.forEach(product => {
            const productHTML = `
                <div class="product" data-id="${product.id}">
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-details">
                        <h3>${product.name}</h3>
                        <p class="price">$${product.price}</p>
                    </div>
                    <button class="heart-button ${product.inWishlist ? 'selected' : ''}" data-id="${product.id}">
                        <svg viewBox='0 0 24 24' width='22px' height='22px' xmlns='http://www.w3.org/2000/svg'>
                            <path fill-rule='evenodd' clip-rule='evenodd' d='M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z'/>
                        </svg>
                    </button>
                    <button class="add-to-cart ${product.inCart ? 'in-cart' : ''}" data-id="${product.id}">
                        ${product.inCart ? 'Remove from Cart' : 'Add to Cart'}
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', productHTML);
        });

        attachButtonListeners();

    } catch (error) {
        console.error('Error:', error);
    }
});

function attachButtonListeners() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function () {
            const productId = this.getAttribute('data-id');
            const formData = new FormData();
            formData.append('cartId', productId); 

            try {
                const response = await fetch('actions.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                // Toggle class dhe tekstin
                if (result.message.includes('removed')) {
                    this.classList.remove('in-cart');
                    this.textContent = 'Add to Cart';
                } else {
                    this.classList.add('in-cart');
                    this.textContent = 'Remove from Cart';
                }

                if (result.cartCount !== undefined) {
                    document.querySelector('#cartCount').textContent = result.cartCount;
                }

                showMessage(result.message); 

            } catch (error) {
                console.error('Cart toggle failed:', error);
            }
        });
    });


    document.querySelectorAll('.heart-button').forEach(button => {
        button.addEventListener('click', async function () {
            const productId = this.getAttribute('data-id');
            const formData = new FormData();
            formData.append('wishlistId', productId);
            try {
                const response = await fetch('actions.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                this.classList.toggle('selected');

                if (result.wishlistCount !== undefined) {
                    document.querySelector('#wishlistCount').textContent = result.wishlistCount;
                }

                showMessage(result.message);
            } catch (error) {
                console.error('Wishlist toggle failed:', error);
            }
        });
    });
}








$(document).on('click', '.product img, .product h3, .product .price', function(e) {
    e.stopPropagation(); 

    const productId = $(this).closest('.product').data('id');
    console.log('Klikuar produkti me ID:', productId);

   
    $('#modalBody').html('');

   
    const uniqueParam = new Date().getTime(); 

    $.ajax({
        url: 'product-details.php',
        type: 'GET',
        data: { id: productId, timestamp: uniqueParam }, 
        cache: false, 
        success: function(data) {
            $('#modalBody').html(data);  
            $('#productModal').fadeIn(200); 
        },
        error: function() {
            alert('Nuk u mundësua ngarkimi i detajeve të produktit.');
        }
    });
});




// Mbyll modal kur klikohet mbi 'x'
$('#modalClose').on('click', function() {
    $('#productModal').fadeOut(200, function() {
        $('#modalBody').html('');
    });
});

// Mbyll modal kur klikohet jashtë përmbajtjes së modalit
$('#productModal').on('click', function(e) {
    if (e.target.id === 'productModal') {
        $('#productModal').fadeOut(200, function() {
            $('#modalBody').html('');
        });
    }
});







                </script>

</body>
</html>