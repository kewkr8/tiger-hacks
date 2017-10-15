
var myVar = setInterval(myTimer, 1000);
var d = 0;
function myTimer() {
    d++;
    document.getElementById("demo").innerHTML = d;
} 


function resetTimer(){
    d = 0;
    console.log("yo");
    //myVar = setInterval(myTimer, 1000);

}