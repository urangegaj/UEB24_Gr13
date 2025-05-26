document.addEventListener('DOMContentLoaded', function() {
    const loginButton = document.getElementById('login-button');
    const loginModal = document.getElementById('login-modal');
    const closeModal = document.getElementById('close-modal');
    const signUpLink = document.getElementById('sign-up-link');
    const loginLink = document.getElementById('login-link');
    const loginForm = document.getElementById('login-form');
    const signUpForm = document.getElementById('sign-up-form');
    const userAccount = document.getElementById('user-account');
    const profileButton = document.getElementById('profile-button');
    const accountDropdown = document.getElementById('account-dropdown');
    const logoutButton = document.getElementById('logout-button');
    const profileLink = document.getElementById('profile-link');

    function updateUI(loggedIn) {
        if (loggedIn) {
            loginButton.style.display = 'none';
            userAccount.classList.remove('hidden');
            loginModal.classList.remove('show');
        } else {
            loginButton.style.display = 'block';
            userAccount.classList.add('hidden');
            accountDropdown.classList.add('hidden');
        }
    }

    updateUI(window.isLoggedIn);

    loginButton.addEventListener('click', () => {
        loginModal.classList.add('show');
        document.getElementById('login-form-element').reset();
        document.getElementById('sign-up-form-element').reset();
    });

    closeModal.addEventListener('click', () => {
        loginModal.classList.remove('show');
    });

    window.addEventListener('click', (e) => {
        if (e.target === loginModal) {
            loginModal.classList.remove('show');
        }
    });

    signUpLink.addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.classList.add('hidden');
        signUpForm.classList.remove('hidden');
    });

    loginLink.addEventListener('click', (e) => {
        e.preventDefault();
        signUpForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
    });

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });

    document.getElementById('login-form-element').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('models/login.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            console.log('Login response:', data); 
            
            if (data.success) {
                e.target.reset();
                window.isLoggedIn = true; 
                updateUI(true);
            } else {
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = data.message || 'Invalid username or password';
                e.target.appendChild(errorMessage);
                
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            }
        } catch (error) {
            console.error('Login error:', error); // Debug log
            const errorMessage = document.createElement('div');
            errorMessage.className = 'error-message';
            errorMessage.textContent = 'An error occurred. Please try again.';
            e.target.appendChild(errorMessage);
            
            setTimeout(() => {
                errorMessage.remove();
            }, 3000);
        }
    });

    document.getElementById('sign-up-form-element').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('models/signup.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            console.log('Signup response:', data);
            
            if (data.success) {
                e.target.reset();
                alert('Registration successful! Please login.');
                loginForm.classList.remove('hidden');
                signUpForm.classList.add('hidden');
            } else {
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = data.message || 'Registration failed';
                e.target.appendChild(errorMessage);
                
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            }
        } catch (error) {
            console.error('Signup error:', error);
            const errorMessage = document.createElement('div');
            errorMessage.className = 'error-message';
            errorMessage.textContent = 'An error occurred. Please try again.';
            e.target.appendChild(errorMessage);
            
            setTimeout(() => {
                errorMessage.remove();
            }, 3000);
        }
    });

    profileButton.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        accountDropdown.classList.toggle('hidden');
    });

    logoutButton.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        try {
            const response = await fetch('models/logout.php', {
                credentials: 'same-origin'
            });
            
            const data = await response.json();
            
            if (data.success) {
                updateUI(false);
                
                window.location.reload();
            } else {
                alert('Logout failed. Please try again.');
            }
        } catch (error) {
            alert('An error occurred during logout. Please try again.');
        }
    });

    document.addEventListener('click', (e) => {
        if (!profileButton.contains(e.target) && !accountDropdown.contains(e.target)) {
            accountDropdown.classList.add('hidden');
        }
    });

    const scrollToTopButton = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopButton.style.display = 'block';
        } else {
            scrollToTopButton.style.display = 'none';
        }
    });

    scrollToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    profileLink.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = 'profile.php';
    });
});

$(document).ready(function () {
    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            
            $("#scrollToTop").fadeIn();
        } else {
            $("#scrollToTop").fadeOut();
        }
    });
    $("#scrollToTop").click(function () {
        
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }); 
    });

    $(document).ready(function () {
        
        $("#search-button").click(function () {
            $("#search-container").fadeToggle();
            
        });
    });
    
