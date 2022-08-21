<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' /> --}}
</head>

<body>
  <div class="container">
    <div class="row my-2">
      <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
        <div>
          <h2 class="text-primary">@yield('heading')</h2>
        </div>
        <div>
          <a href="@yield('link')" class="btn btn-success float-right">@yield('link_text')</a>
        </div>

      </div>
    </div>
    <hr class="my-2">

    @yield('content')

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"></script>
</body>
</html>
