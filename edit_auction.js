// JavaScript for Edit Auction Modal
document.addEventListener("DOMContentLoaded", () => {
    const editAuctionModal = document.getElementById("editAuctionModal");
    const closeButton = document.querySelector(".close");
    const editAuctionForm = document.getElementById("editAuctionForm");

    // Function to close the modal
    const closeEditAuctionModal = () => {
        editAuctionModal.style.display = "none";
    };

    // Function to open the modal and populate it with existing auction data
    window.openEditModal = (itemId) => {
        // Get auction details from localStorage or a backend API
        const auctionData = JSON.parse(localStorage.getItem("auctionData"));
        
        // Find the auction item by ID
        const item = auctionData.find(i => i.id === itemId);
        if (!item) {
            alert("Auction not found!");
            return;
        }

        // Populate the form fields with the existing values
        document.getElementById("auctionTitle").value = item.title;
        document.getElementById("auctionDescription").value = item.description;
        document.getElementById("startingBid").value = item.startingBid.replace("$", "");
        document.getElementById("auctionDate").value = item.endDate;

        // Display the modal
        editAuctionModal.style.display = "block";

        // Attach the save function with the current auction ID
        editAuctionForm.onsubmit = function (event) {
            saveAuctionDetails(event, itemId);
        };
    };

    // Function to save the auction details after editing
    const saveAuctionDetails = (event, itemId) => {
        event.preventDefault();

        // Get updated data from the form fields
        const updatedTitle = document.getElementById("auctionTitle").value;
        const updatedDescription = document.getElementById("auctionDescription").value;
        const updatedStartingBid = document.getElementById("startingBid").value;
        const updatedEndDate = document.getElementById("auctionDate").value;

        // Validation (optional)
        if (!updatedTitle || !updatedDescription || !updatedStartingBid || !updatedEndDate) {
            alert("All fields are required!");
            return;
        }

        // Get existing auction data from localStorage
        const auctionData = JSON.parse(localStorage.getItem("auctionData"));

        // Find and update the auction item by ID
        const itemIndex = auctionData.findIndex(i => i.id === itemId);
        if (itemIndex !== -1) {
            auctionData[itemIndex] = {
                ...auctionData[itemIndex],
                title: updatedTitle,
                description: updatedDescription,
                startingBid: `$${updatedStartingBid}`,
                endDate: updatedEndDate
            };

            // Save updated auction data back to localStorage
            localStorage.setItem("auctionData", JSON.stringify(auctionData));

            // Close the modal
            closeEditAuctionModal();

            // Redirect back to seller.html
            window.location.href = "seller.html";
        } else {
            alert("Auction not found!");
        }
    };

    // Close modal when the close button is clicked
    closeButton.addEventListener("click", closeEditAuctionModal);

    // Expose the modal close function globally (if needed elsewhere)
    window.closeEditAuctionModal = closeEditAuctionModal;
});
