document.querySelectorAll('.menu-item').forEach(item => {
  item.addEventListener('click', () => {
    const dialogId = item.getAttribute('data-dialog');
    const dialog = document.getElementById(dialogId);
    if (dialog) dialog.style.display = 'flex';
  });
});

document.querySelectorAll('.close-dialog').forEach(btn => {
  btn.addEventListener('click', () => {
    btn.closest('.vitals-dialog').style.display = 'none';
  });
});

window.addEventListener('click', e => {
  document.querySelectorAll('.vitals-dialog').forEach(dialog => {
    if (e.target === dialog) dialog.style.display = 'none';
  });
});
