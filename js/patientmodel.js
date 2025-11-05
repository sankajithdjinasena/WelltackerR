// Open modal
document.querySelectorAll(".open-modal").forEach(btn => {
    btn.addEventListener("click", () => {
        const modal = document.querySelector(btn.dataset.target);
        modal.style.display = "flex";
    });
});

// Close modal by X
document.querySelectorAll(".health-modal-close").forEach(btn => {
    btn.addEventListener("click", () => {
        btn.closest(".health-modal").style.display = "none";
    });
});

// Close modal by clicking outside
window.addEventListener("click", e => {
    if(e.target.classList.contains("health-modal")){
        e.target.style.display = "none";
    }
});

// Handle form submit
document.querySelectorAll(".health-form").forEach(form => {
    form.addEventListener("submit", e => {
        e.preventDefault();
        const prediction = Math.random() < 0.5 ? 0 : 1;
        const message = prediction === 1
            ? "Patient is likely to have Diabetes."
            : "Patient is Not Diabetic.";
        alert(message);
        form.closest(".health-modal").style.display = "none";
    });
});
