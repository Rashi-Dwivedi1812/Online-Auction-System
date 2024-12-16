// JavaScript file for Seller Dashboard functionality
document.addEventListener("DOMContentLoaded", () => {
    // Assuming we are getting the user info via a session or AJAX
    document.getElementById('username').innerText = 'Seller Name'; // Example, should be dynamically fetched

    // Fetch Auctions and Transactions from the PHP backend
    fetch('seller.php')
        .then(response => response.json())
        .then(data => {
            loadAuctions(data.auctions);
            loadTransactions(data.transactions);
        })
        .catch(error => console.error('Error fetching data:', error));
});

// Function to load auctions into the dashboard
function loadAuctions(auctions) {
    const auctionList = document.querySelector('.auction-list');
    auctions.forEach(auction => {
        const auctionItem = document.createElement('div');
        auctionItem.classList.add('auction-item');
        auctionItem.innerHTML = `
            <h3>${auction.item}</h3>
            <p>Current Bid: $${auction.currentBid}</p>
            <p>Status: ${auction.status}</p>
            <p>Time Left: ${auction.timeLeft}</p>
            <button onclick="viewAuction(${auction.auctionID})">View Auction</button>
        `;
        auctionList.appendChild(auctionItem);
    });
}
// Fetch Auctions and Transactions from the PHP backend
    fetch('seller.php')
        .then(response => response.json())
        .then(data => {
            loadAuctions(data.auctions);
            loadTransactions(data.transactions);
        })
        .catch(error => console.error('Error fetching data:', error));

// Function to load auctions into the dashboard
function loadAuctions(auctions) {
    const auctionList = document.querySelector('.auction-list');
    auctions.forEach(auction => {
        const auctionItem = document.createElement('div');
        auctionItem.classList.add('auction-item');
        auctionItem.innerHTML = `
            <h3>${auction.item}</h3>
            <p>Current Bid: $${auction.currentBid}</p>
            <p>Status: ${auction.status}</p>
            <p>Time Left: ${auction.timeLeft}</p>
            <button onclick="viewAuction(${auction.auctionID})">View Auction</button>
        `;
        auctionList.appendChild(auctionItem);
    });
}

// Function to load transactions into the dashboard
function loadTransactions(transactions) {
    const transactionList = document.querySelector('.transaction-list');
    transactions.forEach(transaction => {
        const transactionItem = document.createElement('div');
        transactionItem.classList.add('transaction-item');
        transactionItem.innerHTML = `
            <h3>Sale of ${transaction.auctionID}</h3>
            <p>Buyer: ${transaction.buyer}</p>
            <p>Final Price: $${transaction.finalPrice}</p>
            <p>Status: ${transaction.status}</p>
            <button onclick="viewTransactionDetails(${transaction.transactionID})">View Details</button>
        `;
        transactionList.appendChild(transactionItem);
    });
}
// Function to load transactions into the dashboard
function loadTransactions(transactions) {
    const transactionList = document.querySelector('.transaction-list');
    transactions.forEach(transaction => {
        const transactionItem = document.createElement('div');
        transactionItem.classList.add('transaction-item');
        transactionItem.innerHTML = `
            <h3>Sale of ${transaction.auctionID}</h3>
            <p>Buyer: ${transaction.buyer}</p>
            <p>Final Price: $${transaction.finalPrice}</p>
            <p>Status: ${transaction.status}</p>
            <button onclick="viewTransactionDetails(${transaction.transactionID})">View Details</button>
        `;
        transactionList.appendChild(transactionItem);
    });
}

// Function to view auction details (can be linked to auction page)
function viewAuction(auctionID) {
    alert('Viewing details for auction ID ' + auctionID);
    window.location.href = `auction_details.html?auctionID=${auctionID}`;
}

// Function to view transaction details
function viewTransactionDetails(transactionID) {
    alert("Viewing details for transaction ID ${transactionID}");
    localStorage.setItem("currentTransactionId", transactionID); 
    window.location.href = `view_transact.html?id=${transactionID}`;
}

