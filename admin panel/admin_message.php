<?php  
include '../components/connect.php';

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {     
    $seller_id = $_COOKIE['seller_id']; 
} else {     
    header('location:login.php');     
    exit; // Ensure the script stops after the redirect 
}  

// Delete message from the database
if (isset($_POST['delete_msg'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $con->prepare("SELECT * FROM `message` WHERE id = ?");
    $verify_delete->bind_param("s", $delete_id);
    $verify_delete->execute();
    $result = $verify_delete->get_result();

    if ($result->num_rows > 0) {
        $delete_msg = $con->prepare("DELETE FROM `message` WHERE id = ?");
        $delete_msg->bind_param("s", $delete_id);
        $delete_msg->execute();
        $success_msg[] = 'Message deleted successfully';
    } else {
        $warning_msg[] = 'Message already deleted';
    }
}
?> 


<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Seller Dashboard</title>     
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 
</head> 
<style>
    .box-container {
    display: flex;
    flex-wrap: wrap; /* Allows boxes to wrap onto the next row */
    justify-content: center; /* Centers the boxes horizontally */
    gap: 2rem; /* Equal spacing between the boxes */
    padding: 2rem; /* Padding around the container */
    background-color: #f7f9fc; /* Light background for contrast */
    border-radius: 10px; /* Rounded corners for the container */
}

.box {
    background-color: #ffffff; /* White background for each box */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    padding: 1.5rem; /* Internal padding for content */
    width: 100%; /* Default width */
    max-width: 520px; /* Ensures all boxes have the same width */
    height: 400px; /* Fixed height for uniform size */
    display: flex;
    flex-direction: column; /* Stacks child elements vertically */
    justify-content: space-between; /* Ensures content is spaced evenly */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
}

.box:hover {
    transform: translateY(-5px); /* Slightly lifts the box on hover */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* More prominent shadow on hover */
}

.box h3.name {
    font-size: 1.3rem; /* Larger font for name */
    font-weight: bold;
    color: #333; /* Neutral dark text */
    margin-bottom: 0.8rem;
    margin-top: 2rem; /* Space below the name */
}

.box h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #555; /* Slightly lighter text for the subject */
    margin-bottom: 0.8rem;
    margin-top:4rem; /* Space below the subject */
}

.box p {
    font-size: 1rem;
    line-height: 1.6; /* Improves readability */
    color: #666; /* Muted text color */
    margin-bottom: 1rem; /* Space below the message */
    overflow: hidden; /* Prevents overflow if content exceeds height */
    text-overflow: ellipsis; /* Adds ellipsis for long text */
    display: -webkit-box; /* Limits displayed lines */
    -webkit-line-clamp: 3; /* Shows only 3 lines */
    -webkit-box-orient: vertical; /* Ensures the ellipsis works properly */
}

.box form {
    margin-top: auto; /* Pushes the button to the bottom */
    text-align: center; /* Centers the button */
}


    </style>
<body>   
    <div class="main-container">     
        <?php include '../components/admin_header.php'; ?>     
        
        <section class="dashboard">         
            <div class="heading">             
                <h1>Unread Messages</h1>             
                <img src="../image/separator-img.png" alt="Separator">         
            </div>         
            
            <div class="box-container">             
                <?php             
                $select_message = mysqli_query($con, "SELECT * FROM `message`");             

                if (mysqli_num_rows($select_message) > 0) {                 
                    while ($fetch_message = mysqli_fetch_assoc($select_message)) {                     
                        ?>                     
                        <div class="box">                         
                            <h3 class="name"><?=$fetch_message['name']; ?></h3>                         
                            <h4><?=$fetch_message['subject']; ?></h4>                         
                            <p><?=$fetch_message['message']; ?></p>                         
                            <form action="" method="post">                             
                                <input type="hidden" name="delete_id" value="<?=$fetch_message['id'];?>">                             
                                <input type="submit" name="delete_msg" value="Delete Message" class="btn" onclick="return confirm('Delete this message?');">                         
                            </form>                     
                        </div>                     
                        <?php                   
                    }             
                } else {                 
                    echo '                 
                    <div class="empty">                     
                        <p>No unread messages yet!</p>                 
                    </div>';             
                }             
                ?>  
            </div>
        </section>   
    </div> <!-- Closing main-container div -->   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>   
    <script src="../js/admin_script.js"></script>   
    <?php include '../components/alert.php'; ?> 
</body> 
</html>
