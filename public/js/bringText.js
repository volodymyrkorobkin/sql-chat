
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
  let inputText = document.getElementById("input-field").value.trim();
  if (inputText !== "") {
    let chatContainer = document.getElementById("text-area");

    // left-side of the message
    let containerDiv = document.createElement("div");
    containerDiv.classList.add("LeftStroke");
    let profilePictureImg = document.createElement("img");
    profilePictureImg.src = "../img/YEAH.jpg";
    profilePictureImg.alt = "avatar";
    profilePictureImg.classList.add("profilePicture");
    let leftMessageDiv = document.createElement("p");
    leftMessageDiv.classList.add("leftMessage");
    leftMessageDiv.innerText = document.getElementById("input-field").value;
    let time = document.createElement("div");  
    time.classList.add("time-left");
    time.innerHTML = "11:00"


   // leftMessageDiv.innerHTML = `<p>${inputText}</p><span class="time-right">${getCurrentTime()}</span>`;

    // Append elements
    containerDiv.appendChild(profilePictureImg);
    containerDiv.appendChild(leftMessageDiv);
    chatContainer.appendChild(containerDiv);
    leftMessageDiv.appendChild(time);

   

    document.getElementById("input-field").value = "";


    let savedInput = document.getElementById("input-field").value;
    console.log("Saved input:", savedInput);
  }
}
// clone note


