

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Admin</h1>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Street Address</th>
                    <th>Zip Code</th>
                    <th>City</th>
                </tr>
            </thead>

            <?php
            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                

                // Create connection
                $conn = new mysqli( 'localhost:8889','root','root','test_index');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Escape and sanitize selected skill
                $selected_skill = $conn->real_escape_string($_POST['skill']);
                
                // Check if days are selected
                if(isset($_POST['days'])) {
                    // Escape and sanitize selected days
                    $selected_days = array_map(function($day) use ($conn) {
                        return $conn->real_escape_string($day);
                    }, $_POST['days']);
                    
                    // Construct SQL query to retrieve volunteers with selected skill and preferred days
                    $sql = "SELECT * FROM index_data WHERE preferreddays IN ('" . implode("', '", $selected_days) . "') AND (FIND_IN_SET('$selected_skill', skills) OR FIND_IN_SET(' $selected_skill', skills))";

                    // Execute SQL query
                    $result = $conn->query($sql);

                    // Display retrieved volunteers
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['user_name'] . "</td>";
                            echo "<td>" . $row['user_mail'] . "</td>";
                            echo "<td>" . $row['user_number'] . "</td>";
                            echo "<td>" . $row['user_address'] . "</td>";
                            echo "<td>" . $row['zip_code'] . "</td>";
                            echo "<td>" . $row['user_city'] . "</td>";
                            echo "</tr>";
                            // Add more fields as needed
                        }
                    } else {
                        echo "No volunteers found with the selected skill and preferred days.";
                    }
                } else {
                    echo "No days selected.";
                }

                // Close connection
                $conn->close();
            }
            

            ?>

        </table>

        <div class="text-center">
            <button class="btn btn-primary mx-2" onclick="window.location.href = 'homepage.html';">Back to Homepage</button>
            <button class="btn btn-secondary mx-2" onclick="window.location.href = 'admin.html';">Enter Another Query</button>
        </div>
    </div>
</body>
</html>


