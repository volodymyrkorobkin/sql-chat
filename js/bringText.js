var input = document.getElementById("input-field");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("button").click();
  }
});