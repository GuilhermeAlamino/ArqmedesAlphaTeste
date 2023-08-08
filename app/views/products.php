<?php

require_once __DIR__ . '/../controllers/addProductController.php';

$controller = new AddProductController();
$products = $controller->index();

?>

<!doctype html>
<html ⚡>

<head>
  <title>Arqmedes | Backend Test | Products</title>
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

<body>
  <!-- Main Content -->
  <main class="content">
    <div class="header-list-page">
      <h1 class="title">Products</h1>
      <a href="?view=addProduct" class="btn-action">Add new Product</a>
    </div>
    <table class="data-grid">
      <tr class="data-row">
        <th class="data-grid-th">
          <span class="data-grid-cell-content">Name</span>
        </th>
        <th class="data-grid-th">
          <span class="data-grid-cell-content">SKU</span>
        </th>
        <th class="data-grid-th">
          <span class="data-grid-cell-content">Price</span>
        </th>
        <th class="data-grid-th">
          <span class="data-grid-cell-content">Quantity</span>
        </th>
        <th class="data-grid-th">
          <span class="data-grid-cell-content">Categories</span>
        </th>
        <th class="data-grid-th">
          <span class="data-grid-cell-content">Actions</span>
        </th>
      </tr>

      <?php foreach ($products as $product) : ?>
        <tr class="data-row">
          <td class="data-grid-td">
            <span class="data-grid-cell-content"><?php echo htmlspecialchars($product['name']); ?></span>
          </td>
          <td class="data-grid-td">
            <span class="data-grid-cell-content"><?php echo htmlspecialchars($product['sku']); ?></span>
          </td>
          <td class="data-grid-td">
            <span class="data-grid-cell-content"><?php echo 'R$ ' . number_format($product['price'], 2, ',', '.'); ?></span>
          </td>
          <td class="data-grid-td">
            <span class="data-grid-cell-content"><?php echo htmlspecialchars($product['quantity']); ?></span>
          </td>
          <td class="data-grid-td">
            <span class="data-grid-cell-content">
              <?php echo htmlspecialchars($product['categories']); ?><br />
            </span>
          </td>
          <td class="data-grid-td">
            <div class="actions">
              <div class="action edit">
                <a href="?view=editProduct&id=<?php echo $product['id']; ?>">Edit</a>
              </div>
              <div class="action delete"><a href="?view=deleteProduct&id=<?php echo $product['id']; ?>">Delete</a></div>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
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
  <!-- Footer -->
</body>

</html>