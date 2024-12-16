<?php
// Start the session to access user data
session_start();

// Check if the user is logged in as a Buyer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Buyer') {
    // Redirect to role selection page if not logged in as a buyer
    header('Location: redirect.html');
    exit();
}

// Database connection setup (example with PDO)
$host = "localhost";  // Database host
$dbname = "auction_system";  // Database name
$username = "root";  // Database username
$password = "";  // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Fetch active auctions for the Buyer to view
$sql = "SELECT a.AuctionID, i.ItemName, a.StartPrice, a.EndTime, MAX(b.BidAmount) AS HighestBid
        FROM Auction a
        LEFT JOIN Item i ON a.ItemID = i.ItemID
        LEFT JOIN Bid b ON a.AuctionID = b.AuctionID
        WHERE a.Status = 'Active'
        GROUP BY a.AuctionID, i.ItemName, a.StartPrice, a.EndTime
        ORDER BY a.EndTime ASC";  // Fetch active auctions

$stmt = $pdo->query($sql);
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to the Buyer Dashboard</h1>
            <p>Here you can browse and place bids on various items in auctions.</p>
        </header>

        <div class="auction-list">
            <h2>Available Auctions</h2>
            <?php if (count($auctions) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Start Price</th>
                            <th>Current Bid</th>
                            <th>End Time</th>
                            <th>Place Bid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($auctions as $auction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($auction['ItemName']); ?></td>
                                <td><?php echo '$' . number_format($auction['StartPrice'], 2); ?></td>
                                <td><?php echo $auction['HighestBid'] ? '$' . number_format($auction['HighestBid'], 2) : 'No bids yet'; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($auction['EndTime'])); ?></td>
                                <td>
                                    <!-- Button to place a bid -->
                                    <form action="place_bid.php" method="POST">
                                        <input type="hidden" name="auction_id" value="<?php echo $auction['AuctionID']; ?>">
                                        <input type="number" name="bid_amount" step="0.01" min="0" placeholder="Place your bid" required>
                                        <button type="submit">Place Bid</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No active auctions available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
