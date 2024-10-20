<?php
require_once __DIR__ . '/../config/Database.php';

class ExpensesModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllExpenses()
    {
        $query = "SELECT * FROM expenses";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllExpensesByUser($id)
    {

        try {
            $query = "SELECT * FROM expenses WHERE user_id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log exception message
            error_log($e->getMessage());
            return false;
        }
    }

    public function getExpenseById($id)
    {
        $query = "SELECT * FROM expenses WHERE expense_id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertExpense($userId, $expenseName, $category, $amount, $expenseDate, $description)
    {
        try {
            $query = "INSERT INTO expenses (user_id, expense_name, category, amount, expense_date, description) VALUES (:user_id, :expense_name, :category, :amount, :expense_date, :description)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':expense_name', $expenseName);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':expense_date', $expenseDate);
            $stmt->bindParam(':description', $description);
            if ($stmt->execute()) {
                return true;
            } else {
                // Log error information
                error_log(print_r($stmt->errorInfo(), true));
                return false;
            }
        } catch (PDOException $e) {
            // Log exception message
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateExpense($id, $expenseName, $category, $amount, $expenseDate, $description)
    {
        try {
            $query = "UPDATE expenses SET expense_name=:expense_name, category=:category, amount=:amount, expense_date=:expense_date, description=:description WHERE expense_id=:expense_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':expense_name', $expenseName);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':expense_date', $expenseDate);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':expense_id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log exception message
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteExpense($id)
    {
        $query = "DELETE FROM expenses WHERE expense_id=:expense_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':expense_id', $id);
        return $stmt->execute();
    }
}
