<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Add new image
    if ($action === 'add' && isset($_FILES['image'], $_POST['description'])) {
        $image = $_FILES['image'];
        $description = $_POST['description'];

        // Handle file upload with unique filename
        $targetDir = 'uploads/';
        $uniqueFilename = uniqid() . '-' . basename($image['name']);
        $targetFile = $targetDir . $uniqueFilename;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO images (image, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $uniqueFilename, $description);
            $stmt->execute();
            echo "Image added successfully.";
        } else {
            echo "Failed to upload image.";
        }
    }

    // Delete image
    if ($action === 'delete' && isset($_POST['image_id'])) {
        $imageId = $_POST['image_id'];

        // Get the image filename before deleting the record
        $stmt = $conn->prepare("SELECT image FROM images WHERE id = ?");
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc()['image'];

        // Delete the image file
        if (file_exists("uploads/$image")) {
            unlink("uploads/$image");
        }

        // Delete the record from the database
        $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        echo "Image deleted successfully.";
    }

    // Edit image description and optionally update image file
    if ($action === 'edit' && isset($_POST['image_id'], $_POST['description'])) {
        $imageId = $_POST['image_id'];
        $newDescription = $_POST['description'];
        $imageUpdated = false;

        // Check if a new image was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $uniqueFilename = uniqid() . '-' . basename($image['name']);
            $targetFile = 'uploads/' . $uniqueFilename;

            // Upload the new image
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                // Get the old image filename
                $stmt = $conn->prepare("SELECT image FROM images WHERE id = ?");
                $stmt->bind_param("i", $imageId);
                $stmt->execute();
                $result = $stmt->get_result();
                $oldImage = $result->fetch_assoc()['image'];

                // Delete the old image file
                if (file_exists("uploads/$oldImage")) {
                    unlink("uploads/$oldImage");
                }

                // Set the new image filename for updating in the database
                $imageUpdated = true;
            } else {
                echo "Failed to upload the new image.";
                exit;
            }
        }

        // Update the database
        if ($imageUpdated) {
            $stmt = $conn->prepare("UPDATE images SET image = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssi", $uniqueFilename, $newDescription, $imageId);
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
}

// Redirect back to the admin page
header("Location: admin.php");
exit;
?>
