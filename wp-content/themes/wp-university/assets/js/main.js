// check if content is loaded
window.addEventListener("DOMContentLoaded", () => {
  ////////////////
  // VARIABLES
  ////////////////
  const menu = document.querySelector(
    "#responsive-menu #menu-menu-principal-1"
  );
  const hamburgerBtn = document.querySelector(".hamburger");

  ////////////////
  // FUNCTIONS
  ////////////////
  const toggleMenu = () => {
    menu.style.left = menu.style.left == "0px" ? "-900px" : "0px";

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
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(48.5167, 3.7167),
    zoom: 14.5
  });

  const markers = document.querySelectorAll("#all-campus article");
  markers.forEach(marker => {
    console.log(marker.dataset.address);
    const contentString = marker.children[0].children[0];
    const textToDisplay = contentString.textContent;
    let address = marker.dataset.address.split("_").join(" ");

    let infowindow = new google.maps.InfoWindow({
      content: `
      <h2 style="margin:1rem auto">${textToDisplay}</h2>
      <p >${address}</p>
      `
    });

    marker = new google.maps.Marker({
      position: {
        lat: Number(marker.dataset.lat),
        lng: Number(marker.dataset.lng)
      },
      map: map
    });
    marker.addListener("click", function() {
      infowindow.open(map, marker);
    });
  });

  // // Create markers.
  // for (var i = 0; i < features.length; i++) {
  //   var marker = new google.maps.Marker({
  //     position: features[i].position,
  //     icon: icons[features[i].type].icon,
  //     title: "Uluru (Ayers Rock)",
  //     map: map
  //   });
  // }
}
