const avatarBtn = document.getElementById("avatarBtn");
const dropdownMenu = document.getElementById("dropdownMenu");

avatarBtn.addEventListener("click", (e) => {
  dropdownMenu.classList.toggle("show");
  e.stopPropagation();
});

window.addEventListener("click", function () {
  dropdownMenu.classList.remove("show");
});

dropdownMenu.addEventListener("click", function (e) {
  e.stopPropagation();
});

const track = document.getElementById("carouselTrack");
const slideWidth = track.clientWidth;

function moveCarousel(direction) {
  const track = document.getElementById("carouselTrack");
  const width = track.clientWidth;
  track.scrollLeft += direction * width;
}
