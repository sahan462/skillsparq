<?php

class GigHandler extends database
{

    //create new gigs
    public function addNewGig($title, $description, $category, $uniqueCoverImageName, $packagePrice_1, $packageName_1, $noOfRevisions_1, $noOfDeliveryDays_1, $timePeriod_1,  $packageDescription_1, $packagePrice_2, $packageName_2, $noOfRevisions_2, $noOfDeliveryDays_2, $timePeriod_2,  $packageDescription_2, $packagePrice_3, $packageName_3, $noOfRevisions_3,  $noOfDeliveryDays_3, $timePeriod_3, $packageDescription_3, $currentDateTime, $uniquesliderImage1Name, $uniquesliderImage2Name, $uniquesliderImage3Name, $uniquesliderImage4Name, $sellerId)
    {
        $query = "INSERT INTO gigs (title,description,category,cover_image,created_at,seller_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $title, $description, $category, $uniqueCoverImageName, $currentDateTime, $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            $gigId = mysqli_insert_id($GLOBALS['db']);
            mysqli_stmt_close($stmt);

            if ($gigId) {
                $packages = $this->addNewPackages($packagePrice_1,$packageName_1,$noOfRevisions_1,$noOfDeliveryDays_1, $timePeriod_1, $packageDescription_1, $packagePrice_2,$packageName_2,$noOfRevisions_2,$noOfDeliveryDays_2, $timePeriod_2,  $packageDescription_2, $packagePrice_3,$packageName_3, $noOfRevisions_3,$noOfDeliveryDays_3, $timePeriod_3,$packageDescription_3,$gigId);
                $images = $this->insertSliderImages($uniquesliderImage1Name,$uniquesliderImage2Name,$uniquesliderImage3Name,$uniquesliderImage4Name,$gigId);
            }else{
                throw new Exception("Order is not Accessible" . mysqli_error($GLOBALS['db']));
            }

            return [$gigId, $packages, $images];
        } else {
            throw new Exception("Error inserting data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // public function getCategoryGigs
    public function getCategoryGigs($category){

        $query = "SELECT gigs.title,gigs.cover_image,profile.first_name,profile.profile_pic,profile.last_name,gigs.seller_id,profile.user_id,gigs.gig_id,min(packages.package_price) as package_price FROM gigs inner join profile on profile.user_id = gigs.seller_id inner join packages on gigs.gig_id = packages.gig_id where category = ? group by packages.gig_id";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        if($category == 'Programming and Tech'){
            $type = "Programming & Tech";
        }

        mysqli_stmt_bind_param($stmt, "s", $type);
            
        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
        } else {
            throw new Exception("Error inserting data to package 3: " . mysqli_error($GLOBALS['db']));
        }
        
    }

    //create new packages
    public function addNewPackages($packagePrice_1, $packageName_1, $noOfRevisions_1, $noOfDeliveryDays_1, $timePeriod_1, $packageDescription_1, $packagePrice_2, $packageName_2, $noOfRevisions_2, $noOfDeliveryDays_2, $timePeriod_2,  $packageDescription_2, $packagePrice_3, $packageName_3, $noOfRevisions_3, $noOfDeliveryDays_3, $timePeriod_3, $packageDescription_3, $gigId)
    {    
        $currentDateTime = date("Y-m-d H:i:s"); 
        $insertedIds = [];  
    
        $query = "INSERT INTO packages (package_name, package_price, no_of_delivery_days, time_period, no_of_revisions, package_description, created_at, gig_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        /////////////////////////////////////  inserting details of package 1
        $stmt1 = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt1 === false) {
            throw new Exception("Failed to create prepared statement1.");
        }
        
        mysqli_stmt_bind_param($stmt1, "siisisdi", $packageName_1, $packagePrice_1, $noOfDeliveryDays_1, $timePeriod_1, $noOfRevisions_1, $packageDescription_1, $currentDateTime, $gigId);

        if (mysqli_stmt_execute($stmt1)) {
            $insertedIds[] = mysqli_insert_id($GLOBALS['db']);
        } else {
            throw new Exception("Error inserting data to package 1: " . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_close($stmt1);

        /////////////////////////////////////  inserting details of package 2
        if($packagePrice_2 > 0){

            $stmt2 = mysqli_prepare($GLOBALS['db'],$query);
    
            if ($stmt2 === false) {
                throw new Exception("Failed to create prepared statement2.");
            }
            
            mysqli_stmt_bind_param($stmt2, "siisisdi", $packageName_2, $packagePrice_2, $noOfDeliveryDays_2, $timePeriod_2, $noOfRevisions_2, $packageDescription_2, $currentDateTime, $gigId);
    
            if (mysqli_stmt_execute($stmt2)) {
                $insertedIds[] = mysqli_insert_id($GLOBALS['db']);
            } else {
                throw new Exception("Error inserting data to package 2: " . mysqli_error($GLOBALS['db']));
            }
    
            mysqli_stmt_close($stmt2);

        }

        /////////////////////////////////////  inserting details of package 3
        if($packagePrice_3 > 0){

            $stmt3 = mysqli_prepare($GLOBALS['db'],$query);
    
            if ($stmt3 === false) {
                throw new Exception("Failed to create prepared statement3.");
            }
            
            mysqli_stmt_bind_param($stmt3, "siisisdi", $packageName_3, $packagePrice_3, $noOfDeliveryDays_3, $timePeriod_3, $noOfRevisions_3, $packageDescription_3, $currentDateTime, $gigId);
    
            if (mysqli_stmt_execute($stmt3)) {
                $insertedIds[] = mysqli_insert_id($GLOBALS['db']);
            } else {
                throw new Exception("Error inserting data to package 3: " . mysqli_error($GLOBALS['db']));
            }
    
            mysqli_stmt_close($stmt3);

        }
 
        return $insertedIds;
    }

    public function insertSliderImages($sliderImage1, $sliderImage2, $sliderImage3, $sliderImage4, $gigId)
    {
        $query = "INSERT INTO slide_images (side_image_1,side_image_2,side_image_3,side_image_4,gig_id) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "ssssi", $sliderImage1, $sliderImage2, $sliderImage3, $sliderImage4, $gigId);

        if (mysqli_stmt_execute($stmt)) {
            $sliderImagesId = mysqli_insert_id($GLOBALS['db']);
        } else {
            throw new Exception("Error inserting images: " . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_close($stmt);

        return $sliderImagesId;
    }

    public function retrieveCoverImage($gigId)
    {
        $query = "SELECT cover_image FROM gigs WHERE gig_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            $retrieveImgDetails = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $retrieveImgDetails;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    public function retrieveSliderImages($gigId)
    {
        $query = "SELECT * FROM slide_images WHERE gig_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            $retrieveImgDetails = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $retrieveImgDetails;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    //read recently added gigs
    public function getRecentGigs()
    {
        $query = "SELECT * FROM Gigs ORDER BY gig_id DESC";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
            // $result = $stmt->get_result();
            // $data = [];
            // while ($row = $result->fetch_assoc()) {
            //     $data[] = $row;
            // }
            // return $data;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    // read the recent gigs with the seller Details
    public function getRecentGigWithRelevantSellerDets()
    {
        $query = "SELECT * FROM GIGS INNER JOIN PROFILE ON PROFILE.USER_ID = GIGS.SELLER_ID ORDER BY gig_id DESC";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }
        // read the recent gigs with the seller Details
        public function getRecentGigWithRelevantSellerDetsForSearch($textToSearch)
        {
            $query = "SELECT g.title,g.gig_id,g.description,g.category,g.cover_image,g.ongoing_order_count,g.created_at,g.seller_id,p.profile_pic,p.first_name,p.last_name,p.country,p.joined_date,p.last_seen,p.about,u.user_email FROM GIGS g INNER JOIN PROFILE p ON p.USER_ID = g.SELLER_ID INNER JOIN USER u ON u.user_id = p.USER_ID WHERE 
            g.title LIKE CONCAT('%',?,'%') OR 
            g.description LIKE CONCAT('%',?,'%') OR 
            g.category LIKE CONCAT('%',?,'%') OR 
            g.cover_image LIKE CONCAT('%',?,'%') OR 
            g.ongoing_order_count LIKE CONCAT('%',?,'%') OR 
            g.created_at LIKE CONCAT('%',?,'%') OR 
            g.seller_id LIKE CONCAT('%',?,'%') OR 
            g.gig_id LIKE CONCAT('%',?,'%') OR 
            p.profile_pic LIKE CONCAT('%',?,'%') OR 
            p.first_name LIKE CONCAT('%',?,'%') OR
            p.last_name LIKE CONCAT('%',?,'%') OR
            p.country LIKE CONCAT('%',?,'%') OR
            p.joined_date LIKE CONCAT('%',?,'%') OR
            p.last_seen LIKE CONCAT('%',?,'%') OR
            p.last_seen LIKE CONCAT('%',?,'%') OR
            u.user_id LIKE CONCAT('%',?,'%') OR
            p.about LIKE CONCAT('%',?,'%')"
            ;

            $stmt = mysqli_prepare($GLOBALS['db'], $query);

            if (!$stmt) {
                die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
            }

            mysqli_stmt_bind_param($stmt,"sssssssssssssssss", $textToSearch, $textToSearch,$textToSearch, $textToSearch, $textToSearch, $textToSearch,$textToSearch, $textToSearch, $textToSearch, $textToSearch,$textToSearch, $textToSearch, $textToSearch, $textToSearch,$textToSearch,$textToSearch,$textToSearch);

            if (mysqli_stmt_execute($stmt)) {
                return $stmt->get_result();
            } else {
                die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
            }
        }

        // read the recent gigs with the seller Details
        public function getNewBieGigs()
        {
            $query = "SELECT * FROM GIGS INNER JOIN PROFILE ON PROFILE.USER_ID = GIGS.SELLER_ID ORDER BY joined_date DESC";
    
            $stmt = mysqli_prepare($GLOBALS['db'], $query);
    
            if (!$stmt) {
                die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
            }
    
            if (mysqli_stmt_execute($stmt)) {
                return $stmt->get_result();
            } else {
                die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
            }
        }
    

    public function getGigCount($sellerId)
    {
        $retrieveQuery = "SELECT COUNT(*) AS GIGCOUNT FROM GIGS WHERE SELLER_ID = ?;";

        $stmt = mysqli_prepare($GLOBALS['db'],$retrieveQuery);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $sellerId);
        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result()->fetch_assoc();
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    //read gigs based on seller id
    public function getGig($sellerId)
    {
        $query = "SELECT * FROM gigs WHERE seller_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            return $result;

        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    public function getGigAndSeller($sellerId)
    {
        $query = "SELECT * FROM GIGS INNER JOIN PROFILE ON PROFILE.USER_ID = GIGS.SELLER_ID WHERE SELLER_ID = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
            // $result = $stmt->get_result();
            // $data = [];
            // while ($row = $result->fetch_assoc()) {
            //     $data[] = $row;
            // }
            // return $data;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }



    //display a specific gig
    public function displayGig($gigId)
    {
        $query = "SELECT * FROM gigs WHERE gig_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            $gigDetails = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $packageDetails = $this->getPackages($gigId);

            $gig = [
                "gigDetails" => $gigDetails,
                "packageDetails" => $packageDetails
            ];
            return $gig;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    //display a specific gig this is for the updateGig.controller.php file
    public function displayGigForUpdate($gigId)
    {
        $query = "SELECT * FROM gigs WHERE gig_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            $gigDetails = $stmt->get_result();
            $stmt->close();

            $packageDetails = $this->getPackages($gigId);
            // $packageDetails = mysqli_fetch_assoc($packageDetails);

            $gig = [
                "gigDetails" => $gigDetails,
                "packageDetails" => $packageDetails
            ];
            return $gig;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    //get package details
    public function getPackages($gigId)
    {
        $query = "SELECT * FROM packages WHERE gig_id = ?";
        
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    
        mysqli_stmt_bind_param($stmt, "i", $gigId);
    
        if (mysqli_stmt_execute($stmt)) {
            $packages = $stmt->get_result();
            return $packages;
            
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
  
    }

    //get package details
    public function getPackagesForOthers($gigId)
    {
        $query = "SELECT * FROM packages WHERE gig_id = ?";
        
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    
        mysqli_stmt_bind_param($stmt, "i", $gigId);
    
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $packages = [];
            while ($row = $result->fetch_assoc()) {
                $packages[] = $row;
            }
            return $packages;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
  
    }
        
    //get Gig Id based on seller id
    public function getGigId($sellerId)
    {
        $query = "SELECT gig_id FROM gigs WHERE seller_id = ?";
        
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    // update ongoing order count when creating an order (either package order or Milestone Order)
    public function updateOngoingOrderCount($gigId)
    {
        $updateQuery = "UPDATE Gigs SET ongoing_order_count = ongoing_order_count + 1 WHERE gig_id = ?;";

        $stmt = mysqli_prepare($GLOBALS['db'], $updateQuery);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error occurs when updating the data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // get ongoing order count
    public function getOngoingOrderCount($sellerId)
    {
        $query = "SELECT ongoing_order_count FROM gigs WHERE seller_id = ?";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i", $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    //update gigs. Should call at the last in controller.
    public function updateGig($gigId, $title, $description, $category, $coverImage)
    {
        $query = "UPDATE Gigs SET title = ?, description = ?, category = ?, 
        cover_image = ? WHERE gig_id = ?";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "issss", $gigId, $title, $description, $category, $coverImage);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error occurs when updating the data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // update packages
    public function updatePackages($packageId, $packagePrice, $numDeliveryDays, $timeFrame, $numOfRevs, $pckgDescription)
    {
        $query = "UPDATE packages SET package_price = ?, no_of_delivery_days = ?, time_period = ?,no_of_revisions = ?,package_description = ? WHERE package_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "idisss", $packageId, $packagePrice, $numDeliveryDays, $timeFrame, $numOfRevs, $pckgDescription);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error occurs when updating the data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // update 4 slider Images.
    public function updateSliderImages($gigId, $image1, $image2, $image3, $image4)
    {
        $query = "UPDATE slide_images SET side_image_1 = ?, side_image_2 = ?, side_image_3 = ?,side_image_4= ? WHERE gig_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "issss", $gigId, $image1, $image2, $image3, $image4);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error occurs when updating the data: " . mysqli_error($GLOBALS['db']));
        }
    }

    //delete gig
    public function deleteGig($gigId)
    {
        $query = "DELETE FROM Gigs WHERE gig_id = ?";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error when deleting data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // ---------------------------------- Functions for Delete a Gig -----------------------------------


    // Getting the available count of packages.
    public function getAvailablePackageCount($gigId)
    {
        $retrieveQuery = "SELECT COUNT(*) AS count FROM packages  WHERE gig_id=?;";

        $stmt = mysqli_prepare($GLOBALS['db'], $retrieveQuery);
        
        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt, "i",$gigId);

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result()->fetch_assoc();
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    //  deleting packages one by one in a loop in controller (Gig)
    public function deletePackages($gigId)
    {
        $query = "DELETE FROM packages WHERE gig_id = ?;";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error deleting data: " . mysqli_error($GLOBALS['db']));
        }
    }

    public function deleteSliderImages($gigId)
    {
        $query = "DELETE FROM slide_images WHERE gig_id = ?;";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error deleting data: " . mysqli_error($GLOBALS['db']));
            return false;
        }
    }

    // -----------------------------------------------

    public function deletePackageOrders($gigId)
    {
        $query = "DELETE FROM packages WHERE gig_id = ?;";
        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "i", $gigId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            throw new Exception("Error deleting data: " . mysqli_error($GLOBALS['db']));
        }
    }

    

    public function noOfGigs()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        $previousMonthsData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = ($currentMonth - $i) < 1 ? 12 + ($currentMonth - $i) : $currentMonth - $i;
            $year = ($currentMonth - $i) < 1 ? $currentYear - 1 : $currentYear;

            $query = "SELECT COUNT(*) AS gigs FROM gigs WHERE MONTH(created_at) = $month AND YEAR(created_at) = $year ";

            $stmt = mysqli_prepare($GLOBALS['db'], $query);

            if (!$stmt) {
                die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
            }

            if (mysqli_stmt_execute($stmt)) {
                $result = $stmt->get_result();
                $data = $result->fetch_assoc(); // Fetch the first row as an associative array
                $previousMonthsData[] = $data['gigs'];
            } else {
                die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
            }
        }

        return $previousMonthsData;
    }
    public function gigStateCurrentMonth()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $query = "SELECT
                        
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Graphics & Design' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Graphics & Design',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Programming & Tech' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Programming & Tech',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Digital Marketing' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Digital Marketing',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Video & Animation' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Video & Animation',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Writing & Translation' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Writing & Translation',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Music & Audio' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Music & Audio',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Business' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Business',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Data' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Data',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Photography' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'Photography',

                        (SELECT COUNT(*) FROM gigs WHERE category = 'AI Services' AND MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear) AS 'AI Services'";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Fetch the first row as an associative array
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

    public function gigState()
    {


        $query = "SELECT
                        
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Graphics & Design' ) AS 'Graphics & Design',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Programming & Tech') AS 'Programming & Tech',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Digital Marketing' ) AS 'Digital Marketing',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Video & Animation' ) AS 'Video & Animation',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Writing & Translation' ) AS 'Writing & Translation',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Music & Audio' ) AS 'Music & Audio',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Business') AS 'Business',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Data' ) AS 'Data',
                        (SELECT COUNT(*) FROM gigs WHERE category = 'Photography' ) AS 'Photography',

                        (SELECT COUNT(*) FROM gigs WHERE category = 'AI Services' ) AS 'AI Services'";

        $stmt = mysqli_prepare($GLOBALS['db'], $query);

        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Fetch the first row as an associative array
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }


    // get job result for any search string.
    public function getGigsSearch($textToSearch)
    {
        $retrieveQuery = "SELECT * FROM GIGS WHERE TITLE LIKE CONCAT('%',?,'%') OR DESCRIPTION LIKE CONCAT('%',?,'%') OR CATEGORY LIKE CONCAT('%',?,'%') OR CREATED_AT LIKE CONCAT('%',?,'%')";
        
        $stmt = mysqli_prepare($GLOBALS['db'], $retrieveQuery);
        
        if (!$stmt) {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }

        mysqli_stmt_bind_param($stmt,"ssss", $textToSearch, $textToSearch, $textToSearch, $textToSearch);

        if (mysqli_stmt_execute($stmt)) {
            return $stmt->get_result();
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }

}
