document.addEventListener("DOMContentLoaded", () => {
    const cartModal = document.getElementById("cart-modal");
    const closeModalButton = document.querySelector(".close-button");
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const cartItems = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const checkoutButton = document.getElementById("checkout-button");

    let cart = [];

    const toggleModal = () => {
        cartModal.classList.toggle("hidden");
        cartModal.classList.toggle("visible");
    };
    const updateCartDisplay = () => {
        cartItems.innerHTML = "";
        let total = 0;

        cart.forEach(item => {
            const li = document.createElement("li");
            li.textContent = `${item.name} - $${item.price.toFixed(2)} (x${item.quantity})`;
            cartItems.appendChild(li);

            total += item.price * item.quantity;
        });

        cartTotal.textContent = total.toFixed(2);
    };

    addToCartButtons.forEach(button => {
        button.addEventListener("click", () => {
            const productName = button.getAttribute("data-product");
            const productPrice = parseFloat(button.getAttribute("data-price"));

            const existingItem = cart.find(item => item.name === productName);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ name: productName, price: productPrice, quantity: 1 });
            }

            updateCartDisplay();
        });
    });

    closeModalButton.addEventListener("click", toggleModal);

    document.body.addEventListener("click", (event) => {
        if (event.target.matches(".cart-button")) {
            toggleModal();
        }
    });

    checkoutButton.addEventListener("click", () => {
        if (cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }

        alert("Thank you for your purchase!");
        cart = [];
        updateCartDisplay();
        toggleModal();
    });
});
document.getElementById('cart-button').addEventListener('click', function() {

    const cartContainer = document.getElementById('cart-container');
    cartContainer.style.display = cartContainer.style.display === 'none' || cartContainer.style.display === '' ? 'block' : 'none';
    
    this.classList.toggle('clicked');
});


document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        this.classList.toggle('clicked');
        const itemName = this.getAttribute('data-product');
        addToCart(itemName);
        const itemPrice = this.getAttribute('data-price');
        addToCart(itemPrice);
    });
});

function addToCart(itemName) {
    const cartList = document.getElementById('cart-list');
    
    const li = document.createElement('li');
    li.textContent = itemName;

    
    cartList.appendChild(li);
}

document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login-button");
    const modal = document.getElementById("login-modal");
    const closeModal = document.getElementById("close-modal");

    // Show modal
    loginButton.addEventListener("click", () => {
        modal.style.display = "flex";
    });

    // Close modal
    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const searchButton = document.getElementById('search-button');
    const searchContainer = document.getElementById('search-container');
    const searchInput = document.getElementById('search-input');

    // Toggle visibility of search bar
    searchButton.addEventListener('click', () => {
        searchContainer.classList.toggle('hidden');
        if (!searchContainer.classList.contains('hidden')) {
            searchInput.focus(); // Focus input when visible
        }
    });

    // Handle product search on "Enter" key press
    searchInput.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            const query = searchInput.value.toLowerCase().trim();
            if (query) {
                // Navigate to product page or show alert if not found
                const products = {
                    "running shoes": "./Products.html#running-shoes",
                    "casual sneakers": "./Products.html#casual-sneakers",
                    "formal shoes": "./Products.html#formal-shoes"
                };

                if (products[query]) {
                    window.location.href = products[query];
                } else {
                    alert('Product not found');
                }
            }
        }
    });
});

