<?php

require_once __DIR__ . '/../database/databaseconnection.php';

session_start();

class AddProductController
{
  private $db;

  public function __construct()
  {
    $this->db = new DatabaseConnection();
  }

  public function store($formData)
  {
    try {
      $conn = $this->db->getConnection();

      $sku = $formData['sku'];
      $productName = $formData['name'];
      $productPrice = $formData['price'];
      $productQuantity = $formData['quantity'];
      $productDescription = $formData['description'];
      $categories = $formData['category'];

      if (empty($sku) || empty($productName) || empty($productPrice) || empty($productQuantity) || empty($productDescription) || empty($categories)) {
        error_log('Campo de criação Produtos vazio:' . "\n\n", 3, '../error_log.txt');
        header('Location: ?view=addProduct');
        return;
      }

      // Inserir o produto na tabela "products"
      $productSql = "INSERT INTO products (sku, name, price, quantity, description) VALUES (:sku, :productName, :productPrice, :productQuantity, :productDescription)";
      $productStmt = $conn->prepare($productSql);
      $productStmt->bindParam(':sku', $sku);
      $productStmt->bindParam(':productName', $productName);
      $productStmt->bindParam(':productPrice', $productPrice);
      $productStmt->bindParam(':productQuantity', $productQuantity);
      $productStmt->bindParam(':productDescription', $productDescription);
      $productStmt->execute();

      $productId = $conn->lastInsertId();

      // Inserir os relacionamentos na tabela "product_categories"
      foreach ($categories as $categoryCode) {
        // Verificar se a categoria já existe
        $checkCategorySql = "SELECT id FROM categories WHERE code = :categoryCode";
        $checkCategoryStmt = $conn->prepare($checkCategorySql);
        $checkCategoryStmt->bindParam(':categoryCode', $categoryCode);
        $checkCategoryStmt->execute();

        if ($checkCategoryStmt->rowCount() > 0) {
          $categoryRow = $checkCategoryStmt->fetch(PDO::FETCH_ASSOC);
          $categoryId = $categoryRow['id'];

          // Verificar se o relacionamento já existe
          $checkRelationshipSql = "SELECT * FROM product_category WHERE product_id = :productId AND category_id = :categoryId";
          $checkRelationshipStmt = $conn->prepare($checkRelationshipSql);
          $checkRelationshipStmt->bindParam(':productId', $productId);
          $checkRelationshipStmt->bindParam(':categoryId', $categoryId);
          $checkRelationshipStmt->execute();

          if ($checkRelationshipStmt->rowCount() === 0) {
            // Vincular o produto à categoria na tabela "product_categories"
            $linkCategorySql = "INSERT INTO product_category (product_id, category_id) VALUES (:productId, :categoryId)";
            $linkCategoryStmt = $conn->prepare($linkCategorySql);
            $linkCategoryStmt->bindParam(':productId', $productId);
            $linkCategoryStmt->bindParam(':categoryId', $categoryId);
            $linkCategoryStmt->execute();
          }
        }
      }
      error_log('Produto adicionado com sucesso: SKU=' . $sku . ', Nome=' . $productName . "\n\n", 3, '../error_log.txt');
      header('Location: ?view=products');
    } catch (PDOException $e) {
      error_log('Erro: ' . $e->getMessage());
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function index()
  {
    try {
      $conn = $this->db->getConnection();

      // Consultar os produtos e suas categorias relacionadas
      $query = "SELECT p.id, p.name, p.sku, p.price, p.quantity, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM products p
                LEFT JOIN product_category pc ON p.id = pc.product_id
                LEFT JOIN categories c ON pc.category_id = c.id
                GROUP BY p.id";
      $stmt = $conn->prepare($query);
      $stmt->execute();

      error_log('Gerando relação produtos com categorias' . "\n\n", 3, '../error_log.txt');
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function edit($productId)
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para buscar os dados do produto
      $query = "SELECT id, name, sku, price, description, quantity FROM products WHERE id = :productId";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':productId', $productId);
      $stmt->execute();
      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$product) {
        echo "Produto não encontrada.";
        return;
      }

      // Armazena o ID na variável de sessão
      $_SESSION['edit_product_id'] = $product['id'];

      header('Location: ?view=updateProduct');
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function show($productId)
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para buscar os dados do produto
      $query = "SELECT id, name, sku, price, description, quantity FROM products WHERE id = :productId";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':productId', $productId);
      $stmt->execute();
      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$product) {
        echo "Produto não encontrada.";
        return;
      }

