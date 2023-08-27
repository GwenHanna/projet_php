let addPublication = document.querySelector(".addPublication");
let formPublication = document.querySelector(".form-publication");
let choices = document.querySelectorAll(".choice");

addPublication.addEventListener("click", () => {
  console.log(addPublication);
  formPublication.classList.remove("hidden");
  formPublication.classList.add("actived");
});

//Toggle class form file
choices.forEach((choice) => {
  choice.addEventListener("click", (e) => {
    el = e.target.nextElementSibling;
    if (el.classList.contains("actived")) {
      el.classList.toggle("hidden");
      el.classList.toggle("actived");
    } else if (el.classList.contains("hidden")) {
      el.classList.toggle("hidden");
      el.classList.toggle("actived");
    }
  });
});
