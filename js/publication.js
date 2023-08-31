//Boutton
let addPublication = document.querySelector(".addPublication");
let picturePublication = document.querySelector("#picture-publication");
let linkPublication = document.querySelector("#link-publication");
let close = document.querySelector(".close");

//Boite
let formPublication = document.querySelector(".form-publication");
let choicePicture = document.querySelector(".choice-picture");
let choiceLink = document.querySelector(".choice-link");

//Event//

addPublication.addEventListener("click", () => {
  document.querySelector("body").style.background = "black";
  formPublication.classList.remove("hidden");
  formPublication.classList.add("actived");
  close.addEventListener("click", () => {
    document.querySelector("body").style.background = "inherit";
    formPublication.classList.remove("actived");
    formPublication.classList.add("hidden");
  });
});

//Toggle class form file
picturePublication.addEventListener("click", (e) => {
  choiceLink.classList.remove("actived");
  choiceLink.classList.add("hidden");
  choicePicture.classList.toggle("actived");
});
linkPublication.addEventListener("click", (e) => {
  choicePicture.classList.remove("actived");
  choicePicture.classList.add("hidden");
  choiceLink.classList.toggle("actived");
});
