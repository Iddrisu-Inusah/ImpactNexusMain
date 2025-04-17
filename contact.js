document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.getElementById("contactForm");

    contactForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(contactForm);

        fetch("contact.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("form-status").innerHTML = `<p>${data}</p>`;
            contactForm.reset();
        })
        .catch(error => console.error("Error:", error));
    });
});