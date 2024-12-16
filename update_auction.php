<?php
// Start the session
session_start();

// Include your database configuration file
include('db_config.php');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON payload from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate that the necessary fields are provided
    if (isset($data['auctionID'], $data['auctionTitle'], $data['auctionDescription'], $data['startingBid'], $data['auctionDate'])) {
        
        // Sanitize and assign the data to variables
        $auctionID = (int)$data['auctionID']; // Auction ID should be an integer
        $auctionTitle = htmlspecialchars($data['auctionTitle']);
        $auctionDescription = htmlspecialchars($data['auctionDescription']);
        $startingBid = (float)$data['startingBid']; // Starting bid should be a float
        $auctionDate = htmlspecialchars($data['auctionDate']); // Ensure the date is in correct format

        try {
            // Create a PDO instance and connect to the database
            $pdo = new PDO($db_host, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL query to update the auction in the database
            $sql = "UPDATE auctions SET title = :title, description = :description, starting_bid = :startingBid, end_date = :endDate WHERE auction_id = :auctionID";

            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':title', $auctionTitle, PDO::PARAM_STR);
            $stmt->bindParam(':description', $auctionDescription, PDO::PARAM_STR);
            $stmt->bindParam(':startingBid', $startingBid, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $auctionDate, PDO::PARAM_STR);
            $stmt->bindParam(':auctionID', $auctionID, PDO::PARAM_INT);

            // Execute the statement
            if ($stmt->execute()) {
                // Send a success response
                echo json_encode(['success' => true, 'message' => 'Auction updated successfully']);
            } else {
                // Send an error response if the update fails
                echo json_encode(['success' => false, 'message' => 'Failed to update auction']);
            }

        } catch (PDOException $e) {
            // Handle any errors during the database operation
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        // If the required fields are not provided, send an error response
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    }
} else {
    // If the request method is not POST, send an error response
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

?>
