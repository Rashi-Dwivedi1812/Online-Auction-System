<?php
// Start the session
session_start();

// Include your database configuration file
include('db_config.php');

// Check if the auctionID is provided in the request
if (isset($_GET['auctionID'])) {
    $auctionID = (int)$_GET['auctionID']; // Sanitize the auctionID input
    
    try {
        // Create a PDO instance and connect to the database
        $pdo = new PDO($db_host, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query to get the auction details
        $sql = "SELECT * FROM auctions WHERE auction_id = :auctionID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':auctionID', $auctionID, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();

        // Check if the auction exists
        if ($stmt->rowCount() > 0) {
            // Fetch the auction details as an associative array
            $auction = $stmt->fetch(PDO::FETCH_ASSOC);

            // Send the auction details as a JSON response
            echo json_encode([
                'success' => true,
                'auction' => $auction
            ]);
        } else {
            // If no auction is found, return an error message
            echo json_encode([
                'success' => false,
                'message' => 'Auction not found.'
            ]);
        }

    } catch (PDOException $e) {
        // Handle any errors during the database operation
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    // If the auctionID is not provided in the request, return an error message
    echo json_encode([
        'success' => false,
        'message' => 'Auction ID not provided.'
    ]);
}
?>
