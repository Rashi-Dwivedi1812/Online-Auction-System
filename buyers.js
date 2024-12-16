function removeFromWatchlist(itemId) {
    // Show a confirmation alert
    alert("Item " + itemId + " has been removed from your watchlist.");

    // Find the watchlist item element by its ID
    const watchlistItem = document.getElementById('watchlist-item-' + itemId);

    // If the item exists in the DOM, remove it
    if (watchlistItem) {
        // Remove the item from the DOM
        watchlistItem.remove();

        // Confirm that the item has been removed after alerting the user
        console.log('Item with ID ' + itemId + ' has been removed from the watchlist.');
    } else {
        // If the item is not found in the DOM, show an alert
        alert("Item not found in your watchlist.");
    }
}

// Logout function
function logout() {
    alert("You have logged out.");
    // In a real-world scenario, you would redirect to the login page or destroy the session
    window.location.href = "index.html";
}

// Auction end times for all 4 items (in milliseconds from the current time)
const auctionEndTimes = {
    1: new Date(new Date().getTime() + 2 * 60 * 60 * 1000 + 15 * 60 * 1000), // Auction 1: 2h 15m from now
    2: new Date(new Date().getTime() + 1 * 60 * 60 * 1000 + 45 * 60 * 1000), // Auction 2: 1h 45m from now
    3: new Date(new Date().getTime() + 1 * 60 * 60 * 1000 + 30 * 60 * 1000), // Auction 3: 1h 30m from now
    4: new Date(new Date().getTime() + 3 * 60 * 60 * 1000)  // Auction 4: 3 hours from now
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

const timers = {};
Object.keys(auctionEndTimes).forEach((auctionId) => {
    timers[auctionId] = setInterval(() => updateAuctionTimer(auctionId), 1000); // Update every second
    updateAuctionTimer(auctionId); // Initialize the timer
});


function loadBidFromURL() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const bidAmount = urlParams.get('bidAmount');

    if (bidAmount) {
        // Insert the bid into the "Active Bids" section
        var recentBidsList = document.getElementById('recentBidsList');
        var newBidItem = document.createElement('div');
        newBidItem.classList.add('bid-item');
        newBidItem.innerHTML = `<h3>New Item</h3><p>Your Bid: $${bidAmount}</p><p>Status: Active</p>`;
        recentBidsList.insertBefore(newBidItem, recentBidsList.firstChild);

        // Scroll to the "Active Bids" section
        document.getElementById('activeBidsSection').scrollIntoView({ behavior: 'smooth' });
    }
}

// Call the function to load the bid when the page loads
window.onload = loadBidFromURL;