<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src = "{{asset('jquery\jquery.js')}}"></script>
  <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
  <script src="https://use.fontawesome.com/46ea1af652.js"></script>
  <style>
    .header {
      background-color: #2e3445;
      height: 80px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .btn {
      cursos: pointer;
      background-color: #ed657d;
      color: #f2f2f2;
      text-align: center;
      margin: 5px;
      padding: 15px 35px;
      border: 1px solid transparent;
      border-radius: 4em;
      box-shadow: 5px 5px 4px rgba(0, 0, 0, .2);
      outline: 0;
      transition: .8s:
      will-change: transform;
      z-index: 9999;
    }

    .btn:active {
      transform: scale(.9);
    }
    .notification {
      width: 50px;
      height: inherit;
      color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .notification::after {
      min-width: 20px;
      height: 20px;
      content: attr(data-count);
      background-color: #ed657d;
      font-family: monospace;
      font-weight: bolt;
      font-size: 14px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      position: absolute;
      top: 5px;
      right: 5px;
      transition: .3s;
      opacity: 0;
      transform: scale(.5);
      will-change: opacity, transform;
    }

    .notification.show-count::after {
      opacity: 1;
      transform: scale(1);
    }

    .notification::before {
      content: "\f0f3";
      font-family: "FontAwesome";
      display: block;
    }

    .notification.notify::before {
      animation: bell 1s ease-out;
      transform-origin: center top;
    }

    @keyframes bell {
      0% {transform: rotate(35deg);}
      12.5% {transform: rotate(-30deg);}
      25% {transform: rotate(25deg);}
      37.5% {transform: rotate(-20deg);}
      50% {transform: rotate(15deg);}
      62.5% {transform: rotate(-10deg)}
      75% {transform: rotate(5deg)}
      100% {transform: rotate(0);}  
    }
  </style>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('c70441997e3d2b65ebed', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('App\\Events\\sendName', function(data) {
      let angka = parseInt($("#notif").innerHTML);
      angka = angka + 1;
      alert('Ada Laporan Masuk. Silahkan Cek Laporan.');
      
      alert(JSON.stringify(data));
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
    <header class="header">
      <button id="button" class="btn">Send notification</button>
      <div id="notification" class="notification"></div>
    </header>
  </p>
  <script>
    const $button = document.getElementById('button');
    const $bell = document.getElementById('notification');

    $button.addEventListener("click", function(event){
      const count = Number($bell.getAttribute('data-count')) || 0;
      
      $bell.setAttribute('data-count', count + 1);
      $bell.classList.add('show-count');
      $bell.classList.add('notify');
    });

    $bell.addEventListener("animationend", function(event){
      $bell.classList.remove('notify');
    });
  </script>
</body>
</html>