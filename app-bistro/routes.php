<?php
//== la page d'accueil ========================================
$route->addRoute('GET', '/', 'FrontController@index');
$route->addRoute('GET', '/backoffice/formules', 'FormulaController@index');
$route->addRoute('GET', '/backoffice/formules/effacer/{id:[0-9]+}', 'FormulaController@delete');
$route->addRoute('GET', '/backoffice/formules/ajouter', 'FormulaController@add');
$route->addRoute('GET', '/backoffice/formules/editer/{id:[0-9]+}', 'FormulaController@edit');
$route->addRoute('POST', '/backoffice/formules/editer/{id:[0-9]+}', 'FormulaController@update');
$route->addRoute('POST', '/backoffice/formules/ajouter', 'FormulaController@save');
