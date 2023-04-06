<?php
// Connect to MySQL database
$servername = "localhost";
$username = "visualisationpol_stage";
$password = "visualisationpol_stage";
$dbname = "visualisationpol_dev";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select data from old table
$sql = "SELECT pro_id, city_id, field_id, field_value FROM data_field_value";
$result = mysqli_query($conn, $sql);

// Create a new array to store the data
$new_data = array();

// Loop through the results
while ($row = mysqli_fetch_assoc($result)) {
    $pro_id = $row['pro_id'];
    $city_id = $row['city_id'];
    $field_id = $row['field_id'];
    $field_value = $row['field_value'];

    // Add the data to the new array
    if (!isset($new_data[$pro_id][$city_id])) {
        $new_data[$pro_id][$city_id] = array();
    }

    $new_data[$pro_id][$city_id][$field_id] = $field_value;
}

// Loop through the new array and insert the data into the new table
foreach ($new_data as $pro_id => $city_data) {
    foreach ($city_data as $city_id => $field_data) {
        $field_value_data = serialize(array_map(function ($k, $v) {
            return [$k => $v];
        }, array_keys($field_data), array_values($field_data)));
        $field_value_data = mysqli_real_escape_string($conn, $field_value_data);

        $sql = "INSERT INTO data_field_value_new (pro_id, city_id, field_value_data) VALUES ('$pro_id', '$city_id', '$field_value_data')";
        mysqli_query($conn, $sql);
    }
}

// Close the connection
mysqli_close($conn);
?>


