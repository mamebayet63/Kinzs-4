document.addEventListener("DOMContentLoaded", () => {
  var splide = new Splide("#splide", {
    perPage: 1,
    pagination: false,
    type: "loop",
    autoplay: true,
    interval: 4000,
  });
  splide.mount();

  var splide2 = new Splide("#splide2", {
    perPage: 1,
    pagination: false,
    type: "loop",
    autoplay: true,
    interval: 4000,
    perMove: 1,
  });

  splide2.mount();
});
