document.addEventListener("DOMContentLoaded", function() {
    const loginBtn = document.getElementById("login-btn");
    const logoutBtn = document.getElementById("logout-btn");
    const usernameDisplay = document.getElementById("username");
    const sidebar = document.querySelector(".sidebar");
    let isLoggedIn = false;

    // Function to Check Login Status Before Enrolling
    window.checkLoginStatus = function() {
        if (isLoggedIn) {
            alert("Enrollment successful! Your course has been added.");
        } else {
            alert("Please log in to enroll in this course.");
        }
    };

    // Simulated Login Function
    loginBtn.addEventListener("click", function() {
        isLoggedIn = true;
        usernameDisplay.textContent = "User"; // Placeholder, backend will update this later
        loginBtn.classList.add("hidden");
        logoutBtn.classList.remove("hidden");
        sidebar.classList.add("active");
    });

    // Simulated Logout Function
    logoutBtn.addEventListener("click", function() {
        isLoggedIn = false;
        usernameDisplay.textContent = "Guest";
        loginBtn.classList.remove("hidden");
        logoutBtn.classList.add("hidden");
        sidebar.classList.remove("active");
    });

    // Toggle Course Details
    const buttons = document.querySelectorAll(".learn-more");
    buttons.forEach(button => {
        button.addEventListener("click", function() {
            let details = this.nextElementSibling;
            if (details && details.classList.contains("course-details")) {
                if (details.style.display === "block") {
                    details.style.display = "none";
                    this.textContent = "View Details";
                } else {
                    details.style.display = "block";
                    this.textContent = "Hide Details";
                }
            }
        });
    });

    // Smooth Scroll to Enroll Section
    const enrollBtn = document.querySelector(".btn");
    if (enrollBtn) {
        enrollBtn.addEventListener("click", function(event) {
            event.preventDefault();
            document.querySelector("footer").scrollIntoView({ behavior: "smooth" });
        });
    }
});
