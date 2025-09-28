window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
        document.body.classList.add('scrolled');
    } else {
        document.body.classList.remove('scrolled');
    }
});

const toggle = document.querySelector(".menu-toggle");
  const navLinks = document.querySelector(".nav-links");

  toggle.addEventListener("click", () => {
    navLinks.classList.toggle("active");
    toggle.classList.toggle("bx-x"); // swap to X icon
  });

  // Optional: add "scrolled" effect
  window.addEventListener("scroll", () => {
    document.body.classList.toggle("scrolled", window.scrollY > 10);
  });