import { Controller } from "@hotwired/stimulus";
import KeenSlider from "keen-slider";

export default class extends Controller {
  constructor() {
    super();
    this.timeoutId = null; // Initialize timeout ID variable
  }

  connect() {
    const sliderContainer = document.getElementById("subcategory-slider");
    let sliderWidth;
    sliderContainer.addEventListener("resize", () => {
      sliderWidth = sliderContainer.offsetWidth;
    });
    
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString.substring(1));
    // Get the category and subcategory values
    const subcategory = params.get("subcategory");
    const slide =
      subcategory != "none"
        ? document.getElementById(subcategory).dataset.slide
        : 0;

    const activeCategory = document.getElementById(subcategory);

    if (activeCategory) {
      activeCategory.children[0].classList.add("border-2");
    }

    const slider = document.getElementById("subcategory");
    slider.classList.add("h-0");
    this.timeoutId = setTimeout(() => {
      slider.classList.remove("h-0");
    }, 1);

    const slidesNum = document.getElementById("subcatSlides").dataset.slides;

    new KeenSlider(
      "#subcategory-slider",
      {
        initial: Number(slide),
        breakpoints: {
          "(max-width: 399px)": {
            loop: slidesNum > 1,
            slides: {
              perView: 1,
            },
          },
          "(min-width: 400px) and (max-width: 639px)": {
            loop: slidesNum > 2,
            slides: {
              perView: slidesNum < 2 ? Number(slidesNum) : 2,
              spacing: sliderSpacer(
                slidesNum < 2 ? Number(slidesNum) : 2,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 640px) and (max-width: 767px)": {
            loop: slidesNum > 3,
            slides: {
              perView: slidesNum < 3 ? Number(slidesNum) : 3,
              spacing: sliderSpacer(
                slidesNum < 3 ? Number(slidesNum) : 3,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 768px) and (max-width: 1023px)": {
            loop: slidesNum > 4,
            slides: {
              perView: slidesNum < 4 ? Number(slidesNum) : 4,
              spacing: sliderSpacer(
                slidesNum < 4 ? Number(slidesNum) : 4,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 1024px) and (max-width: 1279px)": {
            loop: slidesNum > 6,
            slides: {
              perView: slidesNum < 6 ? Number(slidesNum) : 6,
              spacing: sliderSpacer(
                slidesNum < 6 ? Number(slidesNum) : 6,
                108,
                sliderWidth
              ),
            },
          },
          "(min-width: 1280px)": {
            loop: slidesNum > 8,
            slides: {
              perView: slidesNum < 8 ? Number(slidesNum) : 8,
              spacing: sliderSpacer(
                slidesNum < 8 ? Number(slidesNum) : 8,
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