      return $product;
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function update($formData)
  {
    $productId = $formData['id'];
    $sku = $formData['sku'];
    $productName = $formData['name'];
    $productPrice = $formData['price'];
    $productQuantity = $formData['quantity'];
    $productDescription = $formData['description'];
    $categories = $formData['category'];

    if (empty($sku) || empty($productName) || empty($productPrice) || empty($productQuantity) || empty($productDescription) || empty($categories)) {
      error_log('Campo de atualização dos Produtos vazio:' . "\n\n", 3, '../error_log.txt');
      header('Location: ?view=updateProduct');
      return;
    }

    try {
      $conn = $this->db->getConnection();
      $conn->beginTransaction();

      // Atualizar o produto na tabela "products"
      $updateProductSql = "UPDATE products SET sku = :sku, name = :productName, price = :productPrice, quantity = :productQuantity, description = :productDescription WHERE id = :productId";
      $updateProductStmt = $conn->prepare($updateProductSql);
      $updateProductStmt->bindParam(':sku', $sku);
      $updateProductStmt->bindParam(':productName', $productName);
      $updateProductStmt->bindParam(':productPrice', $productPrice);
      $updateProductStmt->bindParam(':productQuantity', $productQuantity);
      $updateProductStmt->bindParam(':productDescription', $productDescription);
      $updateProductStmt->bindParam(':productId', $productId);
      $updateProductStmt->execute();

      // Remover as associações de categorias existentes na tabela product_category para esse produto
      $deleteExistingAssociationsSql = "DELETE FROM product_category WHERE product_id = :productId";
      $deleteExistingAssociationsStmt = $conn->prepare($deleteExistingAssociationsSql);
      $deleteExistingAssociationsStmt->bindParam(':productId', $productId);
      $deleteExistingAssociationsStmt->execute();

      // Criar as novas associações de categorias na tabela product_category
      foreach ($categories as $categoryCode) {
        $categoryId = null;
        $getCategoryIdSql = "SELECT id FROM categories WHERE code = :categoryCode";
        $getCategoryIdStmt = $conn->prepare($getCategoryIdSql);
        $getCategoryIdStmt->bindParam(':categoryCode', $categoryCode);
        $getCategoryIdStmt->execute();

        $categoryRow = $getCategoryIdStmt->fetch(PDO::FETCH_ASSOC);
        if ($categoryRow) {
          $categoryId = $categoryRow['id'];
          $createAssociationSql = "INSERT INTO product_category (product_id, category_id) VALUES (:productId, :categoryId)";
          $createAssociationStmt = $conn->prepare($createAssociationSql);
          $createAssociationStmt->bindParam(':productId', $productId);
          $createAssociationStmt->bindParam(':categoryId', $categoryId);
          $createAssociationStmt->execute();
        }
      }

      $conn->commit();

      error_log('Produto atualizado com sucesso: ID=' . $productId . "\n\n", 3, '../error_log.txt');

      // Redirecionar para a página de produtos
      header('Location: ?view=products');
    } catch (PDOException $e) {
      $conn->rollback();
      echo 'Erro: ' . $e->getMessage();
    }
  }


  public function delete($productId)
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para verificar se o produto existe
      $checkQuery = "SELECT id FROM products WHERE id = :productId";
      $checkStmt = $conn->prepare($checkQuery);
      $checkStmt->bindParam(':productId', $productId);
      $checkStmt->execute();

      if ($checkStmt->rowCount() === 0) {
        echo "Produto não encontrado.";
        return;
      }

      // Remover os registros relacionados da tabela product_category
      $removeRelationsSql = "DELETE FROM product_category WHERE product_id = :productId";
      $removeRelationsStmt = $conn->prepare($removeRelationsSql);
      $removeRelationsStmt->bindParam(':productId', $productId);
      if (!$removeRelationsStmt->execute()) {
        echo "Erro ao remover relações de produtos e categorias.";
        return;
      }

      // Deleta o produto após remover as relações
      $deleteProductSql = "DELETE FROM products WHERE id = :productId";
      $deleteProductStmt = $conn->prepare($deleteProductSql);
      $deleteProductStmt->bindParam(':productId', $productId);
      if ($deleteProductStmt->execute()) {
        error_log('Produto deletado com sucesso: ID=' . $productId . "\n\n", 3, '../error_log.txt');

        // Redirecionar para a página de produtos 
        header('Location: ?view=products');
      } else {
        echo "Erro ao deletar produto.";
      }
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }
}
