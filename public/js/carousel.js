 var slideIndex = 1;
   showSlides(slideIndex);
 
 // * Controle Suivant/Précédent
   function plusSlides(n) 
     {
       showSlides(slideIndex += n);
     }
 
 // * Thumbnail image controls
   function currentSlide(n)
     {
       showSlides(slideIndex = n);
     }
 
 function showSlides(n) 
   {
     var i;
     var slides = document.getElementsByClassName("mySlides");
     var dots = document.getElementsByClassName("demo");
     var captionText = document.getElementById("caption");
     var column = document.getElementsByClassName("column");

       if (n > slides.length) {slideIndex = 1}
       if (n < 1) {slideIndex = slides.length}

         for (i = 0; i < slides.length; i++)
           {
             slides[i].style.display = "none";
             //_gd calcule de la larger des column en fonction du nombre de slide.
             column[i].style.width =  100/slides.length+"%";
           }

         for (i = 0; i < dots.length; i++) 
           {
             dots[i].className = dots[i].className.replace(" active", "");
           }

       slides[slideIndex-1].style.display = "block";
       dots[slideIndex-1].className += " active";
       captionText.innerHTML = '<a href="service/'+dots[slideIndex-1].id+'"/>'+dots[slideIndex-1].alt+'</a>';
   }
