<?php
namespace App\Controllers;
use App\Models\Formula;

class FrontController extends Controller {
 /**
 * Affiche tous les articles.
 */
 public function index() {
    $this->display(
        'front/index.html.twig',
        [
          'formulas' => Formula::getInstance()->getAllActive()
        ]
      );
 }
}
