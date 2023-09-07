//Boutton
let addPublication = document.querySelectorAll(".addPublication");
let picturePublication = document.querySelector("#picture-publication");
let linkPublication = document.querySelector("#link-publication");
let close = document.querySelectorAll(".close");

//Boite
let = popSuccess = document.querySelector(".pop-success");
let formPublication = document.querySelector(".form-publication");
let choicePicture = document.querySelector(".choice-picture");
let choiceLink = document.querySelector(".choice-link");

//***************Event***************************//

function activClass(el) {
  el.classList.remove("hidden");
  el.classList.add("actived");
}
function removeClass(el) {
  el.classList.add("hidden");
  el.classList.remove("actived");
}

close.forEach((clo) => {
  clo.addEventListener("click", () => {
    console.log(clo);
    removeClass(popSuccess);
  });
});
//Toggle class pop up ajout publication
addPublication.forEach((p) => {
  p.addEventListener("click", (e) => {
    console.log(p);
    document.querySelector("body").style.background = "black";
    activClass(formPublication);
    close.forEach((clo) => {
      clo.addEventListener("click", () => {
        document.querySelector("body").style.background = "inherit";
        removeClass(formPublication);
      });
    });
  });
});

picturePublication.addEventListener("click", (e) => {
  removeClass(choiceLink);
  choicePicture.classList.toggle("actived");
});
linkPublication.addEventListener("click", (e) => {
  removeClass(choicePicture);
  choiceLink.classList.toggle("actived");
});
