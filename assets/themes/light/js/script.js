// pre loader
// const preloader = document.getElementById("preloader");
// window.addEventListener("load", () => {
//    setTimeout(() => {
//       preloader.style.cssText = `opacity: 0; visibility: hidden;`;
//    }, 1000);
// });

// add bg to nav
window.addEventListener("scroll", function () {
   let scrollpos = window.scrollY;
   const header = document.querySelector("nav");
   const headerHeight = header.offsetHeight;
   if (scrollpos >= headerHeight) {
      header.classList.add("active");
   } else {
      header.classList.remove("active");
   }
});

// active nav item
const navItem = document.getElementsByClassName("nav-link");
for (const element of navItem) {
   element.addEventListener("click", () => {
      for (const ele of navItem) {
         ele.classList.remove("active");
      }
      element.classList.add("active");
   });
}

// copy text
const copyText = (id) => {
   const text = document.getElementById(id);
   text.select();
   navigator.clipboard.writeText(text.value);
   document.getElementById("copyBtn").innerText = "Link copied";
   setTimeout(() => {
      document.getElementById("copyBtn").innerText = "Copy Link";
   }, 1000);
};

// input file preview



var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
   return new bootstrap.Tooltip(tooltipTriggerEl);
});

// const password = document.querySelector("#id_password");
// const togglePassword = document.querySelector("#togglePassword");
// togglePassword.addEventListener("click", function (e) {
//    // toggle the type attribute
//    const type = password.getAttribute("type") === "password" ? "text" : "password";
//    password.setAttribute("type", type);
//    // toggle the eye slash icon
//    this.classList.toggle("active");
// });

$(document).ready(function () {
   $(".js-example-basic-single").select2();
   $(".js-example-basic-single-modal").select2({
      dropdownParent: $("#formModal"),
   });
   $(".js-example-basic-multiple-limit").select2({
      maximumSelectionLength: 5,
   });

   $(".card-boxes").owlCarousel({
      loop: true,
      margin: -25,
      rtl: false,
      nav: false,
      dots: false,
      autoplay: false,
      autoplayTimeout: 3000,
      responsive: {
         0: {
            items: 1,
         },
         576: {
            items: 2,
         },
      },
   });

   $(".popular-vehicles").owlCarousel({
      loop: true,
      margin: 35,
      rtl: false,
      nav: false,
      dots: false,
      autoplay: true,
      autoplayTimeout: 3000,
      responsive: {
         0: {
            items: 1,
         },
         576: {
            items: 1,
         },
         768: {
            items: 2,
         },
         992: {
            items: 3,
         },
      },
   });

   $(".testimonials").owlCarousel({
      loop: true,
      margin: 35,
      rtl: false,
      nav: false,
      dots: false,
      autoplay: true,
      autoplayTimeout: 3000,
      responsive: {
         0: {
            items: 1,
         },
         576: {
            items: 2,
         },
         768: {
            items: 2,
         },
         992: {
            items: 3,
         },
      },
   });

   $(".brands").owlCarousel({
      loop: true,
      margin: 0,
      rtl: false,
      nav: false,
      dots: false,
      autoplay: true,
      autoplayTimeout: 3000,
      responsive: {
         0: {
            items: 2,
         },
         768: {
            items: 4,
         },
         992: {
            items: 6,
         },
      },
   });

   $("[data-countdown]").each(function () {
      var $this = $(this),
         finalDate = $(this).data("countdown");
      $this.countdown(finalDate, function (event) {
         $this.html(
            event.strftime("<span>%D day%!d </span> <span>%H hr</span> <span>%M min</span> <span>%S sec</span> ")
         );
      });
   });

   // RANGE SLIDER


   // COUNTER UP
   if( $(".counter").length){
      $(".counter").counterUp({
         delay: 10,
         time: 3000,
      });
   }


});

