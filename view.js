
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}


function showModal(modalID) {
    document.getElementById(modalID).style.display = 'block';
}


function closeModal(modalID) {
    document.getElementById(modalID).style.display = 'none';
}


function loadBids(auctionID) {
    const exampleBids = [
        { bidder: "John Doe", amount: "$150" },
        { bidder: "Jane Smith", amount: "$200" },
    ];
    const bidsList = document.getElementById('bids-list');
    bidsList.innerHTML = '';
    exampleBids.forEach(bid => {
        const li = document.createElement('li');
        li.textContent = `${bid.bidder}: ${bid.amount}`;
        bidsList.appendChild(li);
    });
}


function loadTransactionDetails(transactionID) {
    const transactionDetails = {
        buyer: "John Doe",
        finalPrice: "$500",
        status: "Paid",
    };
    document.getElementById('buyer').textContent = transactionDetails.buyer;
    document.getElementById('final-price').textContent = transactionDetails.finalPrice;
    document.getElementById('status').textContent = transactionDetails.status;
}


function loadInventoryItemDetails(itemID) {
    document.getElementById('item-name').value = "Vintage Watch";
    document.getElementById('item-status').value = "auctioned";
}


document.getElementById('edit-item-form')?.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Changes saved!');
});
