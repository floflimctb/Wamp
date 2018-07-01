function init(){
	var listeEmploye=document.getElementById("apteA");
	listeEmploye.addEventListener("change",requete);
	var employe=listeEmploye.options[listeEmploye.selectedIndex].value;
	document.getElementById("achat").addEventListener("click",achat);
	remplirTete();

}

//Le js est à solidifer, par exemple si le client édite la page et vire le disabled de "Quel employé ?" on va exécuter ce code et donc tout va nous faire chier, car le php est pas non plus tres sécuriés mais j'ai la fleeeeeemmme 
function requete(event){
	var employe=event.target.value;
	var service=getVariable("id");
	console.log("Envoie de la requete pour "+employe+" réalisant le service "+service);
	var url="webservice.php?employe="+employe+"&service="+service;
	var xhttp=new XMLHttpRequest();
	xhttp.open("GET",url,true);
	xhttp.send();
	xhttp.onreadystatechange = function() {
  		if (xhttp.readyState == 4 && xhttp.status == 200) {
			console.log(xhttp.responseXML);
			remplirTableau(xhttp.responseXML);
			document.body.getElementsByClassName("tableau")[0].addEventListener("click",background);
		}
	}
}
function remplirTete(){
	var tete=document.getElementsByTagName("thead")[0].getElementsByTagName("th");
	var ajd=new Date();
	var jSemaineAjd=ajd.getDay();
	var mois=["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
	if(jSemaineAjd==0)jSemaineAjd=7;
	for(var i=jSemaineAjd;i>=1;i--){
		var jour=ajd.getDate()-(jSemaineAjd-i);
		var date=ajd.getDate();
		tete[i].innerHTML+="<br>"+jour+" "+mois[ajd.getMonth()];
	}
	for(var i=jSemaineAjd+1;i<=7;i++){
		var jour=ajd.getDate()+(i-jSemaineAjd);
		tete[i].innerHTML+="<br>"+jour+" "+mois[ajd.getMonth()];
	}

}

function remplirTableau(xml){
	var creneau=xml.getElementsByTagName("creneau");
	var ligne=document.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
	for(var i=0;i<creneau.length;i++){
		ligne[parseInt(i%11)].childNodes[parseInt(i/11)+1].setAttribute("date",creneau[i].childNodes[0].textContent);
		var heure=new Date();
		heure.setHours(heure.getHours()+2);
		if(creneau[i].childNodes[1].textContent=="Non" || Date.parse(ligne[parseInt(i%11)].childNodes[parseInt(i/11)+1].getAttribute("date"))<heure){
			ligne[parseInt(i%11)].childNodes[parseInt(i/11)+1].innerHTML="<span class=\"glyphicon glyphicon-remove indisponible\"></span>";
		}
	}

}

function background(event){
	var indispo=event.target.childNodes[0];
	if(indispo)
		indispo=indispo.className.split(" ")[2];
	if(event.target.nodeName=="TD" && event.target.className!="heure" && indispo!="indisponible"){ 
		var avant=document.getElementById("selectione");
		if(avant){
			avant.id="";
			avant.innerHTML="";
		}
		event.target.id="selectione";
		event.target.innerHTML="<span class=\"glyphicon glyphicon-ok disponible\"></span>";
	}
}

function achat(){
	
	if(!document.getElementById("achat").hasAttribute("desactive")){
		var heure=document.getElementById("selectione");
		if(heure){
			var listeEmploye=document.getElementById("apteA");
			var employe=listeEmploye.options[listeEmploye.selectedIndex].value;
			var service=getVariable("id");
			document.cookie="date="+heure.getAttribute("date");
			document.cookie="employe="+employe;
			document.cookie="service="+service;
			location.reload();
		}
		else document.getElementById("erreur").innerText="Veuillez choisir un employé ainsi qu'un créneau horaire.";
	}else document.getElementById("erreur").innerText="Il faut être connecté pour acheter un service";
}

function getVariable(variable) {
   var strReturn = "";
  var strHref = window.location.href;
  if ( strHref.indexOf("?") > -1 ){
    var strQueryString = strHref.substr(strHref.indexOf("?")).toLowerCase();
    var aQueryString = strQueryString.split("&");
    for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
      if (aQueryString[iParam].indexOf(variable.toLowerCase() + "=") > -1 ){
        var aParam = aQueryString[iParam].split("=");
        strReturn = aParam[1];
        break;
      }
    }
  }
  return unescape(strReturn);
}