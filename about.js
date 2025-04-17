document.addEventListener("DOMContentLoaded", function() {
    // Toggle Team Member Details
    const buttons = document.querySelectorAll(".learn-more");
    
    buttons.forEach(button => {
        button.addEventListener("click", function() {
            const member = this.closest(".team-member");
            const info = member.querySelector(".member-info");
            
            if (info.style.display === "block") {
                info.style.display = "none";
                this.textContent = "Learn More";
            } else {
                info.style.display = "block";
                this.textContent = "Show Less";
            }
        });
    });

    // Simple Testimonial Slider
    let currentIndex = 0;
    const testimonials = document.querySelectorAll(".testimonials-carousel p");
    
    function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.style.display = i === index ? "block" : "none";
        });
    }
    
    function nextTestimonial() {
        currentIndex = (currentIndex + 1) % testimonials.length;
        showTestimonial(currentIndex);
    }
    
    if (testimonials.length > 0) {
        showTestimonial(currentIndex);
        setInterval(nextTestimonial, 5000); // Change testimonial every 5 seconds
    }
});
