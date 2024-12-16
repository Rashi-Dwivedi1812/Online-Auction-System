<?php
// Mock PHP Backend for handling seller actions. This would need to connect to a real database.

session_start();

// Example: Mock database data
$auctions = [
    ["item" => "Vintage Watch", "currentBid" => 100, "status" => "Active", "timeLeft" => "1h 25m", "auctionID" => 1],
    ["item" => "Fine Art Painting", "currentBid" => 350, "status" => "Active", "timeLeft" => "2h 5m", "auctionID" => 2],
    ["item" => "Classic Guitar", "currentBid" => 0, "status" => "Upcoming", "timeLeft" => "N/A", "auctionID" => 3],
    ["item" => "Luxury Watch", "currentBid" => 500, "status" => "Completed", "timeLeft" => "N/A", "auctionID" => 4],
];

// Seller's Transactions Example
$transactions = [
    ["transactionID" => 1, "auctionID" => 1, "buyer" => "JohnDoe", "finalPrice" => 100, "status" => "Paid"],
    ["transactionID" => 2, "auctionID" => 4, "buyer" => "JaneSmith", "finalPrice" => 500, "status" => "Paid"],
];

// Return data for seller dashboard (in real scenarios, data would come from the database)
echo json_encode([
    "auctions" => $auctions,
    "transactions" => $transactions
]);
?>
