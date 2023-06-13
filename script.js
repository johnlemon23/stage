// Empêcher la soumission du formulaire lorsque la touche "Entrée" est enfoncée
document.addEventListener("keydown", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
  }
});

let villesString = "";
let villesStringPrec = "";

function ajouterOptions(communes) {
  const villesArray = communes.split(",");
  const selectVilles = document.getElementById("commune");
  selectVilles.innerHTML = "";
  villesArray.forEach(ville => {
    const option = document.createElement("option");
    option.text = ville;
    option.value = ville;
    selectVilles.add(option);
  });
  
}

document.addEventListener("change", function() {
  var codePostalInput = document.getElementById("code_postal").value;
  console.log("Nouvelle valeur du champ de formulaire : " + codePostalInput);
  // Envoyer une requête HTTP POST contenant la valeur du champ de formulaire
  var xhr = new XMLHttpRequest();
  var method = "POST";
  var urls = "data.php"
  var async = true;

  xhr.open(method, urls, async);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("code_postal=" + encodeURIComponent(codePostalInput));

  xhr.onload = function() {
    if (this.readyState == 4 && this.status === 200) {
      // Traitement de la réponse du script PHP
      var data = this.responseText;
      console.log(data);
      if (data !== villesStringPrec) {
        // Stocker la réponse dans la variable villesString
        villesString = data;
        villesStringPrec = data;
        
        // Exécuter la fonction pour mettre à jour les options
        ajouterOptions(data);
      }
    } else {
      console.error("Erreur lors de la requête : " + xhr.status);
    }
  };
});

function ajouterForm() {
    var formRepete = document.getElementById("form-repete");
    var nombreInput = document.getElementById("nombre_adherent");
    var nombre = parseInt(nombreInput.value);
    var forms = document.querySelectorAll("#form-repete");
    if (nombre < 11){
      for (var i = forms.length; i < nombre; i++) {
        var clone = formRepete.cloneNode(true);
        formRepete.parentNode.insertBefore(clone, formRepete.nextSibling);
      }
      for (var i = forms.length - 1; i >= nombre; i--) {
        forms[i].parentNode.removeChild(forms[i]);
      }
    }
}
