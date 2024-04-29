import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  // for 'dragstart' and 'dragEnd' event on source (draggable)
  dragPicto(e) {
    // e.dataTransfer.effectAllowed = "copy";
    e.dataTransfer.setData("id", e.params.id);
    e.dataTransfer.setData("title", e.params.title);
    e.dataTransfer.setData("image", e.params.image);
    e.dataTransfer.setData("alt", e.params.alt);
    // console.log(e.dataTransfer);
    // console.log(e.target);
    e.dataTransfer.effectAllowed = "move";
    console.log(e.dataTransfer.getData("source"));
  }
  testPicto(e) {
    // console.log(e.dataTransfer);
    // console.log(e.target);
    console.log("drag ends");
  }

  //   for 'dragover' event on target (drop zone)
  dragPictoOverDropZone(e) {
    e.preventDefault();
  }

  // for 'dragenter' and 'dragleave' events on target (drop zone)
  highlightDropZone(e) {
    e.preventDefault();
    console.log("entering drop zone");
    e.target.classList.add("bg-red");
  }
  dehighlightDropZone(e) {
    e.preventDefault();
    console.log("leaving drop zone");
    e.target.classList.remove("bg-red");
  }

  // for 'drop' event on target (drop zone)
  cloneAndDropPicto(e) {
    const img = document.createElement("img");
    img.src = e.dataTransfer.getData("image");
    img.alt = e.dataTransfer.getData("alt");    
    img.draggable = true;

    img.dataset.id = e.dataTransfer.getData("id");
    // img.dataset.textToSpeech.title.param = e.dataTransfer.getData("title");
    img.setAttribute("data-textToSpeech-title-param", e.dataTransfer.getData("title"));
    img.classList.add("aspect-square", 'z-10');
    img.dataset.controller = "dragAndDrop textToSpeech";
    img.dataset.action = "dragstart->dragAndDrop#dragPicto dragend->dragAndDrop#testPicto click->textToSpeech#toSpeech";

    e.target.appendChild(img);
    console.log(img);
    console.log("drop happens");
  }
}
