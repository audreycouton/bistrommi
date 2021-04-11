<?php

/**
 * Retourne l'URL complète.
 *
 * @param string $url
 */
function url($url = '') {
  echo APP_ROOT_URL_COMPLETE . $url;
}

/**
 * Redirige vers une commande.
 *
 * @param string $url
 * @return void
 */
function redirect(string $url = '/') {
  header('Location: ' . APP_ROOT_URL_COMPLETE . $url);
}
