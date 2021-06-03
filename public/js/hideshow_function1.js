 $(document).ready(function () {    

     // ? Dès qu'on clique sur #b1, on applique hide() au titre

         $ ("#connectModal_1").click(function(){
             $("house1").hide();
         });
         
     // ? Dès qu'on clique sur #b1, on applique show() au titre

         $ ("#b2").click(function(){
             $("house1").show();
         });

 });