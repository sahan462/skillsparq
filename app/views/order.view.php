<?php
if ($_SESSION['role'] == 'Buyer') {
    include "components/buyerSimpleHeader.component.php";
} else if ($_SESSION['role'] == 'Seller') {
    include "components/sellerHeader.component.php";
}
?>


<?php 

    $order = $data['order'];
    $buyer = $data['buyer'];
    $seller = $data['seller'];
    $chat = $data['chat'];
    $userRole = $_SESSION['role'];
    $state = '';
    $senderId = '';
    $receiverId = '';
    $chatId = $order['chat_id'];
    $order_json = json_encode($order);
    $seller_json = json_encode($seller);
    $buyer_json = json_encode($buyer);
    $orderHistory = $data['orderHistory'];

    if(isset($data['currentMilestone'])){
        $currentMilestone = $data['currentMilestone'];
    }

    if(isset($data['allMilestones'])){
        $allMilestones = $data['allMilestones'];
    }
    // print_r($order);
    // print_r($initialInfo);
    function calculateDeadline($createdDate, $number, $unit) {
        // Get the current date
        $createdDate = new DateTime($createdDate);
    
        // Initialize the deadline
        $deadline = clone $createdDate;
    
        // Add the appropriate time interval based on the unit
        switch ($unit) {
            case 'Days':
                $deadline->modify("+$number days");
                break;
            case 'Weeks':
                $deadline->modify("+$number weeks");
                break;
            case 'Months':
                $deadline->modify("+$number months");
                break;
            case 'Years':
                $deadline->modify("+$number years");
                break;
            default:
                // Handle invalid unit (optional)
                break;
        }
    
        return $deadline->format('Y-m-d');
    }

$order = $data['order'];
$buyer = $data['buyer'];
$seller = $data['seller'];
$chat = $data['chat'];
$userRole = $_SESSION['role'];
$state = '';
$senderId = '';
$receiverId = '';
$chatId = $order['chat_id'];
$order_json = json_encode($order);
$seller_json = json_encode($seller);
$buyer_json = json_encode($buyer);
$orderHistory = $data['orderHistory'];

if (isset($data['currentMilestone'])) {
    $currentMilestone = $data['currentMilestone'];
}

if (isset($data['allMilestones'])) {
    $allMilestones = $data['allMilestones'];
}
// print_r($order);

function calculateDeadline($createdDate, $number, $unit)
{
    // Get the current date
    $createdDate = new DateTime($createdDate);

    // Initialize the deadline
    $deadline = clone $createdDate;

    // Add the appropriate time interval based on the unit
    switch ($unit) {
        case 'Days':
            $deadline->modify("+$number days");
            break;
        case 'Weeks':
            $deadline->modify("+$number weeks");
            break;
        case 'Months':
            $deadline->modify("+$number months");
            break;
        case 'Years':
            $deadline->modify("+$number years");
            break;
        default:
            // Handle invalid unit (optional)
            break;
    }

    return $deadline->format('Y-m-d');
}

if (isset($data['initialInfo'])) {
    $initialInfo = $data['initialInfo'];
}

if ($order['order_type'] != 'milestone') {
    echo "<script>";
    echo "var deadline = new Date('" . $order['deadline'] . "').getTime();";
    echo "</script>";
} else {
    echo "<script>";
    echo "var deadline = new Date('" . calculateDeadline($order['order_created_date'], $currentMilestone['amount_of_delivery_time'], $currentMilestone['time_category']) . "').getTime();";
    echo "</script>";
}
// print_r($order);
// print_r($data['orderHistory']);
?>

