// ---------- VITALS DIALOG ----------
const openVitalsBtn = document.getElementById("openDialog");
const closeVitalsBtn = document.getElementById("closeDialog");
const vitalsDialog = document.getElementById("vitalsDialog");

openVitalsBtn.addEventListener("click", () => {
    vitalsDialog.style.display = "flex"; // or "block" if you prefer
});

closeVitalsBtn.addEventListener("click", () => {
    vitalsDialog.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === vitalsDialog) {
        vitalsDialog.style.display = "none";
    }
});

const userinfoDialog = document.getElementById("userinfoDialog");
const openUserinfoBtn = document.getElementById("openProfileBtn"); // same button in navbar
const closeUserinfoBtn = userinfoDialog.querySelector(".userinfo-close");

openUserinfoBtn.addEventListener("click", () => {
  userinfoDialog.style.display = "flex"; // show modal
});

closeUserinfoBtn.addEventListener("click", () => {
  userinfoDialog.style.display = "none"; // hide modal
});

window.addEventListener("click", (e) => {
  if (e.target === userinfoDialog) {
    userinfoDialog.style.display = "none";
  }
});

