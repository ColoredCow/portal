<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h2>ColoredCow</h2>
    <h3 class="text-center">Offer Letter</h3>
    <hr>    
    <p class="text-justify">
      Dear : {{$applicant->name}},<br>
            {{$applicant->email}}<br><br>
            {{$offer_letter_body}}<br><br>

      Sincerely,

    </p>
    
  </body>
</html>