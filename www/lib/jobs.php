<?php

class Jobs {
  private $db = null;

  public function __construct() {
    $this->db = (new Db())->getInstance();
  }

  public function getAllJobs() {
    $sql = 'SELECT * FROM jobs';
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getJob($id) {
    $sql = 'SELECT * FROM jobs WHERE id = :id';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
  }

  public function getJobsByCompany($company_id) {
    $sql = 'SELECT * FROM jobs WHERE company_id = :company_id';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':company_id' => $company_id]);
    return $stmt->fetchAll();
  }

  public function createJob($data, $company_id, $category_id) {
    $sql = "INSERT INTO jobs (title, description, company_id, category_id) VALUES (:title, :description, :company_id, :category_id)";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
      ':title' => $data['title'],
      ':description' => $data['description'],
      ':company_id' => $company_id,
      ':category_id' => $category_id
    ]);

    return $this->getJob($this->db->lastInsertId());
  }

  public function updateJob($job_id, $data, $company_id, $category_id) {
    $sql = "UPDATE jobs SET title = :title, description = :description, company_id = :company_id, category_id = :category_id WHERE id = :id";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
      ':title' => $data['title'],
      ':description' => $data['description'],
      ':company_id' => $company_id,
      ':category_id' => $category_id,
      ':id' => $job_id
    ]);

    return $this->getJob($job_id);
  }

  public function deleteJob($id) {
    $sql = 'DELETE FROM jobs WHERE id = :id';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
  }
}

