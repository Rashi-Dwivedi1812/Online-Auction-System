document.addEventListener("DOMContentLoaded", () => {
    // Get the auctionID from the URL query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const auctionID = urlParams.get('auctionID');

    // Fetch auction details using the auctionID
    fetchAuctionDetails(auctionID);
});

// Mock function to simulate fetching auction details from the server
function fetchAuctionDetails(auctionID) {
    // In a real scenario, make an AJAX request to the server to fetch auction data
    // For this mockup, we are using predefined data

    const auctionData = {
        1: {
            itemName: "Vintage Watch",
            itemDescription: "A rare vintage watch from the 1960s, still in working condition.",
            startPrice: 100,
            currentBid: 100,
            timeLeft: "1h 25m"
        },
        2: {
            itemName: "Fine Art Painting",
            itemDescription: "An exquisite painting by a famous artist.",
            startPrice: 250,
            currentBid: 350,
            timeLeft: "2h 5m"
        }
    };

    // Set the details for the auction
    const auction = auctionData[auctionID];
    if (auction) {
        document.getElementById('itemName').innerText = auction.itemName;
        document.getElementById('itemDescription').innerText = auction.itemDescription;
        document.getElementById('startPrice').innerText = auction.startPrice;
        document.getElementById('currentBid').innerText = auction.currentBid;
        document.getElementById('timeLeft').innerText = auction.timeLeft;
    } else {
        document.getElementById('itemName').innerText = "Auction not found.";
        document.getElementById('itemDescription').innerText = "";
        document.getElementById('startPrice').innerText = "";
        document.getElementById('currentBid').innerText = "";
        document.getElementById('timeLeft').innerText = "";
    }
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
