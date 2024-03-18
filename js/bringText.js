
let input = document.getElementById("input-field");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    if (input.value.trim() !== "") { // Check if input is not empty
      document.getElementById("button").click();
      document.getElementById("input-field").value = "";
    } else {
      event.preventDefault();
    }
  }
});

function savedInput() {
  const savedInput = document.getElementById("input-field").value;
  console.log("Saved input:", savedInput);
}

// clone note


