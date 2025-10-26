const openVerificationBtnForm = document.getElementById('openVerificationFormBtn');
const verificationDialogForm = document.getElementById('verificationFormDialog');
const closeVerificationBtnForm = document.getElementById('closeVerificationForm');

openVerificationBtnForm.addEventListener('click', () => {
  verificationDialogForm.style.display = 'flex';
});

closeVerificationBtnForm.addEventListener('click', () => {
  verificationDialogForm.style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === verificationDialogForm) {
    verificationDialogForm.style.display = 'none';
  }
});