<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "seminar1";

$_conn = mysqli_connect($servername,$username,$password);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Get the form data
    $participant_name = $_POST['Participant_Name'];
    $email = $_POST['Email'];
    $phone_number = $_POST['Phone_Number'];
    $seminar_title = $_POST['Seminar_Title'];

    // Insert into the database
    $sql = "INSERT INTO `seminarreggg` (Participant_Name, Email, Phone_Number, Seminar_Title)
            VALUES ('$participant_name', '$email', '$phone_number', '$seminar_title')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Show seminar summary
if (isset($_POST['show_summary'])) {
    $seminar_summary = "SELECT Seminar_Title, COUNT(*) as Total_Participants FROM SeminarReg GROUP BY Seminar_Title";
    $result = $conn->query($seminar_summary);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminar Registration</title>
</head>
<body>

    <!-- Form to input participant details -->
    <h2>Seminar Registration Form</h2>
    <form method="POST" action="">
        <label for="Participant_Name">Name:</label><br>
        <input type="text" name="Participant_Name" required><br><br>

        <label for="Email">Email:</label><br>
        <input type="email" name="Email" required><br><br>

        <label for="Phone_Number">Phone Number:</label><br>
        <input type="text" name="Phone_Number" required><br><br>

        <label for="Seminar_Title">Seminar Title:</label><br>
        <input type="text" name="Seminar_Title" required><br><br>

        <input type="submit" name="register" value="Register">
    </form>

    <!-- Show seminar summary -->
    <h2>Show Seminar Summary</h2>
    <form method="POST" action="">
        <input type="submit" name="show_summary" value="Show Seminar Summary">
    </form>

    <?php
    if (isset($result)) {
        echo "<h3>Seminar Summary</h3>";
        echo "<table border='1'>
              <tr>
                  <th>Seminar Title</th>
                  <th>Total Participants</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                  <td>" . $row['Seminar_Title'] . "</td>
                  <td>" . $row['Total_Participants'] . "</td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
