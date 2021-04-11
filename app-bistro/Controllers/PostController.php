<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;

class PostController extends Controller {

  /**
   * Affiche la liste des articles.
   */
  public function index() {
    $this->display(
      'post/list.html.twig',
      [
        'posts' => Post::getInstance()->getAll(),
      ]
    );
  }

  /**
   * Affiche un article.
   * @param  integer $id identifiant de l'article à afficher.
   */
  public function show($id) {
    $this->display(
      'post/show.html.twig', [
        'post' => Post::getInstance()->get($id),
      ]
    );
  }

  /**
   * Effacer un article.
   * @param  integer $id identifiant de l'article à effacer.
   */
  public function delete($id) {
    // effacer l'image
    // il faut récupérer les information sur l'article
    // pour notamment obtenir le nom de l'image
    $post = Post::getInstance()->get($id);
    $this->deleteIllustration($post['illustration']);
    // effacer l'article
    Post::getInstance()->delete($id);
    redirect('/');
  }

  /**
   * Afficher le formulaire d'ajout d'un article.
   */
  public function add() {
    $this->display('post/add.html.twig', ['users' => User::getInstance()->getAll()]);
  }

  /**
   * Enregistrer un nouvel article.
   */
  public function save() {
    // enregistrer l'image après l'avoir renommée
    if ($filename = $this->saveIllustration($_FILES['illustration'])) {
      // enregistrer l'article
      $_POST['illustration'] = $filename;
      Post::getInstance()->add($_POST);
    }

    redirect('/posts');
  }

  /**
   * Afficher le formulaire d'édition d'un article.
   * @param  integer $id identifiant de l'article à éditer.
   */
  public function edit($id) {
    $this->display('post/edit.html.twig', [
      'post' => Post::getInstance()->get($id),
      'users' => User::getInstance()->getAll(),
    ]);
  }

  /**
   * Mettre à jour un article.
   */
  public function update($id) {
    // si une nouvelle image est proposée, il faut
    // la placer dans le dossier asset/img
    if (!empty($_FILES)) {
      if ($filename = $this->saveIllustration($_FILES['illustration'])) {
        $_POST['illustration'] = $filename;
        // effacer l'ancienne image
        $post = Post::getInstance()->get($id);
        $this->deleteIllustration($post['illustration']);
      }
    }
    Post::getInstance()->update($id, $_POST);
    redirect('/');
  }

  /**
   * Enregistrer l'image d'illustration pour l'article.
   * @param  object $file les données du fichier uploadé
   * @return boolean|string       false si erreur de traitement sinon le nom de l'image
   *                              produite.
   */
  private function saveIllustration($file) {
    $source = $file['tmp_name'];
    // nom complet du fichier téléchargé
    $original = $file['name'];
    // nom du fichier téléchargé
    $original_filename = pathinfo($original, PATHINFO_FILENAME);
    // extension du fichier téléchargé
    $original_ext = pathinfo($original, PATHINFO_EXTENSION);
    $filename = $original_filename . '_' . time() . '.' . $original_ext;
    $dest = APP_ASSETS_DIRECTORY . 'img' . DS . 'illustrations' . DS . $filename;
    // vérifier le type
    if ($file['type'] === 'image/jpeg' ||
      $file['type'] === 'image/png') {
      move_uploaded_file($source, $dest);
      return $filename;
    }
    return false;
  }

  /**
   * Effacer une image d'illustration pour l'article.
   * @param  strig $filename      le nom de l'image
   *                              .
   */
  private function deleteIllustration($filename) {
    if ($filename) {
      $illustration = APP_ASSETS_DIRECTORY . 'img' . DS . 'illustrations' . DS . $filename;
      if (file_exists($illustration)) {
        unlink($illustration);
      }
    }
  }
}
