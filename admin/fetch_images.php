<?php
include 'db.php'; // Include the database connection

// Prepare and execute the query to fetch images
$stmt = $conn->prepare("SELECT * FROM images ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any images
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = 'uploads/' . htmlspecialchars($row['image']);
        $description = htmlspecialchars($row['description']);
        $imageId = $row['id'];

        // Display each image and its description with edit/delete options
        echo '<div class="image-item">';
        echo '<img src="' . $imagePath . '" style="width:100%; max-width:300px;">';
        echo '<p>' . $description . '</p>';

        // Edit button (separate form for edit)
        echo '<form action="edit_image.php" method="GET" style="display:inline-block;">';
        echo '<input type="hidden" name="id" value="' . $imageId . '">';
        echo '<button type="submit">Edit</button>';
        echo '</form>';

        // Delete button (separate form for delete)
        echo '<form action="process.php" method="POST" style="display:inline-block;">';
        echo '<input type="hidden" name="image_id" value="' . $imageId . '">';
        echo '<button type="submit" name="action" value="delete">Delete</button>';
        echo '</form>';

        echo '</div>';
    }
} else {
    echo "<p>No images found.</p>";
}
?>
