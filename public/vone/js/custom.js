(function ($) {
  "use strict";

  jQuery(window).on("load", function () {
    // init Masonry
    try {
      var $grid = $(".grid,.wbarchivess ul.products").masonry({
        // options
        itemSelector: ".grid-item,#single-products",
      });
      // layout Masonry after each image loads
      $grid.imagesLoaded().progress(function () {
        $grid.masonry("layout");
      });
    } catch (error) {}
  });

  if ($(".xa-mp-1").length) {
    // Initialize mouseParallax() only if elements exist
    $(".xa-mp-1").mouseParallax({
      moveFactor: 2,
    });
  }

  // Check if elements with class 'xa-mp-2' exist on the page
  if ($(".xa-mp-2").length) {
    // Initialize mouseParallax() only if elements exist
    $(".xa-mp-2").mouseParallax({
      moveFactor: 3,
    });
  }

  $(document).ready(function () {
    /*====================================
		Header Sticky JS
	======================================*/
    var activeSticky = $("#active-sticky"),
      winDow = $(window);
    winDow.on("scroll", function () {
      var scroll = $(window).scrollTop(),
        isSticky = activeSticky;
      if (scroll < 80) {
        isSticky.removeClass("is-sticky");
      } else {
        isSticky.addClass("is-sticky");
      }
    });

    $(".counter-active").counterUp({
      time: 3000,
      delay: 15,
    });

    /*====================================
		Brand  SLider JS
	======================================*/
    $(".brand-slider").slick({
      autoplay: true,
      loop: true,
      speed: 500,
      autoplaySpeed: 3500,
      slidesToShow: 5,
      slidesToScroll: 1,
      pauseOnHover: true,
      infinite: true,
      dots: false,
      arrows: false,
      cssEase: "ease",
      draggable: true,
      prevArrow: '<button class="Prev">Prev</button>',
      nextArrow: '<button class="Prev">Next</button>',
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            slidesToShow: 4,
          },
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    /*====================================
		Features SLider JS
	======================================*/
    $(".features-slider").slick({
      autoplay: true,
      centerMode: true,
      centerPadding: "250px",
      speed: 500,
      autoplaySpeed: 3500,
      slidesToShow: 3,
      slidesToScroll: 1,
      pauseOnHover: true,
      cssEase: "linear",
      infinite: true,
      dots: false,
      arrows: false,
      draggable: true,
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            slidesToShow: 3,
            centerPadding: "60px",
          },
        },
        {
          breakpoint: 1025,
          settings: {
            slidesToShow: 2,
            centerPadding: "60px",
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            centerPadding: "0px",
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            centerPadding: "0px",
          },
        },
      ],
    });

    /*====================================
		Testimonial SLider JS
	======================================*/
    $(".testimonial-g-slide").slick({
      autoplay: true,
      speed: 500,
      autoplaySpeed: 3500,
      slidesToShow: 2,
      slidesToScroll: 1,
      pauseOnHover: true,
      infinite: true,
      dots: true,
      arrows: false,
      cssEase: "ease",
      draggable: true,
      prevArrow: '<button class="Prev">Prev</button>',
      nextArrow: '<button class="Prev">Next</button>',
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    /*====================================
		Aos Animate JS
	======================================*/
    AOS.init({
      duration: 1500,
      disable: !1,
      offset: 0,
      once: !0,
      easing: "ease",
    });
  });

  /*====================================
		Mobile Menu
	======================================*/
  var $offcanvasNav = $("#offcanvas-menu a");
  $offcanvasNav.on("click", function () {
    var link = $(this);
    var closestUl = link.closest("ul");
    var activeLinks = closestUl.find(".active");
    var closestLi = link.closest("li");
    var linkStatus = closestLi.hasClass("active");
    var count = 0;

    closestUl.find("ul").slideUp(function () {
      if (++count == closestUl.find("ul").length)
        activeLinks.removeClass("active");
    });
    if (!linkStatus) {
      closestLi.children("ul").slideDown();
      closestLi.addClass("active");
    }
  });

  /*====================================
		Scrool To Top JS
	======================================*/
  var lastScrollTop = "";
  var scrollToTopBtn = ".scrollToTop";

  function stickyMenu($targetMenu, $toggleClass) {
    var st = $(window).scrollTop();
    if ($(window).scrollTop() > 600) {
      if (st > lastScrollTop) {
        $targetMenu.removeClass($toggleClass);
      } else {
        $targetMenu.addClass($toggleClass);
      }
    } else {
      $targetMenu.removeClass($toggleClass);
    }
    lastScrollTop = st;
  }
  $(scrollToTopBtn).on("click", function (e) {
    e.preventDefault();
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      500
    );
    return false;
  });
  $(window).on("scroll", function () {
    stickyMenu($(".sticky-header"), "active");
    if ($(this).scrollTop() > 400) {
      $(scrollToTopBtn).addClass("show");
    } else {
      $(scrollToTopBtn).removeClass("show");
    }
  });

  /*====================================
	 	Preloader JS
	 ======================================*/
  $(window).on("load", function (event) {
    $(".preloader").delay(200).fadeOut(100);
  });

  /*====================================
		Cursor Animation JS
	======================================*/
  $(function () {
    $("body").append('<span class="saastain-mouse-move-big d"></span>');
    $("body").append('<span class="saastain-mouse-move-sm"></span>');
    $(
      ".saastain-header,.social-icon a,.newsletter-area__forms button,.topsass-btn,.features-btn,.topsass-btn__v2 "
    ).on("mouseenter", function () {
      $(".saastain-mouse-move-big").addClass("saastain-hidden");
      $(".saastain-mouse-move-sm").addClass("saastain-hidden");
    });
    $(
      ".saastain-header,.social-icon a,.newsletter-area__forms button,.topsass-btn,.features-btn,.topsass-btn__v2 "
    ).on("mouseleave", function () {
      $(".saastain-mouse-move-big").removeClass("saastain-hidden");
      $(".saastain-mouse-move-sm").removeClass("saastain-hidden");
    });
  });
  function cursorMovingAnimation(event) {
    try {
      const timing = gsap.timeline({
        defaults: {
          x: event.clientX,
          y: event.clientY,
        },
      });

      timing
        .to(".saastain-mouse-move-big", {
          ease: "power2.out",
        })
        .to(
          ".saastain-mouse-move-sm",
          {
            ease: "power2.out",
          },
          "-=0.4"
        );
    } catch (err) {
      console.log(err);
    }
  }
  document.addEventListener("mousemove", cursorMovingAnimation);

  // function initializeAnimations() {
  //   if ($(".images/logo-3.png").length > 0) {
  //     // Title Animation
  //     let splitTitleLines = gsap.utils.toArray(".images/logo-3.png");
  //     splitTitleLines.forEach((splitTextLine) => {
  //       const tl = gsap.timeline({
  //         scrollTrigger: {
  //           trigger: splitTextLine,
  //           start: "top 90%",
  //           end: "bottom 60%",
  //           scrub: false,
  //           markers: false,
  //           toggleActions: "play none none none",
  //         },
  //       });

  //       const itemSplitted = new SplitText(splitTextLine, {
  //         type: "words, lines",
  //       });
  //       gsap.set(splitTextLine, { perspective: 300 });
  //       itemSplitted.split({ type: "lines" });
  //       tl.from(itemSplitted.lines, {
  //         duration: 1.5,
  //         delay: 0.3,
  //         opacity: 0,
  //         rotationX: -60,
  //         force3D: true,
  //         transformOrigin: "top center -50",
  //         stagger: 0.2,
  //       });
  //     });
  //   }

  //   if ($(".images/logo-3.png").length > 0) {
  //     // Character Animation
  //     let char_come = gsap.utils.toArray(".images/logo-3.png");
  //     char_come.forEach((splitTextLine) => {
  //       const tl = gsap.timeline({
  //         scrollTrigger: {
  //           trigger: splitTextLine,
  //           start: "top 90%",
  //           end: "bottom 60%",
  //           scrub: false,
  //           markers: false,
  //           toggleActions: "play none none none",
  //         },
  //       });

  //       const itemSplitted = new SplitText(splitTextLine, {
  //         type: "chars, words",
  //       });
  //       gsap.set(splitTextLine, { perspective: 300 });
  //       itemSplitted.split({ type: "chars, words" });
  //       tl.from(itemSplitted.chars, {
  //         duration: 2,
  //         x: 200,
  //         autoAlpha: 0,
  //         stagger: 0.05,
  //       });
  //     });
  //   }

  //   if ($(".images/logo-3.png").length > 0) {
  //     // Another Character Animation
  //     let char_come = gsap.utils.toArray(".images/logo-3.png");
  //     char_come.forEach((splitTextLine) => {
  //       const tl = gsap.timeline({
  //         scrollTrigger: {
  //           trigger: splitTextLine,
  //           start: "top 90%",
  //           end: "bottom 60%",
  //           scrub: false,
  //           markers: false,
  //           toggleActions: "play none none none",
  //         },
  //       });

  //       const itemSplitted = new SplitText(splitTextLine, {
  //         type: "chars, words",
  //       });
  //       gsap.set(splitTextLine, { perspective: 300 });
  //       itemSplitted.split({ type: "chars, words" });
  //       tl.from(itemSplitted.chars, {
  //         duration: 1.2,
  //         opacity: 0,
  //         scale: 0,
  //         y: 60,
  //         rotationX: 180,
  //         transformOrigin: "0% 30% -30%",
  //         stagger: 0.02,
  //       });
  //     });
  //   }
  // }

  // Delay the initialization to ensure the elements are available in the DOM
  // setTimeout(initializeAnimations, 300); // Adjust the delay as needed
})(jQuery);

