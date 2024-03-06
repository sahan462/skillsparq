<?php

class GigHandler extends database
{

    //create new gigs
    public function addNewGig($title, $description, $category, $coverImage, $packagePrice_1, $noOfDeliveryDays_1, $timePeriod_1, $noOfRevisions_1, $packageDescription_1, $packagePrice_2, $noOfDeliveryDays_2, $timePeriod_2, $noOfRevisions_2, $packageDescription_2, $packagePrice_3, $noOfDeliveryDays_3, $timePeriod_3, $noOfRevisions_3, $packageDescription_3, $currentDateTime,$sliderImage1,$sliderImage2,$sliderImage3,$sliderImage4,$sellerId)
    {
        $query = "INSERT INTO gigs (title,description,category,cover_image,created_at,seller_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($GLOBALS['db'],$query);

        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $title, $description, $category, $coverImage, $currentDateTime, $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            $gigId = mysqli_insert_id($GLOBALS['db']);
            mysqli_stmt_close($stmt);

            if ($gigId) {
                $packages = $this->addNewPackages($packagePrice_1, $noOfDeliveryDays_1, $timePeriod_1, $noOfRevisions_1, $packageDescription_1, $packagePrice_2, $noOfDeliveryDays_2, $timePeriod_2, $noOfRevisions_2, $packageDescription_2, $packagePrice_3, $noOfDeliveryDays_3, $timePeriod_3, $noOfRevisions_3, $packageDescription_3,$gigId);

                $images = $this->insertSliderImages($sliderImage1,$sliderImage2,$sliderImage3,$sliderImage4,$gigId);
            }

            return [$gigId, $packages,$images];

        } else {
            throw new Exception("Error inserting data: " . mysqli_error($GLOBALS['db']));
        }
    }

    //create new packages
    public function addNewPackages($packagePrice_1, $noOfDeliveryDays_1, $timePeriod_1, $noOfRevisions_1, $packageDescription_1, $packagePrice_2, $noOfDeliveryDays_2, $timePeriod_2, $noOfRevisions_2, $packageDescription_2, $packagePrice_3, $noOfDeliveryDays_3, $timePeriod_3, $noOfRevisions_3, $packageDescription_3,$gigId)
    {

        $param1_values = ['Basic', 'Standard', 'Premium'];
        $param2_values = [$packagePrice_1,$packagePrice_2, $packagePrice_3];
        $param3_values = [$noOfDeliveryDays_1, $noOfDeliveryDays_2, $noOfDeliveryDays_3];
        $param4_values = [$timePeriod_1, $timePeriod_2, $timePeriod_3];
        $param5_values = [$noOfRevisions_1, $noOfRevisions_2, $noOfRevisions_3];
        $param6_values = [$packageDescription_1, $packageDescription_2, $packageDescription_3];
    
        $currentDateTime = date("Y-m-d H:i:s");  
    
        $query = "INSERT INTO packages (package_type,package_price,no_of_delivery_days,time_period,no_of_revisions,package_description,created_at,gig_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

         $stmt = mysqli_prepare($GLOBALS['db'],$query);
    
        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        
        mysqli_stmt_bind_param($stmt, "sdisissi", $packageType, $packagePrice, $noOfDeliveryDays, $timePeriod, $noOfRevisions, $packageDescription, $currentDateTime, $gigId);
    
        $insertedIds = []; 
    
        for ($i = 0; $i < count($param3_values); $i++) {
            
            $packageType = $param1_values[$i];
            $packagePrice = $param2_values[$i];
            $noOfDeliveryDays = $param3_values[$i];
            $timePeriod = $param4_values[$i];
            $noOfRevisions = $param5_values[$i];
            $packageDescription = $param6_values[$i];
    
            if (mysqli_stmt_execute($stmt)) {
                $insertedIds[] = mysqli_insert_id($GLOBALS['db']);
            } else {
                throw new Exception("Error inserting data: " . mysqli_error($GLOBALS['db']));
            }
        }
    
        mysqli_stmt_close($stmt);
    
        return $insertedIds; 
    } 

    public function insertSliderImages($sliderImage1,$sliderImage2,$sliderImage3,$sliderImage4,$gigId)
    {
        $query = "INSERT INTO slide_images (side_image_1,side_image_2,side_image_3,side_image_4,gig_id) VALUES (?, ?, ?, ?, ?)";

         $stmt = mysqli_prepare($GLOBALS['db'],$query);
    
        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        
        mysqli_stmt_bind_param($stmt, "ssssi", $sliderImage1,$sliderImage2,$sliderImage3,$sliderImage4,$gigId);

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
            return $stmt->get_result();
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

            return $gigDetails + $packageDetails;
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
            $result = $stmt->get_result();
    
            $rows = array();
    
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
    
            $result->free();
            $stmt->close();
    
            return $rows;
        } else {
            die('MySQL Error: ' . mysqli_error($GLOBALS['db']));
        }
    }
    
    
    //update gigs. Should call at the last in controller.
    public function updateGig($gigId,$title, $description, $category, $coverImage)
    {
        $query = "UPDATE Gigs SET title = ?, description = ?, category = ?, 
        cover_image = ? WHERE gig_id = ?";
        $stmt = mysqli_prepare($GLOBALS['db'],$query);
        
        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "issss",$gigId,$title, $description, $category, $coverImage);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true; 
        } else {
            throw new Exception("Error occurs when updating the data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // update packages
    public function updatePackages($packageId,$packagePrice,$numDeliveryDays,$timeFrame,$numOfRevs,$pckgDescription)
    {
        $query = "UPDATE packages SET package_price = ?, no_of_delivery_days = ?, time_period = ?,no_of_revisions = ?,package_description = ? WHERE package_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'],$query);
        
        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "idisss",$packageId,$packagePrice,$numDeliveryDays, $timeFrame, $numOfRevs,$pckgDescription);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true; 
        } else {
            throw new Exception("Error occurs when updating the data: " . mysqli_error($GLOBALS['db']));
        }
    }

    // update 4 slider Images.
    public function updateSliderImages($gigId,$image1,$image2, $image3, $image4)
    {
        $query = "UPDATE slide_images SET side_image_1 = ?, side_image_2 = ?, side_image_3 = ?,side_image_4= ? WHERE gig_id = ?";

        $stmt = mysqli_prepare($GLOBALS['db'],$query);
        
        if ($stmt === false) {
            throw new Exception("Failed to create prepared statement.");
        }
        mysqli_stmt_bind_param($stmt, "issss",$gigId,$image1,$image2, $image3, $image4);
        
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
        $query = "DELETE FROM Gigs 
        WHERE gig_id = ?";
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
}

















