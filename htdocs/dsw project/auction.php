<?php
require 'connection.php';  // Assuming db.php is your database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to participate in the auction.";
    exit;
}

// Get auction ID from the URL (e.g., auction.php?id=1)
$auction_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($auction_id <= 0) {
    echo "Invalid auction ID.";
    exit;
}

// Fetch auction details from the database
$sql = "SELECT Auctions.AuctionID, Auctions.StartTime, Auctions.EndTime, Auctions.HighestBid, 
               Items.ItemName, Items.Description, Auctions.Status, Items.SellerID
        FROM Auctions
        INNER JOIN Items ON Auctions.ItemID = Items.ItemID
        WHERE Auctions.AuctionID = ? AND Auctions.Status = 'Ongoing'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $auction_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "This auction is not found or has ended.";
    exit;
}

$auction = $result->fetch_assoc();
$highest_bid = $auction['HighestBid'] ? $auction['HighestBid'] : $auction['StartPrice'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Auction Details</h1>
        </header>

        <div class="auction-details">
            <h2><?php echo htmlspecialchars($auction['ItemName']); ?></h2>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($auction['Description'])); ?></p>
            <p><strong>Starting Price:</strong> $<?php echo number_format($auction['StartPrice'], 2); ?></p>
            <p><strong>Current Highest Bid:</strong> $<?php echo number_format($highest_bid, 2); ?></p>
            <p><strong>Seller:</strong> User #<?php echo $auction['SellerID']; ?></p>
            <p><strong>Auction Status:</strong> <?php echo $auction['Status']; ?></p>
            <p><strong>Auction Start Time:</strong> <?php echo $auction['StartTime']; ?></p>
            <p><strong>Auction End Time:</strong> <?php echo $auction['EndTime']; ?></p>
        </div>

        <div class="bid-form">
            <h3>Place a Bid</h3>

            <?php
            // Check if the auction has ended
            $current_time = date("Y-m-d H:i:s");
            if ($auction['EndTime'] <= $current_time) {
                echo "<p>This auction has ended. You can no longer place a bid.</p>";
            } else {
                // Check if the user has already placed a bid and update the bid form
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $bid_amount = $_POST['bid_amount'];

                    // Ensure the bid is higher than the current highest bid
                    if ($bid_amount <= $highest_bid) {
                        echo "<p>Your bid must be higher than the current highest bid of $" . number_format($highest_bid, 2) . ".</p>";
                    } else {
                        // Insert the bid into the Bids table
                        $user_id = $_SESSION['user_id']; // Logged in user
                        $sql = "INSERT INTO Bids (AuctionID, BidderID, BidAmount) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iii", $auction_id, $user_id, $bid_amount);
                        if ($stmt->execute()) {
                            // Update the highest bid in the Auctions table
                            $sql = "UPDATE Auctions SET HighestBid = ? WHERE AuctionID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("di", $bid_amount, $auction_id);
                            $stmt->execute();

                            echo "<p>Your bid of $" . number_format($bid_amount, 2) . " has been placed successfully!</p>";
                        } else {
                            echo "<p>Error placing bid. Please try again later.</p>";
                        }
                    }
                }
            }
            ?>

            <!-- Display the bid form only if auction is ongoing -->
            <?php if ($auction['EndTime'] > $current_time): ?>
                <form method="POST" action="">
                    <label for="bid_amount">Bid Amount:</label>
                    <input type="number" name="bid_amount" min="<?php echo $highest_bid + 0.01; ?>" step="0.01" required>
                    <button type="submit">Place Bid</button>
                </form>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
