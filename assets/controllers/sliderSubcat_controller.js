import { Controller } from "@hotwired/stimulus";
import KeenSlider from "keen-slider";

export default class extends Controller {
  constructor() {
    super();
    this.timeoutId = null; // Initialize timeout ID variable
  }

  connect() {
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString.substring(1));
    // Get the category and subcategory values
    const subcategory = params.get("subcategory");
    const slide = subcategory != 'none'
      ? document.getElementById(subcategory).dataset.slide
      : 0;

    const slider = document.getElementById("subcategory");
    slider.classList.add('h-0');
    this.timeoutId = setTimeout(() => {
      slider.classList.remove('h-0');
    }, 1);

    new KeenSlider(
      "#subcategory-slider",
      {
        initial: Number(slide),
        breakpoints: {
          "(max-width: 399px)": {
            slides: {
              perView: 1,
              // spacing: 0,
            },
          },
          "(min-width: 400px) and (max-width: 639px)": {
            slides: {
              perView: 2,
              // spacing: 10,
            },
          },
          "(min-width: 640px) and (max-width: 767px)": {
            slides: {
              perView: 3,
              // spacing: 20,
            },
          },
          "(min-width: 768px) and (max-width: 1023px)": {
            slides: {
              perView: 4,
              // spacing: 20,
            },
          },
          "(min-width: 1024px) and (max-width: 1279px)": {
            slides: {
              perView: 6,
              // spacing: 20,
            },
          },
          "(min-width: 1280px)": {
            slides: {
              perView: 8,
              // spacing: 20,
            },
          },
        },
        loop: true,
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
    arrowLeft = createDiv("arrow arrow--left");
    arrowLeft.addEventListener("click", () => slider.prev());
    arrowRight = createDiv("arrow arrow--right");
    arrowRight.addEventListener("click", () => slider.next());

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

  function updateClasses() {
    var slide = slider.track.details.rel;
    slide === 0
      ? arrowLeft.classList.add("arrow--disabled")
      : arrowLeft.classList.remove("arrow--disabled");
    slide === slider.track.details.slides.length - 1
      ? arrowRight.classList.add("arrow--disabled")
      : arrowRight.classList.remove("arrow--disabled");
  }

  slider.on("created", () => {
    markup();
    updateClasses();
  });
  slider.on("optionsChanged", () => {
    console.log(2);
    markup(true);
    markup();
    updateClasses();
  });
  slider.on("slideChanged", () => {
    updateClasses();
  });
  slider.on("destroyed", () => {
    markup(true);
  });
}
