<?php

require_once __DIR__ . '/app/database/DatabaseConnection.php';

class ImportController
{
  private $db;

  public function __construct()
  {
    $this->db = new DatabaseConnection();
  }

  public function importToCSV()
  {
    try {
      $conn = $this->db->getConnection();

      // Consulta SQL para recuperar os dados dos produtos e suas categorias
      $sql = "SELECT p.name, p.sku, p.description, p.quantity, p.price, GROUP_CONCAT(c.name SEPARATOR ', ') as categories
                    FROM products p
                    LEFT JOIN product_category pc ON p.id = pc.product_id
                    LEFT JOIN categories c ON pc.category_id = c.id
                    GROUP BY p.id";

      // Prepara a consulta e a executa
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      // Abre o arquivo CSV existente para anexar os dados
      $csvFile = fopen('import.csv', 'a');

      // Itera sobre os resultados e escreve no arquivo CSV usando o ponto e vírgula como separador
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($csvFile, $row, ';');
      }

      fclose($csvFile);

      $errorLogPath = '/var/www/error_log.txt';

      error_log('Importação efetuada de produtos e categorias' . "\n\n", 3, $errorLogPath);

      echo "Importação de produtos para CSV concluída com sucesso!";
    } catch (PDOException $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }
}

$controller = new ImportController();
$controller->importToCSV();
