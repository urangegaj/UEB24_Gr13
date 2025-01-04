document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('login-modal');
    const loginButton = document.getElementById('login-button');
    const closeModalButton = document.getElementById('close-modal');
    const signUpLink = document.getElementById('sign-up-link');
    const loginLink = document.getElementById('login-link');
    const loginForm = document.getElementById('login-form');
    const signUpForm = document.getElementById('sign-up-form');
    const userAccount = document.getElementById('user-account');

    loginButton.onclick = function() {
        modal.style.display = 'block';
    };

    closeModalButton.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    signUpLink.onclick = function() {
        loginForm.classList.add('hidden');
        signUpForm.classList.remove('hidden');
    };

    loginLink.onclick = function() {
        signUpForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
    };

    loginButton.addEventListener('click', function () {
        modal.style.display = 'block';
        const loginFormElement = document.querySelector('#login-form form');
        loginFormElement.addEventListener('submit', function (event) {
            event.preventDefault(); 
            modal.style.display = 'none'; 
            loginButton.classList.add('hidden'); 
            userAccount.classList.remove('hidden'); 
        });
    });
});
