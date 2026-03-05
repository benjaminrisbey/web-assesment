faunaToggleBtn = document.getElementById("toggle-fauna-btn");

faunaToggleBtn.addEventListener("click", function () {
  faunaToggleBtn.textContent =
    faunaToggleBtn.textContent === "Show Fauna" ? "Hide Fauna" : "Show Fauna";
  document.getElementById("fauna-details").classList.toggle("hidden");
});
