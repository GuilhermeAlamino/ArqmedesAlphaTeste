<?php

require_once __DIR__ . '/../database/databaseconnection.php';

session_start();

class AddCategoryController
{

  private $db;

  public function __construct()
  {
    $this->db = new DatabaseConnection();
  }

  public function store($formData)
  {
    $name = $formData['category-name'];
    $code = $formData['category-code'];

    if (empty($name) || empty($code)) {
      error_log('Campo de criação Categorias vazio:' . "\n\n", 3, '../error_log.txt');
      header('Location: ?view=addCategory');
      return;
    }

    try {
      $conn = $this->db->getConnection();

      // Inserir a categoria
      $sql = "INSERT INTO categories (name,code) VALUES (:name,:code)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':name', $formData['category-name']);
      $stmt->bindParam(':code', $formData['category-code']);
      $stmt->execute();

      error_log('Categoria adicionada com sucesso: name=' . $name . ', Code=' . $code . "\n\n", 3, '../error_log.txt');
      header('Location: ?view=categories');
    } catch (PDOException $e) {
      error_log('Erro: ' . $e->getMessage());
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function index()
  {
    try {
      $conn = $this->db->getConnection();

      $query = "SELECT id, name, code FROM categories";
      $stmt = $conn->prepare($query);
      $stmt->execute();

      error_log('Gerando as categorias ' . "\n\n", 3, '../error_log.txt');
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('Erro: ' . $e->getMessage() . "\n\n", 3, '../error_log.txt');
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function edit($categoryId)
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para buscar os dados da categoria
      $query = "SELECT id, name, code FROM categories WHERE id = :categoryId";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':categoryId', $categoryId);
      $stmt->execute();
      $category = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$category) {
        echo "Categoria não encontrada.";
        return;
      }

      // Armazena o ID na variável de sessão
      $_SESSION['edit_category_id'] = $category['id'];

      header('Location: ?view=updateCategory');
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function show($categoryId)
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para buscar os dados da categoria
      $query = "SELECT id, name, code FROM categories WHERE id = :categoryId";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':categoryId', $categoryId);
      $stmt->execute();
      $category = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$category) {
        echo "Categoria não encontrada.";
        return;
      }

      return $category;
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function update($formData)
  {
    $id = $formData['id'];
    $name = $formData['category-name'];
    $code = $formData['category-code'];

    if (empty($name) || empty($code)) {
      error_log('Campo de atualização categoria vazio:' . "\n\n", 3, '../error_log.txt');
      header('Location: ?view=addCategory');
      return;
    }

    try {
      $conn = $this->db->getConnection();

      // Atualizar a categoria com base no ID
      $sql = "UPDATE categories SET name = :name, code = :code WHERE id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':code', $code);
      $stmt->bindParam(':id', $id);
      $stmt->execute();

      error_log('Categoria atualizada com sucesso: ID=' . $id . ', name=' . $name . ', Code=' . $code . "\n\n", 3, '../error_log.txt');
      header('Location: ?view=categories');
    } catch (PDOException $e) {
      error_log('Erro: ' . $e->getMessage());
      echo 'Erro: ' . $e->getMessage();
    }
  }

  public function delete($categoryId)
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para verificar se a categoria existe
      $checkQuery = "SELECT id FROM categories WHERE id = :categoryId";
      $checkStmt = $conn->prepare($checkQuery);
      $checkStmt->bindParam(':categoryId', $categoryId);
      $checkStmt->execute();

      if ($checkStmt->rowCount() === 0) {
        echo "Categoria não encontrada.";
        return;
      }

      // Remover os registros relacionados da tabela product_category
      $removeRelationsSql = "DELETE FROM product_category WHERE category_id = :categoryId";
      $removeRelationsStmt = $conn->prepare($removeRelationsSql);
      $removeRelationsStmt->bindParam(':categoryId', $categoryId);
      if (!$removeRelationsStmt->execute()) {
        echo "Erro ao remover relações de produtos e categorias.";
        return;
      }

      // Deleta a categoria após remover as relações
      $deleteCategorySql = "DELETE FROM categories WHERE id = :categoryId";
      $deleteCategoryStmt = $conn->prepare($deleteCategorySql);
      $deleteCategoryStmt->bindParam(':categoryId', $categoryId);
      if ($deleteCategoryStmt->execute()) {
        error_log('Categoria deletada com sucesso: ID=' . $categoryId . "\n\n", 3, '../error_log.txt');
        // Redirecionar para a página de categorias
        header('Location: ?view=categories');
      } else {
        echo "Erro ao deletar categoria.";
      }
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }
}
