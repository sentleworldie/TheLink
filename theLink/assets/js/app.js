console.log("TheLink Loaded Successfully");

document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.getElementById("darkModeToggle");

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
        if (toggle) toggle.innerHTML = "☀️ Light Mode";
    }

    if (toggle) {
        toggle.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");

            if (document.body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
                toggle.innerHTML = "☀️ Light Mode";
            } else {
                localStorage.setItem("theme", "light");
                toggle.innerHTML = "🌙 Dark Mode";
            }
        });
    }

    let deleteButtons = document.querySelectorAll(".btn-danger");

    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            if (!confirm("Are you sure you want to delete this item?")) {
                event.preventDefault();
            }
        });
    });

});
// Animated Counters
let counters = document.querySelectorAll(".counter");

counters.forEach(function(counter) {

    let target = +counter.getAttribute("data-target");
    let count = 0;
    let speed = 30;

    let updateCounter = function() {

        let increment = Math.ceil(target / 40);

        if(count < target) {
            count += increment;
            counter.innerText = count;
            setTimeout(updateCounter, speed);
        } else {
            counter.innerText = target;
        }

    };

    updateCounter();

});