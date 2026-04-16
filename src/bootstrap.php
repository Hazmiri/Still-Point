<?php

declare(strict_types=1);

/**
 * Bootstrap file for common project setup.
 *
 * This file centralises shared preparation logic so that public pages
 * do not need to repeat the same require statements over and over.
 */

/**
 * Start the session only if one has not already been started.
 * This prevents warnings from trying to start the session twice.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Load the database connection helper.
 */
require_once __DIR__ . '/db.php';