// Function to view recent bids
function loadRecentBids() {
    const recentBids = JSON.parse(localStorage.getItem('recentBids')) || [];
    const recentBidsList = document.getElementById('recentBidsList');
    recentBidsList.innerHTML = ''; // Clear existing content

    if (recentBids.length === 0) {
        recentBidsList.innerHTML = "<p>No recent bids placed.</p>";
        return;
    }

    recentBids.forEach(bid => {
        const bidItem = document.createElement('div');
        bidItem.classList.add('bid-item');
        bidItem.innerHTML = `
            <h3>${bid.itemName}</h3>
            <p>Your Bid: $${bid.amount}</p>
            <p>Status: ${bid.status}</p>
        `;
        recentBidsList.appendChild(bidItem);
    });
}

// Function to edit inventory item
function editInventoryItem(itemID) {
    alert('Editing item with ID ' + itemID);
    window.location.href = `edit_inventory_item(1).html?auctionID=${auctionID}`;

}

// Function to add an item to auction
function addToAuction(itemID) {
    alert('Adding item with ID ' + itemID + ' to auction');
}

// Function to edit an auction
function editAuction(auctionID) {
    alert('Editing auction with ID ' + auctionID);
    window.location.href = `edit_auction.html?auctionID=${auctionID}`;
}


const auctionEndTimes = {
    1: new Date(new Date().getTime() + 2 * 60 * 60 * 1000 + 15 * 60 * 1000), // Auction 1: 2h 15m from now
};

// Function to update each auction timer
function updateAuctionTimer(auctionId) {
    const auctionEndTime = auctionEndTimes[auctionId];
    const currentTime = new Date();
    const timeRemaining = auctionEndTime - currentTime; // Time remaining in milliseconds

    // If auction time is over
    if (timeRemaining <= 0) {
        document.getElementById(`timer-${auctionId}`).innerText = 'Auction Ended';
        clearInterval(timers[auctionId]); // Stop the timer
        return;
    }

    // Calculate hours, minutes, and seconds remaining
    const hours = Math.floor(timeRemaining / (1000 * 60 * 60));
    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

    // Format as HH:MM:SS
    const formattedTime = `${padTime(hours)}:${padTime(minutes)}:${padTime(seconds)}`;
    document.getElementById(`timer-${auctionId}`).innerText = `Time Left: ${formattedTime}`;
}

// Function to pad single digit time values with leading zero
function padTime(time) {
    return time < 10 ? '0' + time : time;
}

// Create timers for each auction item
const timers = {};
Object.keys(auctionEndTimes).forEach((auctionId) => {
    timers[auctionId] = setInterval(() => updateAuctionTimer(auctionId), 1000); // Update every second
    updateAuctionTimer(auctionId); // Initialize the timer
});
document.addEventListener("DOMContentLoaded", function() {
    var username = localStorage.getItem('username');
    if (username) {
        document.getElementById('username').textContent = username;
    }

    // Load recent bids from localStorage
    var recentBids = JSON.parse(localStorage.getItem('recentBids')) || [];
    var recentBidsList = document.getElementById('recentBidsList');

    // Clear any existing bid items
    recentBidsList.innerHTML = '';

    // Debugging: Log recent bids to see if they're loaded correctly
    console.log("Loaded recent bids: ", recentBids);

    // Dynamically create bid items
    recentBids.forEach(function(bid) {
        var bidItem = document.createElement('div');
        bidItem.classList.add('bid-item');
        bidItem.innerHTML = `
            <h3>${bid.itemName}</h3>
            <p>Your Bid: $${bid.amount}</p>
            <p>Status: ${bid.status}</p>
        `;
        recentBidsList.appendChild(bidItem);
    });

    // If there are no bids, show a message
    if (recentBids.length === 0) {
        recentBidsList.innerHTML = "<p>No recent bids placed.</p>";
    }
});

function logout() {
    alert("You have logged out.");
    // In a real-world scenario, you would redirect to the login page or destroy the session
    window.location.href = "index.html";
}

function viewBids(auctionID) {
    alert('Viewing details for auction ID ' + auctionID);
    window.location.href = `view.html?auctionID=${auctionID}`;
}