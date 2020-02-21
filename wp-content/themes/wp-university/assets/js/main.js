// check if content is loaded
window.addEventListener("DOMContentLoaded", () => {
  ////////////////
  // VARIABLES
  ////////////////
  const menu = document.querySelector("#responsive-menu");
  const hamburgerBtn = document.querySelector(".hamburger");

  ////////////////
  // FUNCTIONS
  ////////////////
  const toggleMenu = () => {
    menu.style.height = menu.style.height == "100vh" ? "0px" : "100vh";
    menu.style.opacity = menu.style.opacity == "1" ? "0" : "1";
    hamburgerBtn.innerHTML =
      hamburgerBtn.innerHTML === "X"
        ? `<span></span>
    <span></span>
    <span></span>`
        : "X";
  };

  ////////////////
  // EVENT LISTENERS
  ////////////////
  hamburgerBtn.addEventListener("click", toggleMenu, true);
});
