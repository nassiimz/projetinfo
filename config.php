<?php
session_start();

// Désactiver la restriction d'accès direct
// defined('CONFIG_LOADED') or die('Accès direct interdit'); // <-- Ligne à supprimer

const ADMIN_EMAILS = [
    'nassimizza@gmail.com',
    'nassimsefraoui@gmail.com',
    'nassimbouslimani@gmail.com'
];

const USER_CSV = __DIR__ . '/utilisateurs3.csv';
const CSV_HEADER = ['id', 'nom', 'prenom', 'email', 'password', 'date_naissance', 'date_inscription', 'role'];

function isAdminUser($user)
{
    return isset($user['email'], $user['role']) &&
        $user['role'] === 'admin' &&
        in_array($user['email'], ADMIN_EMAILS);
}