if (document.querySelectorAll(".js-video-btn")) {
  try {
    new ModalVideo(".js-video-btn");
  } catch (error) {}
}

document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(
    ".software-card__button, .software-card__heading"
  );

  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      const softwareCard = button.closest(".software-card");
      const expandContent = softwareCard.querySelector(".software-card-expand");
      const softwareCardParent = softwareCard.parentElement;

      // Remove active class from all .software-card parents
      const allSoftwareCards = document.querySelectorAll(".software-card");
      allSoftwareCards.forEach(function (card) {
        if (card !== softwareCard) {
          card.classList.remove("active");
          card.parentElement.classList.remove("active");
        }
      });

      // Toggle active class for .software-card-expand
      expandContent.classList.toggle("active");

      // Toggle active class for .software-card
      softwareCard.classList.toggle("active");

      // Toggle active class for parent of .software-card
      softwareCardParent.classList.toggle("active");
    });
  });
});

// h7 interface slider
$(".h7-app-interface-slide").slick({
  autoplay: true,
  speed: 500,
  autoplaySpeed: 3500,
  slidesToShow: 2,
  slidesToScroll: 1,
  pauseOnHover: true,
  infinite: true,
  dots: true,
  arrows: false,
  cssEase: "ease",
  draggable: true,
  prevArrow: '<button class="Prev">Prev</button>',
  nextArrow: '<button class="Prev">Next</button>',
  responsive: [
    {
      breakpoint: 1500,
      settings: {
        slidesToShow: 4,
      },
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
      },
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
      },
    },
  ],
});
