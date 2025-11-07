<?php 
include 'auth_check.php'; 
include '../components/connect.php';

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit;
}

// Fetch seller details
$fetch_profile = [];
$select_seller = $con->prepare("SELECT * FROM `sellers` WHERE id = ?");
$select_seller->bind_param("i", $seller_id);
$select_seller->execute();
$result = $select_seller->get_result();
if ($result->num_rows > 0) {
    $fetch_profile = $result->fetch_assoc();
} else {
    header('location:login.php');
    exit;
}

// Update profile logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image_name;

    // Update query
    if (!empty($name) && !empty($image_name)) {
        move_uploaded_file($image_tmp_name, $image_folder);

        $update_profile = $con->prepare("UPDATE `sellers` SET name = ?, image = ? WHERE id = ?");
        $update_profile->bind_param("ssi", $name, $image_name, $seller_id);
        $update_profile->execute();

        $success_message = "Profile updated successfully!";
    } elseif (!empty($name)) {
        $update_profile = $con->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");
        $update_profile->bind_param("si", $name, $seller_id);
        $update_profile->execute();

        $success_message = "Name updated successfully!";
    } elseif (!empty($image_name)) {
        move_uploaded_file($image_tmp_name, $image_folder);

        $update_profile = $con->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
        $update_profile->bind_param("si", $image_name, $seller_id);
        $update_profile->execute();

        $success_message = "Profile picture updated successfully!";
    } else {
        $error_message = "No changes made to the profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="update-profile">
        <div class="heading">
            <h1>Update Profile</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= $fetch_profile['name']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="image">Profile Picture:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn">Update Profile</button>
            </form>
            <?php if (isset($success_message)) { ?>
                <p class="success"><?= $success_message; ?></p>
            <?php } ?>
            <?php if (isset($error_message)) { ?>
                <p class="error"><?= $error_message; ?></p>
            <?php } ?>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>
<?php 
include 'auth_check.php'; 
include '../components/connect.php';

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit;
}

// Fetch seller details
$fetch_profile = [];
$select_seller = $con->prepare("SELECT * FROM `sellers` WHERE id = ?");
$select_seller->bind_param("i", $seller_id);
$select_seller->execute();
$result = $select_seller->get_result();
if ($result->num_rows > 0) {
    $fetch_profile = $result->fetch_assoc();
} else {
    header('location:login.php');
    exit;
}

// Update profile logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image_name;

    // Update query
    if (!empty($name) && !empty($image_name)) {
        move_uploaded_file($image_tmp_name, $image_folder);

        $update_profile = $con->prepare("UPDATE `sellers` SET name = ?, image = ? WHERE id = ?");
        $update_profile->bind_param("ssi", $name, $image_name, $seller_id);
        $update_profile->execute();

        $success_message = "Profile updated successfully!";
    } elseif (!empty($name)) {
        $update_profile = $con->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");
        $update_profile->bind_param("si", $name, $seller_id);
        $update_profile->execute();

        $success_message = "Name updated successfully!";
    } elseif (!empty($image_name)) {
        move_uploaded_file($image_tmp_name, $image_folder);

        $update_profile = $con->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
        $update_profile->bind_param("si", $image_name, $seller_id);
        $update_profile->execute();

        $success_message = "Profile picture updated successfully!";
    } else {
        $error_message = "No changes made to the profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="update-profile">
        <div class="heading">
            <h1>Update Profile</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= $fetch_profile['name']; ?>" required>
                </div>
                <div class="input-group">
                    <label for="image">Profile Picture:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn">Update Profile</button>
            </form>
            <?php if (isset($success_message)) { ?>
                <p class="success"><?= $success_message; ?></p>
            <?php } ?>
            <?php if (isset($error_message)) { ?>
                <p class="error"><?= $error_message; ?></p>
            <?php } ?>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>
