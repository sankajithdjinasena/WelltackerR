const openDialog = document.getElementById("openDialog");
const closeDialog = document.getElementById("closeDialog");
const vitalsDialog = document.getElementById("vitalsDialog");

openDialog.addEventListener("click", () => {
    vitalsDialog.style.display = "flex";
});

closeDialog.addEventListener("click", () => {
    vitalsDialog.style.display = "none";
});

// Close when clicking outside the box
window.addEventListener("click", (e) => {
    if (e.target === vitalsDialog) {
        vitalsDialog.style.display = "none";
    }
});
