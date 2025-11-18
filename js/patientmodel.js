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

