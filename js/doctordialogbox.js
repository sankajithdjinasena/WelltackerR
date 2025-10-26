// User Info Dialog
const userinfoDialog = document.getElementById("userinfoDialog");
const openUserinfoBtn = document.getElementById("openProfileBtn");
const closeUserinfoBtn = document.querySelector(".userinfo-close");

openUserinfoBtn.addEventListener("click", () => {
    userinfoDialog.style.display = "flex"; // show dialog
});

closeUserinfoBtn.addEventListener("click", () => {
    userinfoDialog.style.display = "none"; // hide dialog
});

// Close dialog when clicking outside the content
window.addEventListener("click", (e) => {
    if (e.target === userinfoDialog) {
        userinfoDialog.style.display = "none";
    }
});

const verificationDialog = document.getElementById("verificationDialog");
const openVerificationBtn = document.getElementById("openVerificationBtn");
const closeVerificationBtn = document.getElementById("closeVerification");

if(openVerificationBtn){
    openVerificationBtn.onclick = () => verificationDialog.style.display = "flex";
    closeVerificationBtn.onclick = () => verificationDialog.style.display = "none";
    window.onclick = (event) => { if(event.target === verificationDialog) verificationDialog.style.display = "none"; }
}


