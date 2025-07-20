<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'addArticle' => [
        'path' => './assets/js/add-article/add-article.js',
        'entrypoint' => true,
    ],
    'login' => [
        'path' => './assets/js/login/login.js',
        'entrypoint' => true,
    ],
    'register' => [
        'path' => './assets/js/registration/registration.js',
        'entrypoint' => true,
    ],
    'forgetPassword' => [
        'path' => './assets/js/forgotten-password/forget-password.js',
        'entrypoint' => true,
    ],
        'password' => [
        'path' => './assets/js/new-password/new-password.js',
        'entrypoint' => true,
    ],
    'updateProfil' => [
        'path' => './assets/js/update-profil/update-profil.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
];
