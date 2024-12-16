<?php
require 'connection.php';
session_start();

// Ensure the user is logged in and the auction is open
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place a bid.";
    exit;
}

$auction_id = $_POST['auction_id'];
$bid_amount = $_POST['bid_amount'];

// Fetch the auction details to ensure the bid is higher than the current highest bid
$sql = "SELECT * FROM Auctions WHERE AuctionID = ? AND Status = 'Ongoing'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $auction_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Auction is not ongoing or does not exist.";
    exit;
}

$auction = $result->fetch_assoc();
$highest_bid = $auction['HighestBid'];

// Check if the bid is higher than the current highest bid
if ($bid_amount <= $highest_bid) {
    echo "Your bid must be higher than the current highest bid.";
    exit;
}

// Place the bid
$sql = "INSERT INTO Bids (AuctionID, BidderID, BidAmount) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $auction_id, $_SESSION['user_id'], $bid_amount);
$stmt->execute();

// Update the highest bid in the Auctions table
$update_sql = "UPDATE Auctions SET HighestBid = ? WHERE AuctionID = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("di", $bid_amount, $auction_id);
$update_stmt->execute();

echo "Bid placed successfully!";
?>
