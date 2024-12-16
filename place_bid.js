function placeBid(event) {
    event.preventDefault(); // Prevent the form from refreshing the page

    // Get the bid amount from the input field
    var bidAmount = document.getElementById('bidAmount').value;

    // Get the item ID from the URL query string
    var urlParams = new URLSearchParams(window.location.search);
    var itemId = urlParams.get('itemId');
    var itemName = document.getElementById('itemName').value; // Get the item name from the form

    // Validate the bid amount
    if (bidAmount <= 0) {
        alert('Please enter a valid bid amount greater than zero.');
        return;
    }

    // Get the username from localStorage (the logged-in user)
    var username = localStorage.getItem('username');
    if (!username) {
        alert('You must be logged in to place a bid!');
        return;
    }

    // Get the existing bids from localStorage for the logged-in user, or initialize an empty array
    var recentBids = JSON.parse(localStorage.getItem('recentBids_' + username)) || [];

    // Add the new bid to the user's bid history
    recentBids.push({
        itemName: itemName,
        amount: bidAmount,
        status: 'Active'  // Example status, you can adjust as needed
    });

    // Store the updated bids array for the user in localStorage
    localStorage.setItem('recentBids_' + username, JSON.stringify(recentBids));

    // Display the confirmation message with the placed bid
    document.getElementById('bidDisplay').innerText = bidAmount;
    document.getElementById('confirmationMessage').style.display = 'block';

    // Redirect back to the dashboard after a delay
    setTimeout(function() {
        window.location.href = "buyers.html"; // Redirect to the dashboard after 2 seconds
    }, 2000);
}


// Function to populate the item details (itemName) when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Get the itemId from the URL query string
    var urlParams = new URLSearchParams(window.location.search);
    var itemId = urlParams.get('itemId');
    
    // For demonstration, create a mapping of item IDs to names
    var itemNames = {
        '1': 'Vintage Watch',
        '2': 'Fine Art',
        '3': 'Classic Guitar',
        '4': 'Precious Jewellery'
    };

    // Set the item name in the form based on the itemId
    if (itemNames[itemId]) {
        document.getElementById('itemName').value = itemNames[itemId];
    }
});

// Function to update the "My Recent Bids" section in the dashboard
function updateRecentBids(bidAmount) {
    // Get the username from localStorage (assuming the user is logged in)
    var username = localStorage.getItem('username');
    if (!username) {
        alert('User not logged in!');
        return;
    }

    // Access the parent window (the buyer's dashboard)
    var recentBidsList = window.opener.document.getElementById('recentBidsList');

    // Get the user's recent bids from localStorage
    var recentBids = JSON.parse(localStorage.getItem('recentBids_' + username)) || [];

    // Create a new bid item element
    var newBidItem = document.createElement('div');
    newBidItem.classList.add('bid-item');
    newBidItem.innerHTML = `<h3>${'New Item'}</h3><p>Your Bid: $${bidAmount}</p><p>Status: Active</p>`;

    // Prepend the new bid item to the top of the "My Recent Bids" list
    recentBidsList.insertBefore(newBidItem, recentBidsList.firstChild);

    // Optionally, refresh the dashboard view (if needed)
    window.opener.location.reload(); // This will reload the parent page to reflect the updates
}

// Function to load the "My Recent Bids" section for the logged-in user in buyers.html
function loadRecentBidsForUser() {
    // Get the username from localStorage (assuming the user is logged in)
    var username = localStorage.getItem('username');
    if (!username) {
        alert('User not logged in!');
        return;
    }

    // Access the parent window (the buyer's dashboard)
    var recentBidsList = document.getElementById('recentBidsList');

    // Get the user's recent bids from localStorage
    var recentBids = JSON.parse(localStorage.getItem('recentBids_' + username)) || [];

    // Clear the existing bids list to refresh it
    recentBidsList.innerHTML = '';

    // Loop through the user's bids and display them
    recentBids.forEach(function(bid) {
        var newBidItem = document.createElement('div');
        newBidItem.classList.add('bid-item');
        newBidItem.innerHTML = `<h3>${bid.itemName}</h3><p>Your Bid: $${bid.amount}</p><p>Status: ${bid.status}</p>`;

        // Prepend the new bid item to the top of the "My Recent Bids" list
        recentBidsList.insertBefore(newBidItem, recentBidsList.firstChild);
    });
}

// Call this function to load the recent bids when buyers.html is loaded
document.addEventListener('DOMContentLoaded', loadRecentBidsForUser);
