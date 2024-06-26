<?php
    $Country = "Sri Lanka";
    $user_id = $_SESSION['userId']; 
    // print_r($_SESSION); // at the loginSeller.controller.php
?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKILLSPARQ</title>
    <link rel="stylesheet" href="./assests/css/sellerHeader.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/sellerDashboard.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/sellerProfile.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/editSellerProfile.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/jobCard.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/addGig.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/displayJob.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/updateGig.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/earnings.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/order.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/gigCard.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/manageOrders.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/sentProposals.styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assests/css/helpCenter.styles.css">
    <link rel="stylesheet" href="./assests/css/help.styles.css">
    <link rel="stylesheet" href="./assests/css/chat.styles.css">
    <link rel="stylesheet" href="./assests/css/search.styles.css">
    <link rel="stylesheet" href="./assests/css/displayGig.styles.css">
    <link rel="stylesheet" href="./assests/css/userHelp.styles.css">
    <link rel="stylesheet" href="./assests/css/sharePoint.styles.css">
    <link rel="stylesheet" href="./assests/css/feedbackCard.styles.css">
    <link rel="stylesheet" href="./assests/css/milestoneCard.styles.css">
    <link rel="stylesheet" href="./assests/css/footer.styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
</head>

<body>
    <header>

        <div class="upperHeader">
            <div class="logo">
                <a href="home">SKILLSPARQ</a>
            </div>
            <div class="navbar">
                <nav>
                    <ul class="nav-links">
                        <li class="wordLink"><a href="sellerDashboard">Home</a></li>
                        <li class="wordLink"><a href="manageOrders">Orders</a></li>
                        <li class="wordLink"><a href="sentJobProposals">Proposals</a></li>
                        <!-- <li class="wordLink"><a href="earnings">Earnings</a></li> -->
                        <li class="wordLink"><a href="helpCenter">Help Center</a></li>
                    </ul>
                </nav>
                <nav>
                    <ul class="nav-links">
                        <div class="svgLinks">
                            <li class="notificationIcon">
                                <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                    </svg>
                                    <div class="notificationSign"></div>
                                    <div class="notificationBox">
                                        <ul class="notificationList">
                                            <!-- Notification items will be populated here -->
                                        </ul>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="wordLinks">
                            <li><a href="loginUser/logout" class="wordLink">Sign Out</a></li>
                        </div>

                        <li class="imgLinks">
                            <a href="sellerProfile" class="imgLink">
                                <?php
                                
                                ?>
                                <?php 
                                    if(isset($_SESSION['profilePicture'])){
                                ?>
                                    <img src="../public/assests/images/profilePictures/<?php echo $_SESSION['profilePicture']?>" alt="pro-pic">
                                <?php
                                    }else{
                                ?>
                                    <img src="../public/assests/images/dummyprofile.jpg" alt="pro-pic">
                                <?php
                                    }
                                ?>
                                
                                <div class="loginSign"></div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </header>
<script src="./assests/js/notifications.script.js"></script>
