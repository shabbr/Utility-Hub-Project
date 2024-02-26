 <!-- resources/views/qrcode.blade.php -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>QR Code Generator</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <script src="https://cdn.rawgit.com/kimmobrunfeldt/progressbar.js/1.0.1/dist/progressbar.min.js"></script>
     <style>
         body {
             background-color: #f5f5f5;
         }
        h1,h2,a{
     font-family: 'Poppins';
 }

       .card {
             max-width: 435px;
             margin: 0 auto;
         }


         .hidden {
             display: none;
         }

         </style>
 </head>
 <body>
    <div class="container mt-5">
        <div class="card">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <div class="container-fluid justify-content-between">
                    <a class="navbar-brand" href="{{ route('shortUrl') }}">Short Url</a>
                    <a class="navbar-brand" href="{{ route('barcode.show-form') }}">BarCode</a>
                    <a class="navbar-brand" href="{{ route('qrCodeForm') }}">QrCode</a>
                </div>
            </nav>
            <div class="card-body">
                    <h1 class="card-title">Short Url Generator</h1>
                 <form action="{{ route('shorten') }}" method="post">
                     @csrf
                     <div class="form-group">
                         <label for="urlInput">Enter URL:</label>
                         <input type="url" class="form-control" name="original_url" id="urlInput" required>
                     </div>
                     <button type="submit"  class="btn btn-primary mx-auto d-block loading-link">Short Url</button>
                 </form>
                 <button id="loadButton" class="btn mt-2 btn-primary mx-auto d-block"  >Load Results</button>

                    <div class="container mt-4">
                     <div id="circle-progress" class="mx-auto" style="width: 100px;"></div>
                 </div>
                 @if(!isset($shortUrl))
                 <script>
                  $(document).ready(function () {
                     $('#loadButton').remove();
                   });
                 </script>
                 @else
                 <script>
                  $(document).ready(function () {
                     $('#loadButton').append();
                   });
                 </script>
               @endif
     @if(isset($shortUrl))
   <script>
     $(document).ready(function () {
         // Initialize ProgressBar.js
         // Initialize ProgressBar.js with Circle shape
         $('#loadButton').click(function (e) {
             var circle = new ProgressBar.Circle('#circle-progress', {
                 color: '#007bff', // Set the initial color of the circle
                 strokeWidth: 6, // Set the width of the circle's stroke
                 trailColor: '#eee', // Set the color of the trail behind the circle
                 trailWidth: 15, // Set the width of the trail
                 duration: 2000, // Set the duration of the animation (in milliseconds)
                 easing: 'easeInOut',
                 text: {
                     autoStyleContainer: false // Disable text style
                 },

             });

             // Animate the circle indefinitely
             circle.animate(1, {
                 from: { color: '#007bff' }, // Set the initial color
                 to: { color: '#ff9900' }, // Set the color it transitions to
                 step: function(state, circle, attachment) {
                     // Change the color of the circle continuously
                     circle.path.setAttribute('stroke', state.color);
                 },
                 repeat: true // Repeat the animation indefinitely
             });
             setTimeout(function() {
             // Destroy the circle and hide it
             $('#loadButton').remove();
             circle.destroy();
             $("#results").show();
         }, 3000);

         });


         });

   </script>
                     <div id="results" style="display: none">
                         <h3>Your Shortend Link: </h3>
                         <div  class="text-center mt-1"> {!! $shortUrl !!} </div>
                         <a href="{{route('redirect', ['short_url' => $shortUrl])}}" class="mt-1 text-center mx-auto d-block">
                          click here to access url
                         </a>
                     @endif
                     </div>
             </div>
         </div>
     </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





 </body>
 </html>
