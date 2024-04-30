import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  isSame = false;

  // for 'dragstart' and 'dragEnd' event on source (draggable)
  dragStartPicto(e) {
    if (e.target.parentNode.classList.contains("dropzone")) {
      e.dataTransfer.setData(
        "sourceParentId",
        e.target.parentNode.dataset.number
      );
    }
    e.dataTransfer.setData("id", e.params.id);
    e.dataTransfer.setData("title", e.params.title);
    e.dataTransfer.setData("image", e.params.image);
    e.dataTransfer.setData("alt", e.params.alt);
    e.dataTransfer.effectAllowed = "move";
  }
  dragEndPicto(e) {
    if (e.target.parentNode.classList.contains("dropzone")) {
      e.target.remove();
    }    
  }

  // for 'dragover' event on target (drop zone)
  // e.preventDefault() required for drag'n'drop to work
  dragPictoOverDropZone(e) {
    e.preventDefault();
  }

  // for 'dragenter' and 'dragleave' events on target (drop zone)
  highlightDropZone(e) {   
    e.target.style.borderColor = "red";
  }
  dehighlightDropZone(e) {
    e.dataTransfer.setData("targetParentId", "");
    e.target.style.borderColor = "";
  }

  // for 'drop' event on target (drop zone)
  cloneAndDropPicto(e) {
    const img = document.createElement("img");
    img.src = e.dataTransfer.getData("image");
    img.alt = e.dataTransfer.getData("alt");
    img.draggable = true;

    img.dataset.id = e.dataTransfer.getData("id");

    img.setAttribute(
      "data-textToSpeech-title-param",
      e.dataTransfer.getData("title")
    );
    img.setAttribute("data-dragAndDrop-id-param", e.dataTransfer.getData("id"));
    img.setAttribute(
      "data-dragAndDrop-title-param",
      e.dataTransfer.getData("title")
    );
    img.setAttribute(
      "data-dragAndDrop-alt-param",
      e.dataTransfer.getData("alt")
    );
    img.setAttribute(
      "data-dragAndDrop-image-param",
      e.dataTransfer.getData("image")
    );

    img.classList.add("aspect-square", "cursor-grab");
    img.dataset.controller = "dragAndDrop textToSpeech";
    img.dataset.action =
      "dragstart->dragAndDrop#dragStartPicto dragend->dragAndDrop#dragEndPicto click->textToSpeech#toSpeech";

    e.target.appendChild(img);
    e.target.style.borderColor = "";
  }
}
