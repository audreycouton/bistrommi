<?php

namespace App\Controllers;

use App\Models\Formula;


class FormulaController extends Controller {

  /**
   * Affiche la liste des articles.
   */
  public function index() {
    $this->display(
      'backoffice/formula/index.html.twig',
      [
        'formulas' => Formula::getInstance()->getAllActive(),
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
    $formula = Formula::getInstance()->get($id);
    //$this->deleteIllustration($post['illustration']);
    // effacer l'article
    Formula::getInstance()->delete($id);
    redirect('/');
  }

  /**
   * Afficher le formulaire d'ajout d'une formule.
   */
  public function add() {
    
    $this->display('backoffice/formula/add.html.twig');
    

  }

  /**
   * Enregistrer un nouvel article.
   */
  public function save() {
    $source = $_FILES['illustration']['tmp_name'];
        
     //nom du fichier de destination
   $filename = $_FILES['illustration']['name'];
    // nom et emplacement du fichier de destination
    $pathparts = pathinfo($filename); 
    if(!empty($category)){
     
 $filename = $pathparts['filename']."_".uniqid().".".$pathparts['extension'];
    }
    
   
    
    
   $dest = APP_ASSETS_DIRECTORY . "img/illustrations/$filename" ;
    
   move_uploaded_file( $source, $dest );
  
  $_POST['illustration']=$filename;
    Formula::getInstance()->add($_POST);
    redirect('/backoffice/formules');
  }

  /**
   * Afficher le formulaire d'édition d'un article.
   * @param  integer $id identifiant de l'article à éditer.
   */
  public function edit($id) {
    $this->display('backoffice/formula/edit.html.twig', [
      'formula' => Formula::getInstance()->get($id),
    ]);
  }

  /**
   * Mettre à jour un article.
   */
  public function update($id) {
    if (!empty($_FILES)) {
      if ($filename = $this->saveIllustration($_FILES['illustration'])) {
        $_POST['illustration'] = $filename;
        // effacer l'ancienne image
        $formula = Formula::getInstance()->get($id);
        $this->deleteIllustration($post['illustration']);
      }
    }
    Formula::getInstance()->update($id, $_POST);
    redirect('/backoffice/formules');
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