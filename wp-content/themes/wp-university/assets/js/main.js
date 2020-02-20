// check if content is loaded
window.addEventListener("DOMContentLoaded", () => {
  ////////////////
  // VARIABLES
  ////////////////
  const menu = document.querySelector(".menu-menu-principal-container");
  const hamburgerBtn = document.querySelector(".hamburger");
  ////////////////
  // FUNCTIONS
  ////////////////
  const toggleMenu = () => {
    // get the closeBtn if existing else create it
    let closeBtn = document.querySelector(".closeBtn");
    if (!closeBtn) {
      closeBtn = document.createElement("p");
      closeBtn.classList.add("closeBtn");
      closeBtn.innerHTML = "Fermer X";
      menu.style.cssText =
        "flex;flex-direction:column;cursor:pointer;color:white";
    }

    // insert closeBtn before the ul
    menu.insertBefore(closeBtn, menu.firstChild);

    // toggle the menu via the menu button
    menu.style.left = menu.style.left === "0rem" ? "-15rem" : "0rem";

    // or close the menu via the closeBtn
    closeBtn.addEventListener("click", () => (menu.style.left = "-15rem"));
  };
  ////////////////
  // EVENT LISTENERS
  ////////////////
  hamburgerBtn.addEventListener("click", toggleMenu, true);
});
