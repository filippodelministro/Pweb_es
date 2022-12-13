let score = 0;
let previous_cellID = -1
let previous_imgID = -1


// Prende in ingresso l'id di una cella
// e la "scopre"
// Scoprire una casella e' implementato come 
// aggingere un figlio img al div
// test vale false: la prima volta vengono mostrate tutte
//                  le immagini ma non cerchiamo coppie
// test vale true: mostriamo l'immagine e eseguiamo un 
//                 test per verificare se e' stata trovata una 
//                 coppia
function showImg(cellID, test) {
	console.log(previous_cellID, previous_imgID);
    
    let imgID;
    // Chiedo al server quale immagine deve essere associata
    // alla cella con l'id specificato
    let xhttpclient = new XMLHttpRequest();
    xhttpclient.open("GET", "get_id.php?id="+cellID);
    xhttpclient.send();
    // Arriva la risposta del server
    xhttpclient.onload = function() {
        imgID = xhttpclient.response;
        console.log("cellID = " + cellID + ", imgID = " + imgID);
        let imgpath = "<img src='https://picsum.photos/id/"+imgID+"/100' />";
        let img = document.getElementById(cellID);    
        img.innerHTML = imgpath;
        
        // Se test vale true vuol dire che vogliamo eseguire un test 
        // per verificare se due carte sono uguali o meno
        if (test) { 
            if (previous_cellID == -1) { 
                // sono alla prima carta che viene scoperta
                previous_cellID = cellID;
                previous_imgID = imgID;
            } else if (previous_imgID == imgID) { 
                // sono alla seconda carta ed ha lo stesso valore
                previous_imgID = -1;
                previous_cellID = -1;
                score++;
                score = document.getElementById('score').innerHTML = score;
            } else { 
                //sono alla seconda carta e non ho indovinato
                setTimeout("removeImage("+previous_cellID+")", 3000);
                setTimeout("removeImage("+cellID+")", 3000);
                previous_imgID = -1;
                previous_cellID = -1;
            }
        }
    };
}

function removeImage(i){
    console.log("remove " + i);
    let elem = document.getElementById(i);
    elem.removeChild(elem.firstChild);
}

// Eseguita al caricamento della pagina
function ready(){
	console.log("START");

	for (let i=0;i<50;i++) {
        // Chiama il server per sapere cosa deve mettere nella
        // casella i-esima
        showImg(i, false);
        // Aggiunge una handler per gli eventi click alla casella i-esima
        document.getElementById(i).addEventListener("click", function(){
            if (this.firstChild) {
                // Se c'e' un figlio vuol dire che la casella e'
                // scoperta. Non faccio nulla.
                return;
            }
            // La casella deve essere scoperta
            // chiamo showImg (con secondo valore a true)
            console.log("CLICK on cell " + this.id);
            showImg(this.id, true);});
	}
    // Inizialmente le caselle sono tutte scoperte
    // Impost un timer in modo da coprirle dopo 5 secondi
    setTimeout(function() {
        for (var i=0;i<50;i++) {
            console.log("remove " + i);
            let elem = document.getElementById(i);
            // Coprire la casella: 
            // rimuovere il figlio immagine
            elem.removeChild(elem.firstChild);
        }
    }, 5000);
};
