
MESSAGES = [
    "How many exams?",
    "Insert grades (from 18 to 33)",
    "This is not a valid grade"
];

//constructor
function Statistico(num) {
    this.nExams = num;
    // this.exams = new Array();
    // this.grades = new Array();
    // this.min	= 0;
    // this.mas 	= 0;
    // this.med	= null;
    // this.variab	= null;
}	

Statistico.prototype.insert() = function(){
    this.nExams = prompt(MESSAGES[1]);

    for(let i=0; i<nExams; i++){
        this.exams[i] = prompt("Exams?");
        this.grades[i] = prompt("Grade?");
    }
}


Statistico.prototype.stampaTabellaVoti = function() {
	document.write("<h3> DIOCANE</h3>");
    document.write("<h3> There are " + this.nExams + " exams</h3>");
    /*document.writeln("<div id=\"tabellaVoti\">");
	document.writeln("<table>")
	document.writeln("<caption>Elenco Esami</caption>");
	document.writeln("<tr><th>Voti");
	
	for (let i = 0; i < this.voti.length; i++)
		document.writeln("<tr><td>" + this.voti[i]);
	
	document.writeln("</table>");
	document.writeln("</div>")
    */
}

Statistico.prototype.stampa = function() {
	// Stampa intestazione pagina HTML (doctype e head)
	document.writeln("<!DOCTYPE hmtl>");
	document.writeln("<html><head><meta charset=\"utf-8\">");
    document.writeln("<title>Libretto universitario</title>");
	document.writeln("<link rel=\"stylesheet\" href=\"./css/libretto.css\" type=\"text/css\" media=\"screen\"> <!-- css --></head>");
	
	// Qua inizia il <body>
	document.writeln("<body>");
	document.writeln("<div id=\"wrapper\">");
	document.writeln("<div id=\"topnav\"><img src=\"./css/img/unipi_logo.png\" alt=\"Logo\"></div>");
	document.writeln("<p>Libretto Universitario</p>");
	
	this.stampaTabellaVoti();
	
	document.writeln("</div>");
	document.writeln("</body>");
	document.writeln("</html");
}


function main() {
    const num = window.prompt(MESSAGES[0]);

    const stat = new Statistico(num);
    
    stat.stampa();
}
