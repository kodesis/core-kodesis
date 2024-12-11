<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Camera</title>
</head>

<body>
    <h2>Access Camera</h2>

    <!-- Video Element to show live camera feed -->
    <video id="video" width="320" height="240" autoplay></video>

    <!-- Button to capture a photo -->
    <button id="snap">Capture</button>

    <!-- Canvas to show captured photo -->
    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

    <script>
        // Access the camera and display the feed in the video element
        const video = document.getElementById('video');
        const snapButton = document.getElementById('snap');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        // Request camera access
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err) {
                console.log("Error: " + err);
            });

        // Capture the photo when the button is clicked
        snapButton.addEventListener('click', function() {
            // Draw the video frame on the canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            // Convert canvas to base64 image
            const imageData = canvas.toDataURL('image/png');

            // Send the image data to PHP (AJAX)
            sendToServer(imageData);
        });

        // Function to send the captured image to PH
    </script>
</body>

</html>