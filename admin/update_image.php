<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageId = $_POST['image_id'];
    $newDescription = $_POST['description'];
    $imageUpdated = false;

    // Check if a new image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $targetDir = 'uploads/';
        $newImageName = basename($image['name']);
        $targetFile = $targetDir . $newImageName;

        // Upload the new image
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Delete the old image file
            $stmt = $conn->prepare("SELECT image FROM images WHERE id = ?");
            $stmt->bind_param("i", $imageId);
            $stmt->execute();
            $result = $stmt->get_result();
            $oldImage = $result->fetch_assoc()['image'];

            if (file_exists("uploads/$oldImage")) {
                unlink("uploads/$oldImage");
            }

            // Set the new image name for updating in the database
            $imageUpdated = true;
        } else {
            echo "Failed to upload the new image.";
            exit;
        }
    }

    // Update the database
    if ($imageUpdated) {
        $stmt = $conn->prepare("UPDATE images SET image = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $newImageName, $newDescription, $imageId);
    } else {
        $stmt = $conn->prepare("UPDATE images SET description = ? WHERE id = ?");
        $stmt->bind_param("si", $newDescription, $imageId);
    }

    if ($stmt->execute()) {
        echo "Image updated successfully.";
    } else {
        echo "Failed to update image.";
    }
}

header("Location: admin.php");
exit;
?>
