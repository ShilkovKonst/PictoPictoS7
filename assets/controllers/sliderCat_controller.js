import { Controller } from "@hotwired/stimulus";
import KeenSlider from "keen-slider";

import "../styles/slider.css";
import "../styles/keen-slider.css";

export default class extends Controller {
  constructor() {
    super();
    this.timeoutId = null; // Initialize timeout ID variable
  }

  connect() {

    // const list = document.querySelectorAll(".keen-slider__slide");
    // list.forEach((e) => {
    //   e.children[0].addEventListener("click", () => {
    //     console.log(e.children[0].dataset.title);
    //     var talk = new SpeechSynthesisUtterance();
    //     talk.text = e.children[0].dataset.title
    //     talk.lang = "fr-FR"
    //     speechSynthesis.speak(talk);
    //   });
    // });

    const sliderContainer = document.getElementById("category-slider");
    let sliderWidth;
    sliderContainer.addEventListener("resize", () => {
      sliderWidth = sliderContainer.offsetWidth;
    });

    const queryString = window.location.search;
    const params = new URLSearchParams(queryString.substring(1));
    // Get the category and subcategory values
    const category = params.get("category");

    const activeCategory = document.getElementById(category);
    if (activeCategory) {
      activeCategory.children[0].classList.add("border-2");
    }

    const slide = category ? activeCategory.dataset.slide : 0;
    const slider = document.getElementById("category");
    const slides = document.getElementById("catSlides").dataset.slides;

    slider.classList.add("h-0");
    this.timeoutId = setTimeout(() => {
      slider.classList.remove("h-0");
    }, 1);

    new KeenSlider(
      "#category-slider",
      {
        initial: Number(slide),
        breakpoints: {
          "(max-width: 399px)": {
            loop: slides > 1,
            slides: {
              perView: 1,
            },
          },
          "(min-width: 400px) and (max-width: 639px)": {
            loop: slides > 2,
            slides: {
              perView: slides < 2 ? Number(slides) : 2,
              spacing: sliderSpacer(
                slides < 2 ? Number(slides) : 2,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 640px) and (max-width: 767px)": {
            loop: slides > 3,
            slides: {
              perView: slides < 3 ? Number(slides) : 3,
              spacing: sliderSpacer(
                slides < 3 ? Number(slides) : 3,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 768px) and (max-width: 1023px)": {
            loop: slides > 4,
            slides: {
              perView: slides < 4 ? Number(slides) : 4,
              spacing: sliderSpacer(
                slides < 4 ? Number(slides) : 4,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 1024px) and (max-width: 1279px)": {
            loop: slides > 6,
            slides: {
              perView: slides < 6 ? Number(slides) : 6,
              spacing: sliderSpacer(
                slides < 6 ? Number(slides) : 6,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 1280px) and (max-width: 1535px)": {
            loop: slides > 8,
            slides: {
              perView: slides < 8 ? Number(slides) : 8,
              spacing: sliderSpacer(
                slides < 8 ? Number(slides) : 8,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 1536px)": {
            loop: slides > 10,
            slides: {
              perView: slides < 10 ? Number(slides) : 10,
              spacing: sliderSpacer(
                slides < 10 ? Number(slides) : 10,
                108,
                sliderWidth
              ),
            },
          },
        },
      },
      [navigation]
    );
  }
  disconnect() {
    if (this.timeoutId) {
      // Check if timeout ID exists
      clearTimeout(this.timeoutId); // Clear the timeout using the stored ID
      this.timeoutId = null; // Reset the timeout ID variable
    }
  }
}

function navigation(slider) {
  let wrapper, arrowLeft, arrowRight;

  function markup(remove) {
    wrapperMarkup(remove);
    arrowMarkup(remove);
  }

  function removeElement(elment) {
    elment.parentNode.removeChild(elment);
  }
  function createDiv(className) {
    var div = document.createElement("div");
    var classNames = className.split(" ");
    classNames.forEach((name) => div.classList.add(name));
    return div;
  }

  function arrowMarkup(remove) {
    if (remove) {
      removeElement(arrowLeft);
      removeElement(arrowRight);
      return;
    }
    arrowLeft = createDiv(
      "arrow arrow--left rounded-full border-4 border-pbg bg-pblue hover:bg-pred transition duration-300 ease-in-out"
    );
    arrowLeft.addEventListener("click", () => slider.prev());
    const svgLeft = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "svg"
    );
    svgLeft.classList.add("w-7", "h-7", "text-black");
    svgLeft.setAttribute("viewBox", "0 0 320 512");
    const pathLeft = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "path"
    );
    pathLeft.setAttribute(
      "d",
      "M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"
    );
    pathLeft.setAttribute("fill", "currentColor");
    svgLeft.appendChild(pathLeft);
    arrowLeft.appendChild(svgLeft);

    arrowRight = createDiv(
      "arrow arrow--right rounded-full border-4 border-pbg bg-pblue hover:bg-pred transition duration-300 ease-in-out"
    );
    arrowRight.addEventListener("click", () => slider.next());
    const svgRight = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "svg"
    );
    svgRight.classList.add("w-7", "h-7", "text-black");
    svgRight.setAttribute("viewBox", "0 0 320 512");
    const pathRight = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "path"
    );
    pathRight.setAttribute(
      "d",
      "M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"
    );
    pathRight.setAttribute("fill", "currentColor");
    svgRight.appendChild(pathRight);
    arrowRight.appendChild(svgRight);

    wrapper.appendChild(arrowLeft);
    wrapper.appendChild(arrowRight);
  }

  function wrapperMarkup(remove) {
    if (remove) {
      var parent = wrapper.parentNode;
      while (wrapper.firstChild)
        parent.insertBefore(wrapper.firstChild, wrapper);
      removeElement(wrapper);
      return;
    }
    wrapper = createDiv("navigation-wrapper");
    slider.container.parentNode.appendChild(wrapper);
    wrapper.appendChild(slider.container);
  }

  slider.on("created", () => {
    markup();
  });
  slider.on("optionsChanged", () => {
    markup(true);
    markup();
  });
  slider.on("slideChanged", () => {});
  slider.on("destroyed", () => {
    markup(true);
  });
}

const sliderSpacer = (perView, slideWidth, sliderWidth) => {
  return (sliderWidth - slideWidth * perView) / (perView - 1);
};
