<?php
require 'db_config.php';
session_start();

// Check if auction is closed
$auction_id = $_POST['auction_id'];

$sql = "SELECT * FROM Auctions WHERE AuctionID = ? AND Status = 'Closed'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $auction_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Auction is not closed or does not exist.";
    exit;
}

$auction = $result->fetch_assoc();
$final_price = $auction['HighestBid'];
$buyer_id = $_POST['buyer_id']; // Assuming this is passed from the frontend or obtained from session
$seller_id = $auction['SellerID'];

// Create transaction record
$sql = "INSERT INTO Transactions (BuyerID, SellerID, AuctionID, FinalPrice) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $buyer_id, $seller_id, $auction_id, $final_price);
$stmt->execute();

echo "Transaction completed successfully!";
?>
