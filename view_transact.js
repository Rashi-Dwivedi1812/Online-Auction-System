// Simulated transaction data
const transactions = [
    {
        id: 1,
        title: "Vintage Watch Sale",
        item: "Vintage Watch",
        buyer: "JohnDoe",
        finalPrice: 100,
        status: "Paid",
        paymentMethod: "Credit Card",
        paymentDate: "2024-11-28",
        deliveryAddress: "123 Main St, Springfield, USA",
        deliveryStatus: "Delivered"
    },
    {
        id: 2,
        title: "Luxury Watch Sale",
        item: "Luxury Watch",
        buyer: "JaneSmith",
        finalPrice: 500,
        status: "Paid",
        paymentMethod: "PayPal",
        paymentDate: "2024-11-29",
        deliveryAddress: "456 Elm St, Gotham City, USA",
        deliveryStatus: "In Transit"
    }
];

// Default transaction details (fallback)
const defaultTransaction = {
    title: "NO TRANSACTION SELECTED",
    item: "N/A",
    buyer: "N/A",
    finalPrice: "N/A",
    status: "N/A",
    paymentMethod: "N/A",
    paymentDate: "N/A",
    deliveryAddress: "N/A",
    deliveryStatus: "N/A"
};

// Load transaction details on page load
document.addEventListener("DOMContentLoaded", () => {
    // Get the transaction ID from localStorage or default to null
    const transactionId = parseInt(localStorage.getItem("currentTransactionId")) || null;

    // Find the transaction by ID, or use the defaultTransaction if no ID is found
    const transaction = transactions.find(t => t.id === transactionId) || defaultTransaction;

    // Populate the transaction details
    document.getElementById("transactionTitle").textContent = transaction.title;
    document.getElementById("itemSold").textContent = `Item: ${transaction.item}`;
    document.getElementById("buyerName").textContent = `Buyer: ${transaction.buyer}`;
    document.getElementById("finalPrice").textContent = `Final Price: $${transaction.finalPrice}`;
    document.getElementById("status").textContent = `Status: ${transaction.status}`;
    document.getElementById("paymentMethod").textContent = `Payment Method: ${transaction.paymentMethod}`;
    document.getElementById("paymentDate").textContent = `Payment Date: ${transaction.paymentDate}`;
    document.getElementById("deliveryAddress").textContent = `Delivery Address: ${transaction.deliveryAddress}`;
    document.getElementById("deliveryStatus").textContent = `Delivery Status: ${transaction.deliveryStatus}`;
});

// Navigate back to the dashboard
function goBack() {
    window.location.href = "seller.html";
}
