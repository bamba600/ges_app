<?php
function demarrerSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function viderSession() {
    $_SESSION = [];
    session_unset();
}

function detruireSession() {
    session_destroy();
}

function deconnecterUtilisateur() {
    demarrerSession();
    viderSession();
    detruireSession();
}
