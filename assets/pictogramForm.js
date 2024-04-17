let isSetted = false;
const updatePathRegex = /^\/therapist\/pictograms\/\w+\/update$/

window.addEventListener("click", () => {
  if ((location.pathname == "/therapist/pictograms/create" || updatePathRegex.test(location.pathname)) && !isSetted) {
    isSetted = true;

    const irregularCheckbox = document.getElementById(
      "pictogram_form_irregular"
    );
    const irregularFields = document.getElementById("irregularFields");

    const pictogram_form_type = document.getElementById("pictogram_form_type");
    const pictoPlaceholderEmpty = document.getElementById(
      "tagPlaceholderEmpty"
    );
    const pictoPlaceholderInvariable = document.getElementById(
      "tagPlaceholderInvariable"
    );
    const pictogram_form_verbe = document.getElementById(
      "pictogram_form_verbe"
    );
    const pictogram_form_verbe_0 = document.getElementById(
      "pictogram_form_verbe_0"
    );
    const pictogram_form_verbe_1 = document.getElementById(
      "pictogram_form_verbe_1"
    );
    const irregularVerb = document.getElementById("irregularVerb");
    const pictogram_form_participe_passe = document.getElementById(
      "pictogram_form_participe_passe"
    );

    const conjugationPresent = document.getElementById("present_conjugationId");
    const pictogram_form_present_firstPersonSingular = document.getElementById(
      "pictogram_form_present_firstPersonSingular"
    );
    const pictogram_form_present_firstPersonPlurial = document.getElementById(
      "pictogram_form_present_firstPersonPlurial"
    );
    const pictogram_form_present_secondPersonSingular = document.getElementById(
      "pictogram_form_present_secondPersonSingular"
    );
    const pictogram_form_present_secondPersonPlurial = document.getElementById(
      "pictogram_form_present_secondPersonPlurial"
    );
    const pictogram_form_present_thirdPersonSingular = document.getElementById(
      "pictogram_form_present_thirdPersonSingular"
    );
    const pictogram_form_present_thirdPersonPlurial = document.getElementById(
      "pictogram_form_present_thirdPersonPlurial"
    );

    const conjugationFutur = document.getElementById("futur_conjugationId");
    const pictogram_form_futur_firstPersonSingular = document.getElementById(
      "pictogram_form_futur_firstPersonSingular"
    );
    const pictogram_form_futur_firstPersonPlurial = document.getElementById(
      "pictogram_form_futur_firstPersonPlurial"
    );
    const pictogram_form_futur_secondPersonSingular = document.getElementById(
      "pictogram_form_futur_secondPersonSingular"
    );
    const pictogram_form_futur_secondPersonPlurial = document.getElementById(
      "pictogram_form_futur_secondPersonPlurial"
    );
    const pictogram_form_futur_thirdPersonSingular = document.getElementById(
      "pictogram_form_futur_thirdPersonSingular"
    );
    const pictogram_form_futur_thirdPersonPlurial = document.getElementById(
      "pictogram_form_futur_thirdPersonPlurial"
    );

    const pictogram_form_nom_pronom = document.getElementById(
      "pictogram_form_nom_pronom"
    );
    const pictogram_form_nom_pronom_0 = document.getElementById(
      "pictogram_form_nom_pronom_0"
    );
    const pictogram_form_nom_pronom_1 = document.getElementById(
      "pictogram_form_nom_pronom_1"
    );
    const irregularGenre = document.getElementById("irregularGenre");
    const pictogram_form_feminin = document.getElementById(
      "pictogram_form_feminin"
    );

    const pictogram_form_pronom = document.getElementById(
      "pictogram_form_pronom"
    );
    const pictogram_form_pronom_0 = document.getElementById(
      "pictogram_form_pronom_0"
    );
    const pictogram_form_pronom_1 = document.getElementById(
      "pictogram_form_pronom_1"
    );
    const irregularNumber = document.getElementById("irregularNumber");
    const pictogram_form_pluriel = document.getElementById(
      "pictogram_form_pluriel"
    );

    const irregularId = document.getElementById("irregularId");

    irregularCheckbox.addEventListener("change", () => {
      if (irregularCheckbox.checked) {
        irregularFields.style.display = "block";

        if (pictogram_form_type.value == "verbe") {
          irregularVerb.style.display = "block";
          pictogram_form_participe_passe.setAttribute("required", "");
          conjugationPresent.style.display = "block";
          conjugationFutur.style.display = "block";
        } else {
          irregularVerb.style.display = "none";
          pictogram_form_participe_passe.removeAttribute("required");
          conjugationPresent.style.display = "none";
          conjugationFutur.style.display = "none";
        }

        if (
          pictogram_form_type.value == "nom" ||
          pictogram_form_type.value == "adjectif"
        ) {
          irregularNumber.style.display = "block";
          pictogram_form_pluriel.setAttribute("required", "");
        } else {
          irregularNumber.style.display = "none";
          pictogram_form_pluriel.removeAttribute("required");
        }

        if (pictogram_form_type.value == "adjectif") {
          irregularGenre.style.display = "block";
          pictogram_form_feminin.setAttribute("required", "");
        } else {
          irregularGenre.style.display = "none";
          pictogram_form_feminin.removeAttribute("required");
        }
      } else {
        setAllToInitial(
          irregularFields,
          irregularVerb,
          pictogram_form_participe_passe,
          conjugationPresent,
          conjugationFutur,
          pictogram_form_present_firstPersonSingular,
          pictogram_form_present_firstPersonPlurial,
          pictogram_form_present_secondPersonSingular,
          pictogram_form_present_secondPersonPlurial,
          pictogram_form_present_thirdPersonSingular,
          pictogram_form_present_thirdPersonPlurial,
          pictogram_form_futur_firstPersonSingular,
          pictogram_form_futur_firstPersonPlurial,
          pictogram_form_futur_secondPersonSingular,
          pictogram_form_futur_secondPersonPlurial,
          pictogram_form_futur_thirdPersonSingular,
          pictogram_form_futur_thirdPersonPlurial,
          irregularNumber,
          pictogram_form_pluriel,
          irregularGenre,
          pictogram_form_feminin
        );
      }
    });

    pictogram_form_type.addEventListener("change", () => {
      
    console.log('from inside listener', isSetted)
      // setting all to initial state
      irregularCheckbox.checked = false;
      setAllToInitial(
        irregularFields,
        irregularVerb,
        pictogram_form_participe_passe,
        conjugationPresent,
        conjugationFutur,
        pictogram_form_present_firstPersonSingular,
        pictogram_form_present_firstPersonPlurial,
        pictogram_form_present_secondPersonSingular,
        pictogram_form_present_secondPersonPlurial,
        pictogram_form_present_thirdPersonSingular,
        pictogram_form_present_thirdPersonPlurial,
        pictogram_form_futur_firstPersonSingular,
        pictogram_form_futur_firstPersonPlurial,
        pictogram_form_futur_secondPersonSingular,
        pictogram_form_futur_secondPersonPlurial,
        pictogram_form_futur_thirdPersonSingular,
        pictogram_form_futur_thirdPersonPlurial,
        irregularNumber,
        pictogram_form_pluriel,
        irregularGenre,
        pictogram_form_feminin
      );

      if (pictogram_form_type.value != "") {
        pictoPlaceholderEmpty.style.display = "none";
      } else {
        pictoPlaceholderEmpty.style.display = "block";
      }

      if (
        pictogram_form_type.value == "invariable" ||
        pictogram_form_type.value == "interrogatif" ||
        pictogram_form_type.value == "adjectif"
      ) {
        pictoPlaceholderInvariable.style.display = "block";
      } else {
        pictoPlaceholderInvariable.style.display = "none";
      }

      if (
        pictogram_form_type.value == "verbe" ||
        pictogram_form_type.value == "nom" ||
        pictogram_form_type.value == "adjectif"
      ) {
        irregularId.style.display = "block";
      } else {
        irregularId.style.display = "none";
      }

      if (pictogram_form_type.value == "verbe") {
        pictogram_form_verbe.style.display = "grid";
        pictogram_form_verbe_0.setAttribute("required", "");
        pictogram_form_verbe_1.setAttribute("required", "");
      } else {
        pictogram_form_verbe.style.display = "none";
        pictogram_form_verbe_0.removeAttribute("required");
        pictogram_form_verbe_1.removeAttribute("required");
      }

      if (
        pictogram_form_type.value == "nom" ||
        pictogram_form_type.value == "pronom_ou_determinant"
      ) {
        pictogram_form_nom_pronom.style.display = "grid";
        pictogram_form_nom_pronom_0.setAttribute("required", "");
        pictogram_form_nom_pronom_1.setAttribute("required", "");
      } else {
        pictogram_form_nom_pronom.style.display = "none";
        pictogram_form_nom_pronom_0.removeAttribute("required");
        pictogram_form_nom_pronom_1.removeAttribute("required");
      }

      if (pictogram_form_type.value == "pronom_ou_determinant") {
        pictogram_form_pronom.style.display = "grid";
        pictogram_form_pronom_0.setAttribute("required", "");
        pictogram_form_pronom_1.setAttribute("required", "");
      } else {
        pictogram_form_pronom.style.display = "none";
        pictogram_form_pronom_0.removeAttribute("required");
        pictogram_form_pronom_1.removeAttribute("required");
      }
    });

    if (location.pathname != "/therapist/pictograms/create" || !updatePathRegex.test(location.pathname)) {
      pictogram_form_type.removeEventListener();
      irregularCheckbox.removeEventListener();
    }
  } else if ((location.pathname != "/therapist/pictograms/create" || !updatePathRegex.test(location.pathname)) && isSetted) {
    isSetted = false;
  }
});

