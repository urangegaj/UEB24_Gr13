// Initialize session state
let sessionState = {
    isLoggedIn: false,
    user: null
};

// Fetch session state from server
async function initializeSession() {
    try {
        const response = await fetch('includes/get_session_state.php');
        if (!response.ok) {
            throw new Error('Failed to fetch session state');
        }
        const data = await response.json();
        sessionState = data;
        
        // Update UI based on session state
        updateUIForSessionState();
    } catch (error) {
        console.error('Error initializing session:', error);
    }
}

// Update UI elements based on session state
function updateUIForSessionState() {
    const loginLinks = document.querySelectorAll('.login-link');
    const profileLinks = document.querySelectorAll('.profile-link');
    const logoutLinks = document.querySelectorAll('.logout-link');
    
    if (sessionState.isLoggedIn) {
        // User is logged in
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
        // User is not logged in
        loginLinks.forEach(link => link.style.display = 'block');
        profileLinks.forEach(link => link.style.display = 'none');
        logoutLinks.forEach(link => link.style.display = 'none');
    }
}

// Initialize session when the page loads
document.addEventListener('DOMContentLoaded', initializeSession);

// Export session state for use in other scripts
window.getSessionState = () => sessionState;
window.isLoggedIn = () => sessionState.isLoggedIn;
window.getCurrentUser = () => sessionState.user; 