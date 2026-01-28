<?php

include __DIR__."/config/conn.php";
// Load and execute schema file
$path = __DIR__.'/config/query.sql';
if (!file_exists($path)) {
    die("SQL file not found at: $path");
}

$sql_content = file_get_contents($path);
if ($conn->multi_query($sql_content)) {
    echo "✅ Database reset successfully.<br>";
    // Clear remaining results from multi_query
    while ($conn->more_results() && $conn->next_result()) {
        $extra = $conn->store_result();
        if ($extra) $extra->free();
    }
} else {
    die("❌ Failed to run query.sql: " . $conn->error);
}

// if ($conn->query("SELECT * FROM member where email='shop@shoplenca.com' and ")) {
//    mysqli_query($conn,"insert into member(email,pass,roles,status) values('shop@shoplenca.com','$2y$10$Zr47PL3YAcrSeDSYfIRp7OSr9wqLa6NJFcQ2wsmZNB0b6AS8b0bE2','admin','active');");

// }

// Categories to seed
$conn->close();
