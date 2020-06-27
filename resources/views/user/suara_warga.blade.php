{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        var onloadCallback = function() {
          grecaptcha.render('html_element', {
            'sitekey' : '6LewHKoZAAAAAHZySR29OeUNPV59UJJdt98M1qmG'
          });
        };
    </script>
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Suara Warga Prambanan</h1>
    </header>
    <div class="content">
        <div class="progress-bar">
            <div class="bar">
                <div class="garis pertama"></div>
                <div class="garis pertama"></div>
                <div class="garis pertama"></div>
            </div>
        </div>
        <div id="form">
            <form action="?" method="POST">
            <div class="g-recaptcha" data-sitekey="your_site_key"></div>
            <br/>
            <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html> --}}

<html>
  <head>
    <title>reCAPTCHA demo: Simple page</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        var onloadCallback = function() {
          alert("grecaptcha is ready!");
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
  </script>
  </head>
  <body>
    <form action="?" method="POST">
      <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
      <br/>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>