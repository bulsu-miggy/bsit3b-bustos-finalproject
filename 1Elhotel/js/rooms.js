const mainImg = document.getElementById("main-img");
const allImgs = document.querySelectorAll(".gallery img");

allImgs.forEach((img) => {
  img.addEventListener("click", (e) => {
    let selectedImg = e.target;
    mainImg.src = selectedImg.src;

    // To remove border from previous selected images;

    allImgs.forEach((images) => images.classList.remove("active"));

    selectedImg.classList.add("active");
  });
});