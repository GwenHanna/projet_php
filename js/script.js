let addPublication = document.querySelector(".addPublication");
let formPublication = document.querySelector(".form-publication");
console.log(addPublication);

$addPublication.addEventListener("click", (e) => {
  formPublication.classList.toggle("hidden");
});
