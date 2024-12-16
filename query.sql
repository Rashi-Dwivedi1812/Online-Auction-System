-- Create the OnlineAuction database
CREATE DATABASE IF NOT EXISTS OnlineAuction;
USE OnlineAuction;

-- Users table
CREATE TABLE IF NOT EXISTS Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('Buyer', 'Seller', 'Admin') NOT NULL,
    Token VARCHAR(255), -- Used for email verification
    is_verified TINYINT(1) DEFAULT 0 -- 0 means not verified, 1 means verified
);

-- Items table
CREATE TABLE IF NOT EXISTS Items (
    ItemID INT AUTO_INCREMENT PRIMARY KEY,
    ItemName VARCHAR(100) NOT NULL,
    Description TEXT NOT NULL,
    StartPrice DECIMAL(10, 2) NOT NULL,
    SellerID INT NOT NULL,
    FOREIGN KEY (SellerID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Auctions table
CREATE TABLE IF NOT EXISTS Auctions (
    AuctionID INT AUTO_INCREMENT PRIMARY KEY,
    ItemID INT NOT NULL,
    StartTime DATETIME NOT NULL,
    EndTime DATETIME NOT NULL,
    HighestBid DECIMAL(10, 2),
    Status ENUM('Ongoing', 'Closed') DEFAULT 'Ongoing',
    FOREIGN KEY (ItemID) REFERENCES Items(ItemID) ON DELETE CASCADE
);

-- Bids table
CREATE TABLE IF NOT EXISTS Bids (
    BidID INT AUTO_INCREMENT PRIMARY KEY,
    AuctionID INT NOT NULL,
    BidderID INT NOT NULL,
    BidAmount DECIMAL(10, 2) NOT NULL,
    BidTime DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AuctionID) REFERENCES Auctions(AuctionID) ON DELETE CASCADE,
    FOREIGN KEY (BidderID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Transactions table
CREATE TABLE IF NOT EXISTS Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    BuyerID INT NOT NULL,
    SellerID INT NOT NULL,
    AuctionID INT NOT NULL,
    FinalPrice DECIMAL(10, 2),
    PaymentStatus ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (BuyerID) REFERENCES Users(UserID) ON DELETE CASCADE,
    FOREIGN KEY (SellerID) REFERENCES Users(UserID) ON DELETE CASCADE,
    FOREIGN KEY (AuctionID) REFERENCES Auctions(AuctionID) ON DELETE CASCADE
);


CREATE TABLE users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  -- Hashed password
    role ENUM('Buyer', 'Seller', 'Admin') NOT NULL
);
