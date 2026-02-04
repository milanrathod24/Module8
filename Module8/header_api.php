<?php
// Get all request headers
$headers = getallheaders();

// Check for custom header
if (isset($headers['X-Custom-Header'])) {
    echo "Custom Header Value: " . $headers['X-Custom-Header'];
} else {
    echo "Custom Header not found";
}
?>
