import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  toSpeech(e) {
    var talk = new SpeechSynthesisUtterance();
    talk.text = e.params.title;
    talk.lang = "fr-FR";
    speechSynthesis.speak(talk);
  }
}
