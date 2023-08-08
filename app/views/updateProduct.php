<?php

require_once __DIR__ . '/../controllers/addProductController.php';
require_once __DIR__ . '/../controllers/addCategoriesController.php';
session_start();

$controller = new AddCategoryController();
$categories = $controller->index();

if (isset($_SESSION['edit_product_id'])) {
  $editProductId = $_SESSION['edit_product_id'];

  $controller = new AddProductController();
  $productShow = $controller->show($editProductId);
} else {
  echo "ID da categoria não especificado.";
}

?>
<!doctype html>
<html ⚡>

<head>
  <title>Arqmedes | Backend Test | Add Product</title>
  <meta charset="utf-8">

  <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet">
  <meta name="viewport" content="width=device-width,minimum-scale=1">
  <style amp-boilerplate>
    body {
      -webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
      -moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
      -ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
      animation: -amp-start 8s steps(1, end) 0s 1 normal both
    }

    @-webkit-keyframes -amp-start {
      from {
        visibility: hidden
      }

      to {
        visibility: visible
      }
    }

    @-moz-keyframes -amp-start {
      from {
        visibility: hidden
      }

      to {
        visibility: visible
      }
    }

    @-ms-keyframes -amp-start {
      from {
        visibility: hidden
      }

      to {
        visibility: visible
      }
    }

    @-o-keyframes -amp-start {
      from {
        visibility: hidden
      }

      to {
        visibility: visible
      }
    }

    @keyframes -amp-start {
      from {
        visibility: hidden
      }

      to {
        visibility: visible
      }
    }
  </style><noscript>
    <style amp-boilerplate>
      body {
        -webkit-animation: none;
        -moz-animation: none;
        -ms-animation: none;
        animation: none
      }
    </style>
  </noscript>
  <script async src="https://cdn.ampproject.org/v0.js"></script>
  <script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
  <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
</head>
<!-- Header -->
<amp-sidebar id="sidebar" class="sample-sidebar" layout="nodisplay" side="left">
  <div class="close-menu">
    <a on="tap:sidebar.toggle">
      <img src="images/bt-close.png" alt="Close Menu" width="24" height="24" />
    </a>
  </div>
  <a href="?view=dashboard"><img src="images/arqmedes_logo-nova.jpg" alt="Welcome" width="200" height="43" /></a>
  <div>
    <ul>
      <li><a href="?view=dashboard" class="link-menu">Home</a></li>
      <li><a href="?view=categories" class="link-menu">Categorias</a></li>
      <li><a href="?view=products" class="link-menu">Produtos</a></li>
    </ul>
  </div>
</amp-sidebar>
<header>
  <div class="go-menu">
    <a on="tap:sidebar.toggle">☰</a>
    <a href="?view=dashboard" class="link-logo"><img src="images/php.png" alt="Welcome" width="69" height="430" /></a>
  </div>
  <div class="right-box">
    <span class="go-title">Administration Panel</span>
  </div>
</header>
<!-- Header -->
<!-- Main Content -->
<main class="content">
  <h1 class="title new-item">Update Product</h1>

  <form action="?view=updateProductsController" method="POST">
    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($productShow['id']); ?>">

    <div class="input-field">
      <label for="sku" class="label">Product SKU</label>
      <input type="text" id="sku" name="sku" class="input-text" value="<?php echo htmlspecialchars($productShow['sku']); ?>" />
    </div>
    <div class="input-field">
      <label for="name" class="label">Product Name</label>
      <input type="text" id="name" name="name" class="input-text" value="<?php echo htmlspecialchars($productShow['name']); ?>" />
    </div>
    <div class="input-field">
      <label for="price" class="label">Price</label>
      <input type="text" id="price" name="price" class="input-text" value="<?php echo htmlspecialchars($productShow['price']); ?>" />
    </div>
    <div class="input-field">
      <label for="quantity" class="label">Quantity</label>
      <input type="text" id="quantity" name="quantity" class="input-text" value="<?php echo htmlspecialchars($productShow['quantity']); ?>" />
    </div>
    <div class="input-field">
      <label for="category" class="label">Categories</label>
      <select multiple id="category" name="category[]" class="input-text">
        <?php foreach ($categories as $category) : ?>
          <option value="<?php echo htmlspecialchars($category['code']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="input-field">
      <label for="description" class="label">Description</label>
      <textarea id="description" name="description" class="input-text"><?php echo htmlspecialchars($productShow['description']); ?></textarea>
    </div>
    <div class="actions-form">
      <a href="?view=products" class="action back">Back</a>
      <input class="btn-submit btn-action" type="submit" value="Save Product" />
    </div>
  </form>
</main>
<!-- Main Content -->

<!-- Footer -->
<footer>
  <div class="footer-image">
    <img src="images/arqmedes_logo-nova.jpg" width="119" height="26" alt="Go Jumpers" />
  </div>
  <div class="email-content">
    <span>ecio@arqmedesconsultoria.com.br</span>
  </div>
</footer>
<!-- Footer --></body>

</html>