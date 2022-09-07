/** If we want to use this module in another project we need to require bootstrap.php 
 * Don't forgot to add all the Vue dependency  there.
 * 
 * require('./../../../../resources/js/bootstrap');
 * **/



$(document).ready(function() {
   


  $("#addPancard").click(function(){
    document.getElementById("demo").innerHTML="Upload Your Pan Card";
    var data = "<input type='file' name=pancard id='pan'><br><br> <input type='submit' class='btn btn-primary' value='submit'>";
    document.getElementById('formelment').innerHTML=data;

  })
  
  $("#addAadhar").click(function(){
    document.getElementById("demo").innerHTML="Upload Your Aadhar Card";
    var data = "<input type='file' name='aadhar' id='aadhar'><br><br> <input type='submit' class='btn btn-primary' value='submit'>";
    document.getElementById('formelment').innerHTML=data;
  
  })

  $("#addSignature").click(function(){
    document.getElementById("demo").innerHTML="Upload Your Signature";
    var data = "<input type='file' name='signature' id='signature'><br><br> <input type='submit' class='btn btn-primary' value='submit'>";
    document.getElementById('formelment').innerHTML=data;
  })
   
});




   $("#removeform").click(function (){
      document.getElementById("myform").remove();
    })
  




