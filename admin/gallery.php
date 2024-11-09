<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        /* Background styling */
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Title styling */
        h1 {
            text-align: center;
            font-size: 2.5em;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin-top: 50px;
        }

        /* Slideshow container */
        .slideshow-container {
            position: relative;
            max-width: 80%;
            margin: 30px auto;
            border: 2px solid #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Slide images */
        .mySlides {
            display: none;
            width: 100%;
            border-radius: 10px;
            transition: transform 0.5s ease-in-out;
        }

        /* Image animation */
        .mySlides.fade {
            opacity: 0;
            transition: opacity 1s;
        }

        /* Image description */
        .description {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            background: rgba(0, 0, 0, 0.6);
            color: #ffffff;
            padding: 10px;
            font-size: 1.2em;
            border-radius: 0 0 10px 10px;
        }

        /* Navigation dots */
        .dot-container {
            text-align: center;
            margin-top: 15px;
        }

        .dot {
            height: 15px;
            width: 15px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .active, .dot:hover {
            background-color: #717171;
        }
    </style>
</head>
<body>
    <h1>Image Gallery</h1>
    <div class="slideshow-container">
        <?php
            include 'fetch_images.php'; // Display images in a loop
        ?>
    </div>
    <div class="dot-container">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
                slides[i].classList.remove("fade");
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1; }
            slides[slideIndex - 1].style.display = "block";
            slides[slideIndex - 1].classList.add("fade");
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 3000); // Change image every 3 seconds
        }

        function currentSlide(n) {
            slideIndex = n - 1;
            showSlides();
        }
    </script>
</body>
</html>
