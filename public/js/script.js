// script.js
document.addEventListener("DOMContentLoaded", function () {
  // DOM Elements
  const menuToggle = document.getElementById("menuToggle");
  const navMenu = document.getElementById("navMenu");
  const stickyCta = document.querySelector(".sticky-cta");
  const accordionItems = document.querySelectorAll(".accordion-item");

  // Mobile menu toggle
  menuToggle.addEventListener("click", () => {
    navMenu.classList.toggle("active");
    menuToggle.classList.toggle("active");
  });

  // Accordion functionality
  accordionItems.forEach((item) => {
    const button = item.querySelector(".accordion-button");
    const content = item.querySelector(".accordion-content");

    button.addEventListener("click", () => {
      const isActive = button.classList.contains("active");

      // Close all accordion items
      accordionItems.forEach((i) => {
        i.querySelector(".accordion-button").classList.remove("active");
        i.querySelector(".accordion-content").classList.remove("active");
      });

      // Open clicked item if it was closed
      if (!isActive) {
        button.classList.add("active");
        content.classList.add("active");
      }
    });
  });

  // Show sticky CTA when scrolling
  window.addEventListener("scroll", () => {
    if (window.scrollY > 500) {
      stickyCta.classList.add("show");
    } else {
      stickyCta.classList.remove("show");
    }
  });

  // Add hover effect to illustration
  const ill = document.querySelector(".kid-illustration");
  if (ill) {
    ill.addEventListener("mousemove", (e) => {
      const r = ill.getBoundingClientRect();
      const x = ((e.clientX - r.left - r.width / 2) / r.width) * 12;
      const y = ((e.clientY - r.top - r.height / 2) / r.height) * 10;
      ill.style.transform = `rotateY(${x}deg) rotateX(${-y}deg) translateZ(6px)`;
    });

    ill.addEventListener("mouseleave", () => {
      ill.style.transform = "none";
    });
  }

  // Learning section image/content switcher
  const learningItems = document.querySelectorAll(".learning-item");
  const learningImage = document.getElementById("learningImage");

  if (learningItems.length && learningImage) {
    learningItems.forEach((item) => {
      item.addEventListener("click", () => {
        // Remove active from all
        learningItems.forEach((i) => i.classList.remove("active"));

        // Add active to clicked
        item.classList.add("active");

        // Change image
        const newImg = item.getAttribute("data-img");
        learningImage.style.opacity = 0;
        setTimeout(() => {
          learningImage.src = newImg;
          learningImage.style.opacity = 1;
        }, 200);
      });
    });
  }

  // Carousel animation
  // Carousel animation
  const carouselTrack = document.querySelector(".carousel-track");
  const carouselItems = carouselTrack ? Array.from(carouselTrack.children) : [];
  let carouselIndex = 0;
  let carouselInterval;
  const slideTime = 3000; // 3 seconds

  if (carouselTrack && carouselItems.length) {
    const itemWidth = carouselItems[0].getBoundingClientRect().width;

    // Clone items for seamless loop
    carouselItems.forEach((item) => {
      carouselTrack.appendChild(item.cloneNode(true));
    });

    function moveCarousel() {
      carouselTrack.style.transform = `translateX(${
        -carouselIndex * itemWidth
      }px)`;
    }

    function startCarousel() {
      carouselInterval = setInterval(() => {
        carouselIndex++;
        if (carouselIndex >= carouselItems.length) {
          carouselIndex = 0;
          carouselTrack.style.transition = "none";
          carouselTrack.style.transform = "translateX(0)";
          setTimeout(() => {
            carouselTrack.style.transition = "transform 0.6s ease-in-out";
          }, 50);
        } else {
          moveCarousel();
        }
      }, slideTime);
    }

    function stopCarousel() {
      clearInterval(carouselInterval);
    }

    carouselTrack.addEventListener("mouseenter", stopCarousel);
    carouselTrack.addEventListener("mouseleave", startCarousel);

    startCarousel();
  }
});
