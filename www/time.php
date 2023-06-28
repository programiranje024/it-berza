<?php
// Get current time and format it as DD/MM/YYYY HH:MM:SS
$time = date('d/m/Y H:i:s');

// Print the time
echo json_encode(['time' => $time]);
