import { Controller } from "@hotwired/stimulus";

export default class DnD extends Controller {
  static source = null;
  static target = null;
  static img = null;

  touchStartPicto(e) {
    e.preventDefault();

    // textToSpeech    
    let talk = new SpeechSynthesisUtterance();
    talk.text = e.params.title;
    talk.lang = "fr-FR";
    speechSynthesis.speak(talk);

    if (e.target.parentNode.classList.contains("dropzone")) {
      DnD.source = e.target.parentNode;
    }
    DnD.img = e.target;
    console.log(DnD.source, DnD.target);

    // Создаем клон изображения
    let clone = DnD.source ? e.target : e.target.cloneNode(true);
    // Устанавливаем стили для клонированного изображения
    clone.classList.add(
      "rounded-2xl",
      "w-24",
      "h-24",
      "opacity-50",
      "cursor-grabbing",
      "absolute",
      "z-100"
    );
    document.body.appendChild(clone);

    // Устанавливаем начальные координаты для перетаскивания
    let offsetX = (e.type == "mousedown" ? e.clientX : e.changedTouches[0].clientX) - e.target.getBoundingClientRect().left;
    let offsetY = (e.type == "mousedown" ? e.clientY : e.changedTouches[0].clientY) - e.target.getBoundingClientRect().top;
    
    e.type == "mousedown" ? moveAt(e.clientX, e.clientY) : moveAt(e.changedTouches[0].clientX, e.changedTouches[0].clientY);

    let currentDropzone = null;

    // Добавляем обработчики событий для движения мыши и отпускания кнопки
    if (e.type == 'mousedown') {
      document.addEventListener("mousemove", touchMovePicto);
      document.addEventListener("mouseup", touchEndPicto);
    } else {
      document.addEventListener("touchmove", touchMovePicto);
      document.addEventListener("touchend", touchEndPicto);
    }

    function touchMovePicto(e) {
      e.type == "mousemove" ? moveAt(e.clientX, e.clientY) : moveAt(e.changedTouches[0].clientX, e.changedTouches[0].clientY);
      clone.hidden = true;
      let elemBelow =
        e.type == "mousemove"
          ? document.elementFromPoint(e.clientX, e.clientY)
          : document.elementFromPoint(
              e.changedTouches[0].clientX,
              e.changedTouches[0].clientY
            );
      clone.hidden = false;

      if (!elemBelow) return;

      let closestDropzone = elemBelow.closest(".dropzone");

      if (currentDropzone != closestDropzone) {
        if (currentDropzone) {
          // логика обработки процесса "вылета" из droppable (удаляем подсветку)
          currentDropzone.style.borderColor = "";
        }
        currentDropzone = closestDropzone;
        if (currentDropzone) {
          // логика обработки процесса, когда мы "влетаем" в элемент droppable
          currentDropzone.style.borderColor = "#e58463";
        }
      }
    }

    function touchEndPicto(e) {
      if (e.type == 'mouseup') {
        document.removeEventListener("mousemove", touchMovePicto);
        document.removeEventListener("mouseup", touchEndPicto);
      } else {
        document.removeEventListener("touchmove", touchMovePicto);
        document.removeEventListener("touchend", touchEndPicto);
      }
      if (currentDropzone) {
        DnD.target = currentDropzone;
        console.log(currentDropzone);
        // логика обработки процесса "вылета" из droppable (удаляем подсветку)
        currentDropzone.style.borderColor = "";
        clone.classList.remove(
          "rounded-2xl",
          "w-24",
          "h-24",
          "opacity-50",
          "cursor-grabbing",
          "absolute",
          "z-100"
        );
        clone.classList.add("cursor-grab");
        currentDropzone.appendChild(clone);
      } else {
        // Удаляем клон изображения
        clone.parentNode.removeChild(clone);
      }
      console.log(DnD.source, DnD.target);
      DnD.source = null;
      DnD.target = null;
      DnD.img = null;
    }

    function moveAt(clientX, clientY) {
      clone.style.left = clientX - offsetX + "px";
      clone.style.top = clientY - offsetY + "px";
    }
  }
}
