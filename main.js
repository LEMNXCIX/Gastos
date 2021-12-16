
var slideIndex = 0;
showSlides();
responsiveIcons();
function responsiveIcons(){
 
  console.log("La resolución de tu pantalla es: " + window.outerWidth);

}

function showSlides() {
       var i;
       var slides = document.getElementsByClassName("mySlides");
       for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
       }
       slideIndex++;
       if(slideIndex > slides.length) {slideIndex = 1}
       slides[slideIndex-1].style.display = "block";
     setTimeout(showSlides,5000);
}
function plusSlides(){
  showSlides()
}
function iniciarSesion(){
    document.getElementById("pop-up").style.display="block";
    document.getElementById("pop-up2").style.display="block";
}
function cerrar(){
    document.getElementById("pop-up").style.display="none";
    document.getElementById("pop-up2").style.display="none";
  
  }

 
 