// add classes for mobile navigation toggling
var CSbody = document.querySelector("body");
const CSnavbarMenu = document.querySelector("#cs-navigation");
const CShamburgerMenu = document.querySelector("#cs-navigation .cs-toggle");

CShamburgerMenu.addEventListener("click", function () {
  CShamburgerMenu.classList.toggle("cs-active");
  CSnavbarMenu.classList.toggle("cs-active");
  CSbody.classList.toggle("cs-open");
  // run the function to check the aria-expanded value
  ariaExpanded();
});

// checks the value of aria expanded on the cs-ul and changes it accordingly whether it is expanded or not
function ariaExpanded() {
  const csUL = document.querySelector("#cs-expanded");
  const csExpanded = csUL.getAttribute("aria-expanded");

  if (csExpanded === "false") {
    csUL.setAttribute("aria-expanded", "true");
  } else {
    csUL.setAttribute("aria-expanded", "false");
  }
}

// mobile nav toggle code
const dropDowns = Array.from(
  document.querySelectorAll("#cs-navigation .cs-dropdown")
);
for (const item of dropDowns) {
  const onClick = () => {
    item.classList.toggle("cs-active");
  };
  item.addEventListener("click", onClick);
}

// NEW CODE: Hide navbar on scroll down, show on scroll up
let lastScrollTop = 0;
const navbar = document.getElementById("cs-navigation");
const scrollThreshold = 10; // Minimum amount of pixels to scroll before showing/hiding navbar

// Add smooth transition to the existing navbar styles
navbar.style.transition =
  "transform 0.3s ease-in-out, top 0.3s, border-radius 0.3s, width 0.3s, max-width 0.3s";

window.addEventListener("scroll", function () {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  // Check if we've scrolled more than the threshold
  if (Math.abs(lastScrollTop - scrollTop) <= scrollThreshold) return;

  // Scrolling down and not at the top
  if (scrollTop > lastScrollTop && scrollTop > navbar.offsetHeight) {
    // Hide navbar (transform up off-screen)
    navbar.style.transform = "translate(-50%, -150%)";
  } else {
    // Scrolling up or at the top - restore original position
    if (document.body.classList.contains("scroll")) {
      // When in 'scroll' mode
      navbar.style.transform = "translateX(-50%)";
    } else {
      // When in normal mode
      navbar.style.transform = "translateX(-50%)";
    }
  }

  lastScrollTop = scrollTop;
});
