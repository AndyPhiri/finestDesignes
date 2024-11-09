<?php
include 'db.php';

// Get the image ID from the query parameter
if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    // Fetch the current image data
    $stmt = $conn->prepare("SELECT * FROM images WHERE id = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $currentImage = $row['image'];
        $currentDescription = $row['description'];
    } else {
        echo "Image not found.";
        exit;
    }
} else {
    echo "No image ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image</title>
</head>
<body>
    <h1>Edit Image</h1>
    <form action="process.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="image_id" value="<?php echo $imageId; ?>">

    <div>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo htmlspecialchars($currentDescription); ?></textarea>
    </div>

    <div>
        <label for="image">Change Image (optional):</label>
        <input type="file" name="image" id="image">
    </div>

    <button type="submit">Update Image</button>
</form>
</body>
</html>
