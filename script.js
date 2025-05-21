document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('login-modal');
    const loginButton = document.getElementById('login-button');
    const closeModalButton = document.getElementById('close-modal');
    const signUpLink = document.getElementById('sign-up-link');
    const loginLink = document.getElementById('login-link');
    const loginForm = document.getElementById('login-form');
    const signUpForm = document.getElementById('sign-up-form');
    const userAccount = document.getElementById('user-account');
    const loginFormElement = document.querySelector('#login-form-element');
    const signUpFormElement = document.querySelector('#sign-up-form-element');
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');  



    loginButton.addEventListener('click', () => {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });


    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });


    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
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


    loginFormElement.addEventListener('submit', (event) => {
        event.preventDefault();
        const username = loginFormElement.querySelector('input[name="username"]').value.trim();
        const password = loginFormElement.querySelector('input[name="password"]').value.trim();

        if (validateLogin(username, password)) {
            modal.style.display = 'none';
            loginButton.classList.add('hidden');
            userAccount.classList.remove('hidden');
        } else {
            alert('Invalid login credentials. Username and password must meet the requirements.');
        }
    });


    signUpFormElement.addEventListener('submit', (event) => {
        event.preventDefault();
        const email = signUpFormElement.querySelector('input[name="email"]').value.trim();
        const password = signUpFormElement.querySelector('input[name="password"]').value.trim();
        const confirmPassword = signUpFormElement.querySelector('input[name="confirm-password"]').value.trim();

        if (validateSignup(email, password, confirmPassword)) {
            modal.style.display = 'none';
            alert('Account created successfully!');
            loginButton.classList.add('hidden');
            userAccount.classList.remove('hidden');
        } else {
            alert('Signup failed. Please ensure all fields meet the requirements.');
        }
    });


    togglePasswordButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const passwordInput = button.previousElementSibling;  
            const isPasswordVisible = passwordInput.type === 'text';
            passwordInput.type = isPasswordVisible ? 'password' : 'text';  
            button.querySelector('i').classList.toggle('fa-eye-slash');  
        });
    });


    function validateLogin(username, password) {
        const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/; 
        const minPasswordLength = 6;

        return usernameRegex.test(username) && password.length >= minPasswordLength;
    }


    function validateSignup(email, password, confirmPassword) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/; 

        if (!emailRegex.test(email)) {
            alert('Invalid email format.');
            return false;
        }

        if (!passwordRegex.test(password)) {
            alert('Password must be at least 6 characters long and include at least one letter and one number.');
            return false;
        }

        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return false;
        }

        return true;
    }
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
    
