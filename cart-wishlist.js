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



document.addEventListener('DOMContentLoaded', () => {
    updateCartAndWishlist();

    if (window.location.pathname.includes('cart.html')) {
        const removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
        removeFromCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.getAttribute('data-Id');
                updateLocalStorage('cartItems', `${productId},`, 'remove');
                updateCartAndWishlist();
               
            });
        });
    }

    if (window.location.pathname.includes('wishlist.html')) {
        const removeFromWishlistButtons = document.querySelectorAll('.remove-from-wishlist');
        removeFromWishlistButtons.forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.getAttribute('data-Id');
                updateLocalStorage('wishlistItems', `${productId},`, 'remove');
                updateCartAndWishlist();
               
            });
        });
    }
});
