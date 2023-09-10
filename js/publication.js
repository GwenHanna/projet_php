//Boutton
let addPublication = document.querySelectorAll(".addPublication");
let picturePublication = document.querySelector("#picture-publication");
let linkPublication = document.querySelector("#link-publication");
let close = document.querySelectorAll(".close");
let likeArticle = document.querySelectorAll(".like-article");
let commentsArticle = document.querySelectorAll(".comments-article");

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

//Event des commantaires
let formCommentArticle = document.querySelector(".form-comment-article");
let registerComments = document.querySelectorAll(".register-comments");
commentsArticle.forEach((comment) => {
  comment.addEventListener("click", () => {
    form = comment.nextElementSibling;
    form.classList.toggle("hidden");
    form.classList.toggle("actived");
    registerComments.forEach((register) => {
      register.addEventListener("click", () => {
        removeClass(form);
      });
    });
  });
});

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
