<?php

function loadView($viewName)
{
  require_once __DIR__ . '/../app/views/' . $viewName . '.php';
}

function loadController($controllerName)
{
  require_once __DIR__ . '/../app/controllers/' . $controllerName . '.php';
}

if (isset($_GET['view'])) {
  $view = $_GET['view'];
  $allowedViews = ['dashboard', 'addProduct', 'products', 'editProduct', 'updateProduct', 'deleteProduct', 'addCategory', 'categories', 'editCategory', 'updateCategory', 'deleteCategory', 'addProductController', 'updateProductsController', 'addCategoriesController', 'updateCategoriesController'];

  if (in_array($view, $allowedViews)) {

    switch ($view) {
      case 'addProductController':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          loadController('addProductController');
          $controller = new AddProductController();
          $controller->store($_POST);
        } else {
          loadView($view);
        }
        break;

      case 'updateProductsController':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          loadController('addProductController');
          $controller = new AddProductController();
          $controller->update($_POST);
          loadView($view);
        }
        break;

      case 'editProduct':
        if (isset($_GET['id'])) {
          loadController('addProductController');
          $controller = new AddProductController();
          $productId = $_GET['id'];
          $controller->edit($productId);
        } else {
          echo "ID do produto não especificado.";
        }
        break;

      case 'deleteProduct':
        if (isset($_GET['id'])) {
          loadController('addProductController');
          $controller = new AddProductController();
          $productId = $_GET['id'];
          $controller->delete($productId);
        } else {
          echo "ID do produto não especificado.";
        }
        break;

      case 'addCategoriesController':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          loadController('addCategoriesController');
          $controller = new AddCategoryController();
          $controller->store($_POST);
          loadView($view);
        }
        break;

      case 'updateCategoriesController':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          loadController('addCategoriesController');
          $controller = new AddCategoryController();
          $controller->update($_POST);
          loadView($view);
        }
        break;

      case 'editCategory':
        if (isset($_GET['id'])) {
          loadController('addCategoriesController');
          $controller = new AddCategoryController();
          $categoryId = $_GET['id'];
          $controller->edit($categoryId);
        } else {
          echo "ID da categoria não especificado.";
        }
        break;

      case 'deleteCategory':
        if (isset($_GET['id'])) {
          loadController('addCategoriesController');
          $controller = new AddCategoryController();
          $categoryId = $_GET['id'];
          $controller->delete($categoryId);
        } else {
          echo "ID da categoria não especificado.";
        }
        break;

      default:
        loadView($view);
        break;
    }
    
  } else {
    echo '<h1>View ou Controller não encontrado</h1>';
  }
} else {
  loadView('dashboard');
}
