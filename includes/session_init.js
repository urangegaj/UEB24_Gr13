let sessionState = {
    isLoggedIn: false,
    user: null
};

async function initializeSession() {
    try {
        const response = await fetch('includes/get_session_state.php');
        if (!response.ok) {
            throw new Error('Failed to fetch session state');
        }
        const data = await response.json();
        sessionState = data;
        
        updateUIForSessionState();
    } catch (error) {
        console.error('Error initializing session:', error);
    }
}

function updateUIForSessionState() {
    const loginLinks = document.querySelectorAll('.login-link');
    const profileLinks = document.querySelectorAll('.profile-link');
    const logoutLinks = document.querySelectorAll('.logout-link');
    
    if (sessionState.isLoggedIn) {
        loginLinks.forEach(link => link.style.display = 'none');
        profileLinks.forEach(link => {
            link.style.display = 'block';
            if (sessionState.user && sessionState.user.profile_picture) {
                const img = link.querySelector('img');
                if (img) {
                    img.src = sessionState.user.profile_picture;
                }
            }
        });
        logoutLinks.forEach(link => link.style.display = 'block');
    } else {
        loginLinks.forEach(link => link.style.display = 'block');
        profileLinks.forEach(link => link.style.display = 'none');
        logoutLinks.forEach(link => link.style.display = 'none');
    }
}

document.addEventListener('DOMContentLoaded', initializeSession);

window.getSessionState = () => sessionState;
window.isLoggedIn = () => sessionState.isLoggedIn;
window.getCurrentUser = () => sessionState.user;