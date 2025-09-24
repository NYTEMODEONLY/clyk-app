<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 * 🌍 View all other existing AltumCode projects via https://altumcode.com/
 * 📧 Get in touch for support or general queries via https://altumcode.com/contact
 * 📤 Download the latest version via https://altumcode.com/downloads
 *
 * 🐦 X/Twitter: https://x.com/AltumCode
 * 📘 Facebook: https://facebook.com/altumcode
 * 📸 Instagram: https://instagram.com/altumcode
 */

defined('ALTUMCODE') || die();

// Enable error reporting for debugging
ini_set('display_errors', 'On');
error_reporting(E_ALL);

/* Error handlers */
function altumcode_shutdown_handler() {
    $last_error = error_get_last();

    if($last_error && ($last_error['type'] === E_ERROR || $last_error['type'] === E_CORE_ERROR || $last_error['type'] === E_PARSE || $last_error['type'] === E_COMPILE_ERROR)) {
        echo <<<ALTUM

<style>
    html {
        background: #161538;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        width: 100%;
        height: 100%;
        color: #eeeeee;
    }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        min-height: 100vh;
    }
    a {
        color: #c3beff;
        text-decoration: none;
    }
    .text-white {
        color: white;
    }
    .altumcode-logo {
        width: 3rem;
        height: auto;
    }
    .buttons {
        margin-top: 1.5rem;
    }

    /* Terminal-style error display */
    .error-terminal {
        background: #1a1a2e;
        border: 1px solid #3a3a5e;
        border-radius: 8px;
        width: 100%;
        max-width: 800px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        overflow: hidden;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    }

    .terminal-header {
        background: #2a2a4e;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #3a3a5e;
    }

    .terminal-title {
        font-weight: 600;
        color: #c3beff;
        font-size: 0.875rem;
    }

    .copy-button {
        background: #4a4a7e;
        color: #c3beff;
        border: none;
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .copy-button:hover {
        background: #5a5a8e;
        color: white;
    }

    .copy-button.copied {
        background: #4ade80;
        color: #1a1a2e;
    }

    .terminal-content {
        padding: 1rem;
        background: #0a0a1a;
        color: #e2e8f0;
        line-height: 1.6;
    }

    .error-line {
        margin: 0.5rem 0;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .error-label {
        color: #60a5fa;
        font-weight: 600;
        min-width: 120px;
        flex-shrink: 0;
    }

    .error-value {
        color: #f1f5f9;
        word-break: break-all;
    }

    .error-message {
        background: rgba(239, 68, 68, 0.1);
        border-left: 3px solid #ef4444;
        padding: 0.75rem;
        margin: 1rem 0;
        color: #fecaca;
    }

    .error-file {
        color: #94a3b8;
        font-size: 0.875rem;
    }

    .error-line-number {
        color: #fbbf24;
        font-weight: bold;
    }

    .error-type {
        color: #f87171;
        font-weight: bold;
    }

    .memory-info {
        color: #34d399;
    }

    .php-info {
        color: #a78bfa;
    }

    /* Terminal dots */
    .terminal-dots {
        display: flex;
        gap: 0.5rem;
    }

    .terminal-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .dot-red { background: #ef4444; }
    .dot-yellow { background: #fbbf24; }
    .dot-green { background: #22c55e; }
</style>

ALTUM;

        // Prepare error data for display and copying
        $error_data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'error_type' => $last_error['type'],
            'error_message' => $last_error['message'],
            'file' => $last_error['file'],
            'line' => $last_error['line'],
            'php_version' => phpversion(),
            'memory_usage' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB',
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Unknown'
        ];

        $error_text = "🚨 Clyk App - Fatal Error Report\n";
        $error_text .= "═══════════════════════════════════════\n\n";
        $error_text .= "Timestamp: {$error_data['timestamp']}\n";
        $error_text .= "Error Type: {$error_data['error_type']}\n";
        $error_text .= "Message: {$error_data['error_message']}\n";
        $error_text .= "File: {$error_data['file']}\n";
        $error_text .= "Line: {$error_data['line']}\n";
        $error_text .= "PHP Version: {$error_data['php_version']}\n";
        $error_text .= "Memory Usage: {$error_data['memory_usage']}\n";
        $error_text .= "Server: {$error_data['server_software']}\n";
        $error_text .= "Request URI: {$error_data['request_uri']}\n\n";
        $error_text .= "═══════════════════════════════════════\n";
        $error_text .= "Please share this error report for debugging assistance.";

        // Terminal-style error display
        echo '<div class="error-terminal">';
        echo '<div class="terminal-header">';
        echo '<div style="display: flex; align-items: center; gap: 0.75rem;">';
        echo '<div class="terminal-dots">';
        echo '<div class="terminal-dot dot-red"></div>';
        echo '<div class="terminal-dot dot-yellow"></div>';
        echo '<div class="terminal-dot dot-green"></div>';
        echo '</div>';
        echo '<div>';
        echo '<h1 style="color: white; margin: 0; font-size: 1.25rem; font-weight: 600;">Internal Server Error</h1>';
        echo '<p style="color: #94a3b8; margin: 0.25rem 0 0 0; font-size: 0.875rem;">Error Debug Terminal</p>';
        echo '</div>';
        echo '</div>';
        echo '<button class="copy-button" onclick="copyErrorToClipboard()">';
        echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
        echo '<rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>';
        echo '<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>';
        echo '</svg>';
        echo '<span id="copy-text">Copy Error</span>';
        echo '</button>';
        echo '</div>';

        echo '<div class="terminal-content">';
        echo '<div class="error-message">';
        echo '<strong>🚨 Fatal Error:</strong> ' . htmlspecialchars($last_error['message']);
        echo '</div>';

        echo '<p style="color: #94a3b8; margin-bottom: 1.5rem; font-size: 0.875rem;">';
        echo 'Our website is having some issues right now. We are actively working on fixing the issue. Please use the copy button above to share the error details for debugging assistance.';
        echo '</p>';

        // Map error types to readable names
        $error_types = [
            E_ERROR => 'E_ERROR',
            E_CORE_ERROR => 'E_CORE_ERROR',
            E_COMPILE_ERROR => 'E_COMPILE_ERROR',
            E_PARSE => 'E_PARSE',
            E_WARNING => 'E_WARNING',
            E_NOTICE => 'E_NOTICE',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        ];

        $error_type_name = $error_types[$last_error['type']] ?? 'UNKNOWN_ERROR';

        echo '<div class="error-line">';
        echo '<span class="error-label">Error Type:</span>';
        echo '<span class="error-value error-type">' . $error_type_name . ' (' . $last_error['type'] . ')</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">File:</span>';
        echo '<span class="error-value error-file">' . htmlspecialchars($last_error['file']) . '</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">Line:</span>';
        echo '<span class="error-value error-line-number">' . $last_error['line'] . '</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">PHP Version:</span>';
        echo '<span class="error-value php-info">' . phpversion() . '</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">Memory Usage:</span>';
        echo '<span class="error-value memory-info">' . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">Server:</span>';
        echo '<span class="error-value">' . htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . '</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">Request URI:</span>';
        echo '<span class="error-value">' . htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'Unknown') . '</span>';
        echo '</div>';

        echo '<div class="error-line">';
        echo '<span class="error-label">Timestamp:</span>';
        echo '<span class="error-value">' . date('Y-m-d H:i:s') . '</span>';
        echo '</div>';

        echo '</div>'; // terminal-content
        echo '</div>'; // error-terminal

        // Hidden textarea for copying
        echo '<textarea id="error-textarea" style="position: absolute; left: -9999px;">' . htmlspecialchars($error_text) . '</textarea>';

        // JavaScript for copy functionality and console logging
        echo '<script>';
        echo 'function copyErrorToClipboard() {';
        echo '    const textarea = document.getElementById("error-textarea");';
        echo '    const copyButton = document.querySelector(".copy-button");';
        echo '    const copyText = document.getElementById("copy-text");';
        echo '    ';
        echo '    textarea.select();';
        echo '    textarea.setSelectionRange(0, 99999);';
        echo '    ';
        echo '    try {';
        echo '        document.execCommand("copy");';
        echo '        copyButton.classList.add("copied");';
        echo '        copyText.textContent = "Copied!";';
        echo '        setTimeout(() => {';
        echo '            copyButton.classList.remove("copied");';
        echo '            copyText.textContent = "Copy Error";';
        echo '        }, 2000);';
        echo '    } catch (err) {';
        echo '        console.error("Failed to copy:", err);';
        echo '        copyText.textContent = "Failed";';
        echo '        setTimeout(() => {';
        echo '            copyText.textContent = "Copy Error";';
        echo '        }, 2000);';
        echo '    }';
        echo '}';

        // Console logging for debugging
        echo 'console.error("🚨 Clyk App Fatal Error:", ' . json_encode($last_error) . ');';
        echo 'console.log("📊 Server Info:", ' . json_encode($error_data) . ');';
        echo 'console.log("📋 Copy the error report above and share it for debugging assistance.");';
        echo '</script>';
        die();

    }
}

/* Register error handlers */
register_shutdown_function('altumcode_shutdown_handler');