const setAllToInitial = (
  irregularFields,
  irregularVerb,
  pictogram_form_participe_passe,
  conjugationPresent,
  conjugationFutur,
  pictogram_form_present_firstPersonSingular,
  pictogram_form_present_firstPersonPlurial,
  pictogram_form_present_secondPersonSingular,
  pictogram_form_present_secondPersonPlurial,
  pictogram_form_present_thirdPersonSingular,
  pictogram_form_present_thirdPersonPlurial,
  pictogram_form_futur_firstPersonSingular,
  pictogram_form_futur_firstPersonPlurial,
  pictogram_form_futur_secondPersonSingular,
  pictogram_form_futur_secondPersonPlurial,
  pictogram_form_futur_thirdPersonSingular,
  pictogram_form_futur_thirdPersonPlurial,
  irregularNumber,
  pictogram_form_pluriel,
  irregularGenre,
  pictogram_form_feminin
) => {
  irregularFields.style.display = "none";
  irregularVerb.style.display = "none";

  pictogram_form_participe_passe.value = "";
  pictogram_form_participe_passe.removeAttribute("required");
  conjugationPresent.style.display = "none";
  conjugationFutur.style.display = "none";
  pictogram_form_present_firstPersonSingular.value = "";
  pictogram_form_present_firstPersonPlurial.value = "";
  pictogram_form_present_secondPersonSingular.value = "";
  pictogram_form_present_secondPersonPlurial.value = "";
  pictogram_form_present_thirdPersonSingular.value = "";
  pictogram_form_present_thirdPersonPlurial.value = "";
  pictogram_form_futur_firstPersonSingular.value = "";
  pictogram_form_futur_firstPersonPlurial.value = "";
  pictogram_form_futur_secondPersonSingular.value = "";
  pictogram_form_futur_secondPersonPlurial.value = "";
  pictogram_form_futur_thirdPersonSingular.value = "";
  pictogram_form_futur_thirdPersonPlurial.value = "";

  irregularNumber.style.display = "none";
  pictogram_form_pluriel.value = "";
  pictogram_form_pluriel.removeAttribute("required");
  irregularGenre.style.display = "none";
  pictogram_form_feminin.value = "";
  pictogram_form_feminin.removeAttribute("required");
};
