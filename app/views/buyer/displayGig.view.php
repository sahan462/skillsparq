<?php 
    include "../app/views/components/buyerSimpleHeader.component.php";
?>

<?php
    $gig = $data['gig'];
    $feedbacks = $data['feedbacks'];
    $profileData = $data['profileData'];
    $seller["profilePicture"] = "avishka.jpg";
    $seller["sellerName"] = "Avishka Idunil";

    $gig["sliderImage-2"] = "slide2.webp";
    $gig["sliderImage-3"] = "slide3.webp";
    $gig["sliderImage-4"] = "slide4.webp";
    $gig['price'] = 200;
?>

<!-- Display Gig Container -->
<div class="displayGigContainer">

    <!-- Modal 1  -->
    <div class="overlay" name="packageOverlay" id="overlay">
        <div class="modal" name="packageModal" id="modal">
            <form id="packageRequestForm" method="post" action="manageOrders/createPackageOrder" enctype="multipart/form-data">
                <div class="row">
                    <label for="requestDescription" class="type-1">Request Description:</label>
                    <label for="requestDescription" class="type-2">Please provide a concise overview of the task you would like to accomplish.</label>
                    <textarea id="requestDescription" name="requestDescription" rows="10" required></textarea>
                </div>

                <div class="row">
                    <label for="attachments" class="type-1">Attachments:</label>
                    <label for="attachments" class="type-2">Kindly upload any attachments as a compressed ZIP file, if applicable.</label>
                    <div class="innerRow" style="display: flex; flex-direction: row; align-items: center;">
                        <label for="packageAttachement" id="attachment" style="margin-right: 4px;">Attachements</label>
                        <div id="warningMessage" class="warningMessage" style="color: red; display: none;">Invalid file type. Only ZIP files are allowed.</div>
                        <span class="fileName" id="fileName"></span>
                    </div>
                    <input type="file" class="fileInput" id="packageAttachement" name="attachments" multiple onchange="displayFileName(0)">
                </div>

                <div class="buttons">
                    <button type="button" onclick="confirmAction('cancel')">Cancel Request</button>
                    <button type="button" onclick="confirmAction('send')">Send Request</button>
                </div>

                <input type="hidden" name="gigId" value="<?php echo $gig['gig_id']?>">
                <input type="hidden" name="sellerId" value="<?php echo $gig['seller_id']?>">
                <input type="hidden" name="orderType" value="package">
                <input type="hidden" name="buyerId" value="<?php echo $_SESSION['userId']?>">
            </form>
        </div>
    </div>

    <!-- Modal 2 -->
    <div class="overlay" name="cancelConfirmationOverlay" id="cancelConfirmationOverlay" style="z-index: 2;">
        <div class="confirmation" name="cancelConfirmationModal" id="cancelConfirmationModal">
            <p>Are you sure want to cancel?</p>
            <div class="buttons">
                <button onclick="handleConfirmation('cancelNo')">No</button>
                <button onclick="handleConfirmation('cancelYes')">Yes</button>
            </div>
        </div>
    </div>

    <!-- Modal 3 -->
    <div class="overlay" name="sendConfirmationOverlay" id="sendConfirmationOverlay" style="z-index: 2;">
        <div class="confirmation" name="sendConfirmationModal" id="sendConfirmationModal">
            <p>Are you sure want to continue?</p>
            <div class="buttons">
                <button onclick="handleConfirmation('sendNo')">No</button>
                <button onclick="handleConfirmation('sendYes')">Yes</button>
            </div>
        </div>
    </div>

    <!-- Modal 4 -->
    <div class="milestoneOverlay" name="milestoneOverlay" id="milestoneOverlay">
        <div class="milestoneModal" name="milestoneModal" id="milestoneModal" style="width: 600px;">
            
            <!-- button to add new milestone -->
            <button type="button" class="createNewMileStone" onclick="addCollapsible()">Create New MileStone</button>
            
            <form id="milestoneRequestForm"  method="post" action="manageOrders/createMilestoneOrder" enctype="multipart/form-data">

                <!-- New milestone appends here -->
                <div id="inputContainer" >
                    <div id="animation" style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center;"></div>
                </div>

                <div class="buttons">
                    <button type="button" onclick="confirmAction('cancel')">Cancel Request</button>
                    <button type="button" onclick="confirmAction('send')">Send Request</button>
                </div>

            </form>
        </div>
    </div>


    <!-- category -->
    <div class="category">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
        </svg>
        <?php echo $gig["category"]; ?> 
    </div>

    <!-- Main Container -->
    <div class="mainContainer">

        <!-- Top Container -->
        <div class="topContainer">

            <!--Top Left Container  -->
            <div class="topLeftContainer">

                <div class="gigTitle">
                    <h1>
                        <?php echo $gig["title"]; ?>
                    </h1>
                </div>
                <div class="gigDetails" style="margin-bottom: 16px;display: flex; gap:16px;">
                    <span class="type-2">Created On : <?php echo $gig['created_at']; ?></span>
                    <span class="type-2">|</span>
                    <span class="type-2">Active Orders : <?php echo $gig['ongoing_order_count']; ?></span>
                </div>
                <div class="seller">
                    <div class="image">
                        <img src="../public/assests/images/profilePictures/<?php echo $profileData['profile_pic']?>" loading="lazy">
                    </div>
                    <div class="sellerName">
                        <a href="">
                            <?php echo $profileData["first_name"]."   ".$profileData['last_name']; ?>
                        </a>
                    </div>
                </div>
                <div class="gigImageSlider">
                    <div class="sliderContainer">
                        <div class="showSlide fade">
                            <img src="../public/assests/images/gigImages/<?php echo $gig["cover_image"]?>" loading="lazy">
                            <div class="content"></div>
                        </div>
                        <div class="showSlide fade">
                            <img src="../public/assests/images/<?php echo $gig["sliderImage-2"]?>" loading="lazy">
                            <div class="content"></div>
                        </div>
                
                        <div class="showSlide fade">
                            <img src="../public/assests/images/<?php echo $gig["sliderImage-3"]?>" loading="lazy">
                            <div class="content"></div>
                        </div>
                        <div class="showSlide fade">
                            <img src="../public/assests/images/<?php echo $gig["sliderImage-4"]?>" loading="lazy">
                            <div class="content"></div>
                        </div>
                        <!-- Navigation arrows -->
                        <div class="navigationArrows">
                            <a class="left" onclick="nextSlide(-1)">&#10094;</a>
                            <a class="right" onclick="nextSlide(1)">&#10095;</a>
                        </div>
                    </div> 
                </div>
            </div>

            <!-- Top Right Container -->
            <div class="topRightContainer" >

                <!--packages  -->
                <div class="packageDetails" >
                    <div class="package-tabs">
                        <div class="tab">
                            <button class="tablinks" onclick="openCity(event, 'London')" id = "defaultOpen" style="border-radius: 8px 0 0 0;">Basic</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Standard</button>
                            <button class="tablinks" onclick="openCity(event, 'Tokyo')" style="border-radius: 0 8px 0 0;">Premium</button>
                        </div>
                    
                        <!-- package 1 -->
                        <div id="London" class="tabcontent" style="display: block;">
                            <div class="columns">
                                <ul class="price">
                                    <div class="row" style="display: flex; justify-content:space-between;padding: 8px"> 
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                            </svg>
                                            <span>USD <?php echo $gig[0]['package_price']; ?></span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                                <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                            </svg>
                                            <span><?php echo $gig[0]['no_of_delivery_days']; ?> <?php echo $gig[2]['time_period']; ?> Delivery</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16">
                                                <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
                                            </svg>
                                            <?php echo $gig[0]['no_of_revisions']; ?> Revisions
                                        </li>
                                    </div>
                                    <li><?php echo $gig[0]['package_description']; ?></li>

                                    <form id="package_1" method="post" action="manageOrders/createPackageOrder" enctype="multipart/form-data">
                                        <input type="hidden" name = "packageId" value = "<?php echo $gig[0]['package_id']; ?>">
                                    </form>

                                    <a href="#"><button id="package_1" name="packageOrder" onclick="openModal(this)">Request to Order</button></a>
                                </ul>
                            </div>
                        </div>
                    
                        <!-- package 2 -->
                        <div id="Paris" class="tabcontent">
                            <div class="columns">
                                <ul class="price">
                                    <div class="row" style="display: flex; justify-content:space-between;padding: 8px"> 
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                            </svg>
                                            <span>USD <?php echo $gig[1]['package_price']; ?></span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                                <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                            </svg>
                                            <span><?php echo $gig[1]['no_of_delivery_days']; ?> <?php echo $gig[2]['time_period']; ?> Delivery</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16">
                                                <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
                                            </svg>
                                            <?php echo $gig[1]['no_of_revisions']; ?> Revisions
                                        </li>
                                    </div>
                                    <li><?php echo $gig[1]['package_description']; ?></li>

                                    <form id="package_2" method="post" action="manageOrders/createPackageOrder" enctype="multipart/form-data">
                                        <input type="hidden" name = "packageId" value = "<?php echo $gig[1]['package_id']; ?>">
                                    </form>     

                                    <a href="#"><button id="package_2" name="packageOrder" onclick="openModal(this)">Request to Order</button></a>                            
                                 </ul>
                            </div>
                        </div>
                    
                        <!-- package 3 -->
                        <div id="Tokyo" class="tabcontent">
                            <div class="columns">
                                <ul class="price">
                                    <div class="row" style="display: flex; justify-content:space-between;padding: 8px"> 
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                            </svg>
                                            <span>USD <?php echo $gig[2]['package_price']; ?></span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                                <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                            </svg>
                                            <span><?php echo $gig[2]['no_of_delivery_days']; ?> <?php echo $gig[2]['time_period']; ?> Delivery</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16">
                                                <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
                                                </svg>
                                            <?php echo $gig[2]['no_of_revisions']; ?> Revisions
                                        </li>
                                    </div>
                                    <li><?php echo $gig[2]['package_description']; ?></li>

                                    <form id="package_3" method="post" action="manageOrders/createPackageOrder" enctype="multipart/form-data">
                                        <input type="hidden" name = "packageId" value = "<?php echo $gig[2]['package_id']; ?>">
                                    </form>   

                                    <a href="#"><button id="package_3" name="packageOrder" onclick="openModal(this)">Request to Order</button></a>
                                </ul>
                            </div>
                        </div>
                    </div>                    
                </div>

                <!-- Milestones-->
                <div class="milestoneApproach">
                    <div class="type-1">
                        Unlock success step by step with our 'Milestones' feature, offering you the flexibility to create tailored offers while ensuring transparency at every stage of your journey.
                    </div>
                    <button name = "milestoneOrder" onclick="openModal(this)">
                        <div class="flag">
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                            <dotlottie-player src="https://lottie.host/81cc4e66-ff04-446f-9d05-54324102c08a/KAnzyVEJyf.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></dotlottie-player>
                        </div>
                        <div class="milestoneContent">
                            <div class="type-1">MileStones</div>
                            <div class="type-2">
                                Get your work done in gradual steps and pay for each milestone.
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Bottom Container -->
        <div class="bottomContainer">

            <!-- Bottom Left Container -->
            <div class="bottomLeftContainer">
                <div class="aboutGig">
                    <div class="header">
                        <h5>About this Gig</h5>
                    </div>
                    <div class="content">
                        <p>
                            <?php echo $gig["description"]; ?>
                        </p>
                    </div>
                </div>
                <div class="gigRatings">
                    <div class="header">
                        <h5>Feedbacks and Ratings</h5>
                    </div>
                    <div class="content">
                        <?php if (count($feedbacks) == 0) { ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>No feedbacks available</span>
                        <?php } else { ?> 
                            <div class="feedbackCard">
                                <h4>feedbacks</h4>
                            </div>    
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Bottom Right Container -->
            <div class="bottomRightContainer">
                <div class="animation"></div>
            </div>
        </div>

    </div>
</div>

<script src="/skillsparq/public/assests/js/displayGig.script.js"></script>

<?php include "../app/views/components/footer.component.php"?>