<!-- Main Container -->
<div class="orderContainer" id="contentToPrint">

    <!-- Tab Section -->
    <div class="orderContainerHeader">
        <button id="defaultOpen" class="tablinks" onclick="openTab(event, 'activity')">Activity</button>
        <button class="tablinks" onclick="openTab(event, 'details')">Order Details</button>
        <?php if ($order['order_type'] == 'milestone') : ?>
            <button class="tablinks" onclick="openTab(event, 'orderMilestones')">Milestones</button>
        <?php endif; ?>
    </div>

    <!-- Tab Content -->
    <div class="orderContent">

        <!-- Left Container -->
        <div class="userActivity">

            <!-- order chat tab -->
            <div id="activity" style="padding:16px;" class="tabContent">

                <?php if ($_SESSION['userId'] == $buyer['user_id']) {

                    $senderId = $buyer['user_id'];
                    $senderProfilePicture = $buyer['profile_pic'];
                    $senderName = $buyer['first_name'] . ' ' . $buyer['last_name'];
                    $senderLastSeen = $buyer['last_seen'];

                    $receiverId = $seller['user_id'];
                    $receiverProfilePicture = $seller['profile_pic'];
                    $receiverName = $seller['first_name'] . ' ' . $seller['last_name'];
                    $receiverLastSeen = $seller['last_seen'];
                } else {

                    $senderId = $seller['user_id'];
                    $senderProfilePicture = $seller['profile_pic'];
                    $senderName = $seller['first_name'] . ' ' . $seller['last_name'];
                    $senderLastSeen = $seller['last_seen'];

                    $receiverId = $buyer['user_id'];
                    $receiverProfilePicture = $buyer['profile_pic'];
                    $receiverName = $buyer['first_name'] . ' ' . $buyer['last_name'];
                    $receiverLastSeen = $buyer['last_seen'];
                } ?>

                <!-- chat header -->
                <div class="header">

                    <!-- Receiver Details (Name and Online Status) -->
                    <div class="receiver">

                        <div class="upperSection">

                            <?php if ($receiverLastSeen == "online") { ?>
                                <div class="dot receiverActive"></div>
                            <?php } else { ?>
                                <div class="dot receiverOffline"></div>
                            <?php } ?>

                            <h1>
                                <?php if ($_SESSION['userId'] == $buyer['user_id']) : ?>
                                    <a href="sellerProfile&mode=public&userId=<?php echo $seller['user_id'] ?>"><?php echo $receiverName ?></a>
                                <?php elseif ($_SESSION['userId'] == $seller['user_id']) : ?>
                                    <a href="buyerProfile&mode=public&userId=<?php echo $buyer['user_id'] ?>"><?php echo $receiverName ?></a>
                                <?php endif; ?>
                            </h1>

                        </div>

                        <div class="lowerSection">

                            <small>

                                <?php if ($receiverLastSeen == "online") { ?>
                                    <?php echo $receiverLastSeen; ?>
                                <?php } else { ?>
                                    Last Seen:<?php echo $receiverLastSeen; ?>
                                <?php } ?>

                            </small>

                        </div>

                    </div>

                </div>

                <!-- Messages -->
                <div class="innerContainer" id="chatContainer">

                    <?php if (mysqli_num_rows($chat) > 0) : ?>

                        <?php while ($row = $chat->fetch_assoc()) {

                            if ($row['file'] == null && $row['message'] != null) : ?>

                                <?php if (($row['sender_id'] == $_SESSION['userId'] && $_SESSION['role'] != 'csa')  || ($row['sender_id'] == $buyer['user_id'] && $_SESSION['role'] == 'csa')) : ?>

                                    <div class="receiver-container">
                                        <div class="messageContainer darker">
                                            <div class="receiverContent">
                                                <img src="./assests/images/profilePictures/<?php echo $senderProfilePicture ?>" alt="pro pic" class="attachment-image">
                                                <p class="receiver" style="color:black">
                                                    <?php echo $row['message'] ?>
                                                    <span class="time-left" style="color:black;font-size:12px;"><i><?php echo $row['date'] ?></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>

                                    <div class="sender-container">
                                        <div class="messageContainer">
                                            <div class="senderContent">
                                                <img src="./assests/images/profilePictures/<?php echo $receiverProfilePicture ?>" alt="pro pic" class="attachment-image">
                                                <p class="receiver">
                                                    <?php echo $row['message'] ?>
                                                    <span class="time-left" style="color:black;font-size:12px;"><i><?php echo $row['date'] ?></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif;

                            elseif ($row['file'] != null && $row['message'] == null) :

                                if (($row['sender_id'] == $_SESSION['userId'] && $_SESSION['role'] != 'csa')  || ($row['sender_id'] == $buyer['user_id'] && $_SESSION['role'] == 'csa')) : ?>

                                    <div class="receiver-container">
                                        <div class="messageContainer darker">
                                            <div class="receiverContent">
                                                <img src="./assests/images/profilePictures/<?php echo $senderProfilePicture ?>" alt="pro pic" class="attachment-image">
                                                <p>
                                                    <a href="<?php echo $row['file'] ?>" style="display:flex;justify-content:center;align-items:center;" download>
                                                        <img src="./assests/images/download.png ?>">
                                                        Download Attachment
                                                    </a>
                                                    <span class="time-left" style="color:black;font-size:12px;"><i><?php echo $row['date'] ?></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>

                                    <div class="sender-container">
                                        <div class="messageContainer">
                                            <div class="senderContent">
                                                <img src="./assests/images/profilePictures/<?php echo $receiverProfilePicture ?>" alt="pro pic" class="attachment-image">
                                                <p>
                                                    <a href="<?php echo $row['file'] ?>" style="display:flex;justify-content:center;align-items:center;" download>
                                                        <img src="./assests/images/download.png ?>">
                                                        Download Attachment
                                                    </a>
                                                    <span class="time-left" style="color:black;font-size:12px;"><i><?php echo $row['date'] ?></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif;

                            elseif ($row['file'] != null && $row['message'] != null) :

                                if (($row['sender_id'] == $_SESSION['userId'] && $_SESSION['role'] != 'csa')  || ($row['sender_id'] == $buyer['user_id'] && $_SESSION['role'] == 'csa')) : ?>

                                    <div class="receiver-container">
                                        <div class="messageContainer darker">
                                            <div class="receiverContent">
                                                <img src="./assests/images/profilePictures/<?php echo $senderProfilePicture ?>" alt="pro pic" class="attachment-image">
                                                <p>
                                                    <a href="<?php echo $row['file'] ?>" style="display:flex;justify-content:center;align-items:center;" download>
                                                        <img src="./assests/images/download.png ?>">
                                                        Download Attachment
                                                    </a>
                                                    <?php echo $row['message'] ?>
                                                    <span class="time-left" style="color:black;font-size:12px;"><i><?php echo $row['date'] ?></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>

                                    <div class="sender-container">
                                        <div class="messageContainer">
                                            <div class="senderContent">
                                                <img src="./assests/images/profilePictures/<?php echo $receiverProfilePicture ?>" alt="pro pic" class="attachment-image">
                                                <p>
                                                    <a href="<?php echo $row['file'] ?>" style="display:flex;justify-content:center;align-items:center;" download>
                                                        <img src="./assests/images/download.png ?>">
                                                        Download Attachment
                                                    </a>
                                                    <?php echo $row['message'] ?>
                                                    <span class="time-left" style="color:black;font-size:12px;"><i><?php echo $row['date'] ?></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                        <?php endif;


                            endif;
                        } ?>


                    <?php else : ?>

                        <div class="animation" id="chatAnimation" style="width:100%;height:100%;display:flex;flex-direction:column;justify-content:center;align-items:center;">
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                            <dotlottie-player src="https://lottie.host/15564370-4311-48df-9df4-5db8884d55ab/7b2rSEZMBc.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></dotlottie-player>
                            <span class="darkTitle">Say Hello To <?php echo $receiverName ?></span>
                        </div>

                    <?php endif; ?>

                </div>

                <!-- chat footer  -->
                <div class="chatFooter">

                    <form method="post" id="chatForm">

                        <input type="hidden" value="<?php echo $senderId ?>" id="senderId">
                        <input type="hidden" value="<?php echo $receiverId ?>" id="receiverId">
                        <input type="hidden" value="<?php echo $chatId ?>" id="chatId">

                        <div class="attachement">
                            <input type="file" name="messageAttachement" id="messageAttachement">
                            <label for="messageAttachement" style="border:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                            </label>
                        </div>

                        <div class="inputMessage">
                            <input type="text" name="message" id="newMessage" autocomplete="off">
                        </div>

                        <div class="attachement">
                            <label style="border:none;">
                                <button type="submit" name="sendButton" id="sendButton" style="padding: 0; border: none; background: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24" stroke-width="2" stroke="currentColor" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>
                            </label>
                        </div>


                    </form>

                </div>
            </div>


            <!-- Tab 2 -->
            <!-- order details tab -->
            <div id="details" class="tabContent" style="display:none;">

                <div class="container">

                    <div class="section" style="margin-bottom:12px;">
                        <h3 style="margin-bottom:12px;">Order History</h3>
                        <div class="order-history" <?php if ($order['order_type'] != 'packge') echo 'style="max-height: 600px;"'; ?>>
                            <?php foreach ($orderHistory as $row) { ?>
                                <div class="order-history-item">
                                    <p>Action: <?php echo $row['description'] ?></p>
                                    <span>Date: <?php echo $row['date'] ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if ($order['order_type'] == 'package') { ?>
                        <div class="section" style="margin-bottom:12px;">
                            <h3 style="margin-bottom:12px;">Initial Requirement</h3>
                            <p><?php echo $initialInfo['order_description'] ?></p>
                        </div>

                        <div class="section" style="margin-bottom:12px;">
                            <h3 style="margin-bottom:12px;">Attachment</h3>

                            <div id="attachment" style="display: flex; flex-direction: row; justify-content: center; align-items: center; cursor: pointer; height: 40px; width: 200px; border: 1px solid #000000; border-radius: 4px;">
                                <a href="/assests/zipFiles/orderFiles/<?php echo 'Order_' . $order['order_id']; ?>/<?php echo $initialInfo['order_attachement']?>" style="text-decoration: none; color: inherit;" download>Download Attachment</a>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <!-- milestones tab -->
            <?php if ($order['order_type'] == 'milestone') : ?>
                <div id="orderMilestones" class="tabContent" style="display:none;">
                    <div class="milestones">
                        <?php foreach ($allMilestones as $row) {
                            include "components/milestoneCard.component.php";
                        } ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Right Container -->
        <div class="orderDetails">

            <!-- Right Container Upper Part -->
            <div class="orderDetailsUpperContainer">

                <!-- Timer -->
                <div class="deadline">
                    <span>Time Left to Deliver :</span>
                    <div class="timer">
                        <p id="demo"></p>
                    </div>
                </div>


                <!-- State transition -->
                <div class="orderState">

                    <?php if ($order['order_type'] != 'milestone') : ?>
                        <!-- Current state -->
                        <div class="orderStateHeader">
                            <span>Current Status of Order :</span>
                            <span><?php echo $order['order_state'] ?></span>
                        </div>
                    <?php else : ?>
                        <!-- Current state -->
                        <div class="orderStateHeader">
                            <span>Current Status of Milestone :</span>
                            <span><?php echo $order['order_state'] ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Requested State -->
                    <?php if ($order['order_state'] == 'Requested') : $state = 'Requested'; ?>

                        <?php if ($_SESSION['role'] == 'Buyer') : ?>

                            <button class="buttonType-2" onclick="confirmStateChange('cancel')">withdraw your Request</button>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <!-- <span>Order Requested expires in :</span> -->
                            <div class="row">
                                <button class="buttonType-1" onclick="confirmStateChange('send')">Accept</button>
                                <button class="buttonType-2" onclick="confirmStateChange('cancel')">Reject</button>
                            </div>

                        <?php endif; ?>

                        <!-- Accepted/ Pending Payments State -->
                    <?php elseif ($order['order_state'] == 'Accepted/Pending Payments') : $state = 'Accepted/Pending Payments'; ?>

                        <?php if ($_SESSION['role'] == 'Buyer') : ?>

                            <!--generate hash value for payhere payment gateway -->
                            <?php

                            $merchant_id = 1224879;
                            $order_id = $order["order_id"];

                            if ($order['order_type'] == 'package') :
                                $amount = $order['package_price'];
                            elseif ($order['order_type'] == 'milestone') :
                                $amount = $currentMilestone['milestone_price'];
                            elseif ($order['order_type'] == 'job') :
                                $amount = intval(str_replace('$', '', $order['amount']));
                            endif;

                            $currency = "USD";
                            $merchant_secret = "MjQ5MjY4ODcxMDE4NjI5NDMyNzQxNjkwNDQ3NjI3NDIxNjQ4Mjk3NA==";

                            $hash = strtoupper(
                                md5(
                                    $merchant_id .
                                        $order_id .
                                        number_format($amount, 2, '.', '') .
                                        $currency .
                                        strtoupper(md5($merchant_secret))
                                )
                            );

                            ?>

                            <!-- Payment https://sandbox.payhere.lk/pay/authorize -->
                            <form method="post" action="order/verifyPayment" id="paymentForm">
                                <input type="hidden" name="merchant_id" value="1224879">
                                <input type="hidden" name="return_url" value="https://69cd-203-189-188-226.ngrok-free.app/skillsparq/public/manageOrders">
                                <input type="hidden" name="cancel_url" value="https://69cd-203-189-188-226.ngrok-free.app/skillsparq/app/controllers/order/verifyPayment">
                                <input type="hidden" name="notify_url" value="https://69cd-203-189-188-226.ngrok-free.app/skillsparq/app/controllers/order/verifyPayment">
                                <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                                <input type="hidden" name="order_type" value="<?php echo $order['order_type'] ?>">
                                <input type="hidden" name="buyer_id" value="<?php echo $order['buyer_id'] ?>">
                                <input type="hidden" name="seller_id" value="<?php echo $order['seller_id'] ?>">
                                <input type="hidden" name="items" value="<?php echo $order['title'] ?>">
                                <input type="hidden" name="currency" value="USD">
                                <input type="hidden" name="amount" value="<?php echo $amount ?>">
                                <input type="hidden" name="first_name" value="<?php echo $buyer['first_name'] ?>">
                                <input type="hidden" name="last_name" value="<?php echo $buyer['last_name'] ?>">
                                <input type="hidden" name="country" value="<?php echo $buyer['country'] ?>">
                                <input type="hidden" name="email" value="">
                                <input type="hidden" name="phone" value="">
                                <input type="hidden" name="address" value="<?php echo $currentMilestone['milestone_id'] ?>">
                                <input type="hidden" name="city" value="">
                                <input type="hidden" name="hash" value="<?php echo $hash ?>">
                                <input type="hidden" value="Authorize">
                            </form>


                            <div class="row">
                                <button class="buttonType-1" onclick="submitpaymentForm()">Proceed to Pay</button>
                                <button class="buttonType-2" onclick="confirmStateChange('cancel')">Cancel Order</button>
                            </div>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <button class="buttonType-2">Waiting for Payments</button>

                        <?php endif; ?>

                        <!-- Running State  -->
                    <?php elseif ($order['order_state'] == 'Running') : $state = 'Running' ?>

                        <?php if ($_SESSION['role'] == 'Buyer') :

                            if ($order['order_type'] != 'milestone') : ?>

                                <div class="row">
                                    <a href="sharePoint&orderId=<?php echo $order['order_id'] ?>&orderType=<?php echo $order['order_type'] ?>&receiverId=<?php echo $receiverId ?>" class="buttonType-1">View Share Point</a>
                                </div>

                            <?php else : ?>

                                <div class="row">
                                    <a href="sharePoint&orderId=<?php echo $order['order_id'] ?>&orderType=<?php echo $order['order_type'] ?>&receiverId=<?php echo $receiverId ?>&milestoneId=<?php echo $currentMilestone['milestone_id'] ?>" class="buttonType-1">View Share Point</a>
                                </div>

                            <?php endif; ?>

                            <?php elseif ($_SESSION['role'] == 'Seller') :

                            if ($order['order_type'] != 'milestone') : ?>

                                <div class="row">
                                    <a href="sharePoint&orderId=<?php echo $order['order_id'] ?>&orderType=<?php echo $order['order_type'] ?>&receiverId=<?php echo $receiverId ?>" class="buttonType-1">View Share Point</a>
                                </div>

                            <?php else : ?>

                                <div class="row">
                                    <a href="sharePoint&orderId=<?php echo $order['order_id'] ?>&orderType=<?php echo $order['order_type'] ?>&receiverId=<?php echo $receiverId ?>&milestoneId=<?php echo $currentMilestone['milestone_id'] ?>" class="buttonType-1">View Share Point</a>
                                </div>

                            <?php endif; ?>

                        <?php endif; ?>

                        <!-- Completed State -->
                    <?php elseif ($order['order_state'] == 'Completed') : $state = 'Completed' ?>

                        <?php if ($_SESSION['role'] == 'Buyer') :

                            if ($order['order_type'] != 'milestone') : ?>
                                <div class="row">
                                    <a href="sharePoint&orderId=<?php echo $order['order_id'] ?>&orderType=<?php echo $order['order_type'] ?>&receiverId=<?php echo $receiverId ?>&orderState=Completed" class="buttonType-1">View Share Point</a>
                                </div>
                            <?php elseif ($order['order_type'] == 'milestone') : ?>
                                <div class="row">
                                    <a href="#orderMilestones" class="buttonType-1">Go to Milestone Tab</a>
                                </div>
                            <?php endif ?>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <?php if ($order['order_type'] != 'milestone') : ?>
                                <div class="row">
                                    <a href="sharePoint&orderId=<?php echo $order['order_id'] ?>&orderType=<?php echo $order['order_type'] ?>&receiverId=<?php echo $receiverId ?>&orderState=Completed" class="buttonType-1">View Share Point</a>
                                </div>
                            <?php elseif ($order['order_type'] == 'milestone') : ?>
                                <div class="row">
                                    <a href="#orderMilestones" class="buttonType-1">Go to Milestone Tab</a>
                                </div>
                            <?php endif ?>

                        <?php endif; ?>

                        <!-- Completed State -->
                    <?php elseif ($order['order_state'] == 'Cancelled') : $state = 'Cancelled' ?>

                        <?php if ($_SESSION['role'] == 'Buyer') : ?>

                            <div class="row">
                                <button class="buttonType-2">Cancelled</button>
                            </div>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <div class="row">
                                <button class="buttonType-2">Cancelled</button>
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>

                </div>

            </div>

            <!-- Right Container Bottom Part -->
            <div class="orderDetailsBottomContainer">

                <!-- display order details -->
                <div class="orderDetailsBottomLeftContainer">

                    <div class="key">

                        <span class="type-1">Order Id</span>
                        <span class="type-1">Order Type</span>

                        <?php if ($order['order_type'] == 'package') : ?>
                            <span class="type-1">Gig Id</span>
                        <?php elseif ($order['order_type'] == 'job') : ?>
                            <span class="type-1">Job Id</span>
                        <?php elseif ($order['order_type'] == 'milestone') : ?>
                            <span class="type-1">Milestone Id</span>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] == 'Buyer') : ?>

                            <span class="type-1">Seller Id</span>
                            <span class="type-1">Seller Name</span>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <span class="type-1">Buyer Id</span>
                            <span class="type-1">Buyer Name</span>

                        <?php elseif ($_SESSION['role'] == 'csa') : ?>

                            <span class="type-1">Seller Id</span>
                            <span class="type-1">Seller Name</span>
                            <span class="type-1">Buyer Id</span>
                            <span class="type-1">Buyer Name</span>

                        <?php endif; ?>

                        <?php if ($order['order_type'] == 'package') : ?>
                            <span class="type-1">Revision Count Left</span>
                        <?php endif; ?>

                        <span class="type-1">Submission Deadline</span>
                        <span class="type-1">Total Payment</span>

                    </div>

                    <div class="value">

                        <span class="type-1"><?php echo $order['order_id'] ?></span>
                        <span class="type-1"><?php echo $order['order_type'] ?></span>

                        <?php if ($order['order_type'] == 'package') : ?>
                            <span class="type-1"><?php echo $order['gig_id'] ?></span>
                        <?php elseif ($order['order_type'] == 'job') : ?>
                            <span class="type-1"><?php echo $order['job_id'] ?></span>
                        <?php elseif ($order['order_type'] == 'milestone') : ?>
                            <span class="type-1"><?php echo $currentMilestone['milestone_id'] ?></span>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] == 'Buyer') : ?>

                            <span class="type-1"><?php echo $seller['user_id'] ?></span>
                            <span class="type-1"><?php echo ($seller['first_name'] .  " " . $seller['last_name']) ?></span>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <span class="type-1"><?php echo $buyer['user_id'] ?></span>
                            <span class="type-1"><?php echo ($buyer['first_name'] .  " " . $buyer['last_name']) ?></span>

                        <?php elseif ($_SESSION['role'] == 'csa') : ?>

                            <span class="type-1"><?php echo $seller['user_id'] ?></span>
                            <span class="type-1"><?php echo $seller['user_name'] ?></span>
                            <span class="type-1"><?php echo $buyer['user_id'] ?></span>
                            <span class="type-1"><?php echo ($buyer['first_name'] .  " " . $buyer['last_name']) ?></span>

                        <?php endif; ?>

                        <?php if ($order['order_type'] == 'package') : ?>
                            <span class="type-1"><?php echo $order['no_of_revisions'] ?></span>
                        <?php endif; ?>

                        <?php if ($order['order_type'] == 'package') : ?>
                            <span class="type-1"><?php echo calculateDeadline($order['order_created_date'], $order['no_of_delivery_days'], $order['time_period']) ?></span>

                        <?php elseif ($order['order_type'] == 'job'): ?>
                            <span class="type-1"><?php echo $order['deadline']?></span>
                        <?php elseif ($order['order_type'] == 'milestone'): ?>
                            <span class="type-1"><?php echo calculateDeadline($order['order_created_date'], $currentMilestone['amount_of_delivery_time'], $currentMilestone['time_category']) ?></span>
                        <?php endif; ?>

                        <?php if ($order['order_type'] == 'package') : ?>
                            <span class="type-1"><?php echo $order['package_price'] ?>USD</span>
                        <?php elseif ($order['order_type'] == 'job') : ?>
                            <span class="type-1"><?php echo $order['amount'] ?></span>
                        <?php elseif ($order['order_type'] == 'milestone') : ?>
                            <span class="type-1"><?php echo $currentMilestone['milestone_price'] ?></span>
                        <?php endif; ?>

                    </div>


                </div>

                <!-- additional features -->
                <div class="orderDetailsBottomRightContainer">

                    <?php if (($order['order_state'] == 'Requested') || ($order['order_state'] == 'Accepted/Pending Payments')) : ?>

                        <!-- <img src="https://npm-assets.fiverrcdn.com/assets/@fiverr-private/earnings/high-five-illustration.28505d2.png" style="height: 280px; width: fit-content;"> -->
                        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                        <dotlottie-player src="https://lottie.host/9c425322-671b-4889-ad69-9440add4a776/eSAhTKf6SZ.json" background="transparent" speed="1" style="margin-left:60px;width: 300px; height: 300px;" loop autoplay></dotlottie-player>


                    <?php elseif (($order['order_state'] == 'Running')) : ?>

                        <!-- <button class="buttonType-3" style="margin-bottom:8px;width:75%;">Request Revision</button> -->
                        <button class="buttonType-3" style="margin-bottom:8px;width:75%;" onclick="openComplaintModal(this)">Raise a Complaint</button>
                        <button class="buttonType-3" style="margin-bottom:8px;width:75%;" onclick="createPDF(<?php echo htmlspecialchars(json_encode($order_json)); ?>, <?php echo htmlspecialchars(json_encode($seller_json)); ?>, <?php echo htmlspecialchars(json_encode($buyer_json)); ?>)">Download Invoice</button>

                        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                        <dotlottie-player src="https://lottie.host/6eb8f278-00ec-4955-a597-3401b5e01df9/LuQeqHZb2l.json" background="transparent" speed="1" style="width: 250px; height: 230px;" loop autoplay></dotlottie-player>

                        <?php elseif (($order['order_state'] == 'Completed')) :

                        if ($_SESSION['role'] == 'Buyer') : ?>

                            <?php if ($order['ongoing_complaint_count'] == 0) { ?>
                                <a href=""><button class="buttonType-3" style="margin-bottom:8px;width:75%;" onclick="openDeleteOrderModal(this)">Delete Order</button></a>
                            <?php } ?>
                            <button class="buttonType-3" style="margin-bottom:8px;width:75%;" onclick="createPDF(<?php echo htmlspecialchars(json_encode($order_json)); ?>, <?php echo htmlspecialchars(json_encode($seller_json)); ?>, <?php echo htmlspecialchars(json_encode($buyer_json)); ?>)">Download Invoice</button>

                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                            <dotlottie-player src="https://lottie.host/351b9c50-9b5b-40f3-b3a9-b7b18515bbdd/kDdcbxih46.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></dotlottie-player>

                        <?php elseif ($_SESSION['role'] == 'Seller') : ?>

                            <button class="buttonType-3" style="margin-bottom:8px;width:75%;" onclick="createPDF('<?php echo $order_json ?>', '<?php echo $seller_json ?>', '<?php echo $buyer_json ?>')">Download Invoice</button>

                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                            <dotlottie-player src="https://lottie.host/351b9c50-9b5b-40f3-b3a9-b7b18515bbdd/kDdcbxih46.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></dotlottie-player>

                        <?php endif; ?>


                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

    <!-- <img src="https://npm-assets.fiverrcdn.com/assets/@fiverr-private/earnings/high-five-illustration.28505d2.png" style="height: 280px; width: fit-content;"> -->

    <!-- Modal 1 -->
    <div class="overlay" id="cancelConfirmationOverlay">
        <div class="confirmation" id="cancelConfirmation">

            <?php if ($_SESSION['role'] == 'Buyer') { ?>

                <?php if ($state == 'Requested') { ?>

                    <p>Are you sure want to withdraw your request?</p>
                    <div class="buttons">
                        <button onclick="handleStateChange('withdraw request', 'yes', <?php echo $order['order_id'] ?>, '<?php echo $order['order_type'] ?>', '<?php echo $order['buyer_id'] ?>', '<?php echo $order['seller_id'] ?>', '<?php echo $state ?>')">Yes</button>
                        <button onclick="handleStateChange('withdraw request', 'no', '', '', '', '')">No</button>
                    </div>

                <?php } else if ($state == 'Accepted/Pending Payments') { ?>

                    <p>Are you sure want to cancel your order?</p>
                    <div class="buttons">
                        <button onclick="handleStateChange('cancel order', 'yes', <?php echo $order['order_id'] ?>, '<?php echo $order['order_type'] ?>', '<?php echo $order['buyer_id'] ?>', '<?php echo $order['seller_id'] ?>', '<?php echo $state ?>')">Yes</button>
                        <button onclick="handleStateChange('cancel order', 'no', '', '', '', '')">No</button>
                    </div>

                <?php } ?>

            <?php } else if ($_SESSION['role'] == 'Seller') { ?>

                <?php if ($state == 'Requested') { ?>

                    <p>Are you sure want to reject this request?</p>
                    <div class="buttons">
                        <button onclick="handleStateChange('reject request', 'yes', <?php echo $order['order_id'] ?>, '<?php echo $order['order_type'] ?>', '<?php echo $order['buyer_id'] ?>', '<?php echo $order['seller_id'] ?>', '<?php echo $state ?>')">Yes</button>
                        <button onclick="handleStateChange('reject request', 'no', '', '', '')">No</button>
                    </div>

                <?php } ?>

            <?php } ?>

        </div>
    </div>

    <!-- Modal 2 -->
    <div class="overlay" id="sendConfirmationOverlay">
        <div class="confirmation" id="sendConfirmation">

            <?php if ($_SESSION['role'] == 'Buyer') { ?>

            <?php } else if ($_SESSION['role'] == 'Seller') { ?>

                <?php if ($state == 'Requested') { ?>

                    <p>Are you sure want to continue with this order?</p>
                    <div class="buttons">
                        <button onclick="handleStateChange('accept request', 'no', '', '', '')">No</button>
                        <?php if ($order['order_type'] != 'milestone') : ?>
                            <button onclick="handleStateChange('accept request', 'yes', <?php echo $order['order_id'] ?>, '<?php echo $order['order_type'] ?>', '<?php echo $order['buyer_id'] ?>', '<?php echo $order['seller_id'] ?>', '<?php echo $state ?>')">Yes</button>
                        <?php elseif ($order['order_type'] == 'milestone') : ?>
                            <button onclick="handleStateChange('accept request', 'yes', <?php echo $order['order_id'] ?>, '<?php echo $order['order_type'] ?>', '<?php echo $order['buyer_id'] ?>', '<?php echo $order['seller_id'] ?>', '<?php echo $state ?>', '<?php echo $currentMilestone['milestone_id'] ?>')">Yes</button>
                        <?php endif; ?>
                    </div>

                <?php } ?>

            <?php } ?>

        </div>
    </div>

    <!-- Modal 3 / Modal for Send Complaints -->
    <div class="overlay" id="overlay">
        <div class="modal" id="packageModal">
            <form id="sendRequestForm" method="post" action="helpCenter/createInquiry" enctype="multipart/form-data">

                <div class="row">
                    <label for="inquirySubject" class="type-1">Complaint Subject:</label>
                    <label for="inquirySubject" class="type-2">Please provide a suitable overview for your complaint.</label>
                    <input type="text" id="inquirySubject" name="inquirySubject" required></textarea>
                    <div class="warningMessage" style="color: red;margin-bottom: 16px !important;"></div>
                </div>

                <div class="row">
                    <label for="inquiryDescription" class="type-1">Complaint Description:</label>
                    <label for="inquiryDescription" class="type-2">Please provide a concise description of the task you would like to accomplish.</label>
                    <textarea id="inquiryDescription" name="inquiryDescription" rows="10" required></textarea>
                    <div class="warningMessage" style="color: red;margin-bottom: 16px !important;"></div>
                </div>

                <div class="row">
                    <label for="attachments" class="type-1">Attachments:</label>
                    <label for="attachments" class="type-2">Kindly upload any attachments as a compressed ZIP file, if applicable.</label>
                    <div class="innerRow" style="display: flex; flex-direction: row; align-items: center;">
                        <label for="inquiryAttachment" id="attachment" style="margin-right: 4px;">Attachements</label>
                        <div id="warningMessage" class="warningMessage" style="color: red; display: none;">Invalid file type. Only ZIP files are allowed.</div>
                        <span id="fileName"></span>
                    </div>
                    <input type="file" class="fileInput" id="inquiryAttachment" name="inquiryAttachment" multiple onchange="displayFileName(this)">
                </div>

                <div class="buttons">
                    <button type="button" onclick="confirmAction('cancel')">Cancel Request</button>
                    <button type="button" onclick="confirmAction('send')">Send Request</button>
                </div>

                <input type="hidden" name="userId" value="<?php echo $_SESSION['userId'] ?>">
                <input type="hidden" name="userName" value="<?php echo $_SESSION['userName'] ?>">
                <input type="hidden" name="role" value="<?php echo $_SESSION['role'] ?>">
                <input type="hidden" name="orderId" value="<?php echo $order['order_id'] ?>">
                <input type="hidden" name="inquiryType" value="complaint">
                <input type="hidden" name="inquirySubmit" value="submit">

            </form>
        </div>
    </div>

    <!-- Modal 4 -->
    <div class="overlay" id="cancelComplaintOverlay">
        <div class="confirmation" id="cancelComplaint">
            <p>Are you sure want to cancel?</p>
            <div class="buttons">
                <button onclick="handleConfirmation('cancelNo')">No</button>
                <button onclick="handleConfirmation('cancelYes')">Yes</button>
            </div>
        </div>
    </div>

    <!-- Modal 5 -->
    <div class="overlay" id="sendComplaintOverlay">
        <div class="confirmation" id="sendComplaint">
            <p>Are you sure want to continue?</p>
            <div class="buttons">
                <button onclick="handleConfirmation('sendNo')">No</button>
                <button onclick="handleConfirmation('sendYes')">Yes</button>
            </div>
        </div>
    </div>

</div>


<script>
    const senderProfilePicture = "<?php echo $senderProfilePicture; ?>";
    const receiverProfilePicture = "<?php echo $receiverProfilePicture; ?>";
    const senderId = "<?php echo $senderId; ?>";
    const receiverId = "<?php echo $receiverId; ?>";
    const orderType = "<?php echo $order['order_type']; ?>";
    const orderId = "<?php echo $order['order_id']; ?>";
    <?php if ($order['order_type'] == 'milestone') : ?>
        const milestoneId = <?php echo $currentMilestone['milestone_id']; ?>
    <?php endif; ?>
    document.addEventListener('DOMContentLoaded', function() {
        // Your JavaScript code here
        <?php if ($order['order_state'] == 'Cancelled' || $order['order_state'] == 'Completed') : ?>
            document.getElementById("demo").innerHTML = "EXPIRED";
        <?php endif; ?>
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="./assests/js/chat.script.js"></script>
<script src="./assests/js/order.script.js"></script>
<script src="./assests/js/invoice.script.js"></script>

<?php include "components/footer.component.php"; ?>