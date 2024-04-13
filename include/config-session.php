<!-- this file will make the session id unique for each user -->
<?php
ini_set('session.use_only_cookies', 1);             // Use only cookies
ini_set('session.use_strict_mode', 1);              // Use strict mode

session_set_cookie_params([
    'lifetime' => 3000,                             // Session lifetime
    'domain' => 'localhost',                        // Domain
    'path' => '/coursework',                        // Path
    'secure' => true,                               // Secure
    'httponly' => true                              // HTTP only
]);

session_start();                                    // Start the session

// create the regenerate session function id
function regenerateSession() {
    // create a new session id
    session_regenerate_id();
    $_SESSION["last_regeneration"] = time();        // Update last regeneration time
};

// create an if to check if a certain session is already started
if (!isset($_SESSION["last_regeneration"])) {       // Check if the session is already started
    regenerateSession();            // Call the regenerate session function
} else {
    $interval = 60 * 10;            // 10 minutes
    if (time() - $_SESSION["last_regeneration"] >= $interval) {         // Check if the session is expired
        regenerateSession();            // Regenerate the session by calling the function
    }
};