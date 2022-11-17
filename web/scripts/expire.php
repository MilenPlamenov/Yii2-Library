<?php

$sql_host = 'localhost';

$sql_name = 'library';

$sql_user = 'admin';

$sql_pass = 'admin';

$conn = new mysqli($sql_host, $sql_user, $sql_pass, $sql_name);

$conn->set_charset('utf8');

$update_query = "UPDATE book b
JOIN booked_books bb on b.id = bb.book_id
SET b.available_books = b.available_books + bb.amount
WHERE bb.booked_date < now() - interval 1 DAY;";

$delete_query = "DELETE FROM booked_books WHERE booked_date < now() - interval 1 DAY;";


$conn->query($update_query);
$conn->query($delete_query);


mysqli_close($conn);