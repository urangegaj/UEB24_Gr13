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
