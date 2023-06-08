<?php

class Category {
  private $db = null;

  public function __construct() {
    $this->db = (new Db())->getInstance();
  }

  public function getAllCategories() {
    $stmt = $this->db->prepare("SELECT * FROM categories");

    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function deleteCategory($category_id) {
    $category = $this->getCategoryById($category_id);

    if (!$category) {
      throw new Exception('Category does not exist');
    }

    $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");

    $stmt->execute([$category_id]);
  }

  public function createCategory($name) {
    $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (?)");

    $stmt->execute([$name]);
  }

  public function getCategoryById($category_id) {
    $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");

    $stmt->execute([$category_id]);

    return $stmt->fetch();
  }
}
