<?php

    // Query the database for users
    try {
        $query = "SELECT * FROM inscription";
        $result = $_bdd->query($query);
        
    } catch (PDOException $e) {
        echo 'Query failed: ' . $e->getMessage();
        die();
    }

    // If there are no results, display a message
    if ($result->rowCount() === 0) {
        echo "No results found.";
        die();
    }

    // Get user data from the database and store it in session variables
       
    
?>
