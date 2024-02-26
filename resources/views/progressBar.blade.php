<!-- resources/views/loading-button.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Button Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <!-- Button to Trigger Loading -->
    <button id="loadButton" class="btn btn-primary">Load Results</button>

    <!-- Loading Bar -->
    <div id="loading-bar" class="progress" style="display: none;">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <!-- Results Section (Initially Hidden) -->
    <div id="results" style="display: none;">
        <h2>Results</h2>
        <p>This is your content.</p>
    </div>

    <!-- JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom Script -->
    <script>
        $(document).ready(function() {
            // Button Click Event
            $('#loadButton').click(function() {
                // Show loading bar
                $('#loading-bar').show();

                // Simulate asynchronous operation (e.g., fetching data from the server)
                setTimeout(function() {
                    // Hide loading bar after a delay (you can replace this with your actual async operation)
                    $('#loading-bar').hide();

                    // Show the results
                    $('#results').show();
                }, 2000); // Simulated delay of 2 seconds (replace with your actual async operation time)
            });
        });
    </script>

</body>
</html>
