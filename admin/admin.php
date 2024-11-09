<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* Add a basic reset for padding and margin */
        body, h1, form, input, textarea, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
 /* Basic reset */
 * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header styling */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 15px 30px;
            color: #fff;
        }

        /* Logo or Home button */
        .header .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
        }

        /* Navigation links styling */
        .header .nav-links {
            display: flex;
            gap: 20px;
        }

        /* Individual link styling */
        .header .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1em;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect on links */
        .header .nav-links a:hover {
            background-color: #555;
        }

        /* Logout button style */
        .header .nav-links .logout {
            background-color: #ff4d4d;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Logout button hover effect */
        .header .nav-links .logout:hover {
            background-color: #ff1a1a;
        }
        /* Basic styling for the form */
        form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }

        /* Styles for the button */
        button {
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        /* Background slideshow effect */
        body {
            background-image: url('slide1.jpg'), url('slide2.jpg'), url('slide3.jpg');
            background-size: cover;
            background-position: center;
            animation: backgroundSlideshow 30s infinite;
        }

        @keyframes backgroundSlideshow {
            0% { background-image: url('slide1.jpg'); }
            33% { background-image: url('slide2.jpg'); }
            66% { background-image: url('slide3.jpg'); }
            100% { background-image: url('slide1.jpg'); }
        }
    </style>
</head>
<body>
<header class="header">
        <!-- Home button/logo -->
        <a href="home.html" class="logo">Home</a>

        <!-- Navigation links -->
        <div class="nav-links">
            <a href="gallery.php">Gallery</a>
            <a href="todo.html">To-Do List</a>
            <a href="welcome.html" class="logout">Logout</a>
        </div>
    </header>

    <h1>Admin Panel</h1>
    <form action="process.php" method="POST" enctype="multipart/form-data">
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" required>
        
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        
        <input type="hidden" name="action" value="add">
        <button type="submit">Add Image</button>
    </form>

    <h2>Edit or Delete Images</h2>
    <?php
        // Fetch existing images and descriptions from database
        include 'fetch_images.php';
    ?>

    <div id="image-list">
        <!-- Dynamic PHP Content -->
    </div>
</body>
</html>
