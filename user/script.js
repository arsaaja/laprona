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
