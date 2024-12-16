// Register some sample user credentials for demonstration
const registeredUsers = [
    { email: "test@example.com", password: "password123" }, // Sample credentials
];

// Save registered user data to localStorage for persistence
if (!localStorage.getItem("users")) {
    localStorage.setItem("users", JSON.stringify(registeredUsers));
}

// Handle login form submission
document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    // Get user input
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Retrieve registered users from localStorage
    const users = JSON.parse(localStorage.getItem("users"));

    // Check if the user exists and password matches
    const user = users.find(user => user.email === email && user.password === password);

    if (user) {
        alert("Login successful!");
        // Redirect to the desired page after login
        window.location.href = "redirect.html";
    } else {
        alert("Invalid email or password. Please try again.");
    }
});