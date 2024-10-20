<?php
require_once __DIR__ . '/../models/ExpensesModel.php'; 
session_start();

class ExpensesController
{
    private $expenses;

    public function __construct()
    {
        $this->expenses = new ExpensesModel();
    }

    public function getAllExpensesByUser()
    {
        $userId = $_SESSION['userId'];
        $data = $this->expenses->getAllExpensesByUser($userId);
        return $data;
    }

    public function getExpenseById($id)
    {
        $expense = $this->expenses->getExpenseById($id);
        return $expense;
    }

    public function insertExpense($expenseName, $category,$amount,$expenseDate, $description)
    {
        $userId = $_SESSION['userId'];
        $response = [];
        if ($this->expenses->insertExpense($userId, $expenseName, $category, $amount, $expenseDate, $description)) {
            $response['status'] = 'success';
            $response['message'] = 'expenses successfully inserted';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to insert expenses';
        }

        return $response;
    }

    public function updateExpense($id, $expenseName, $category,$amount,$expenseDate, $description)
    {
        $response = [];
        if ($this->expenses->updateExpense($id, $expenseName, $category, $amount, $expenseDate, $description)) {
            $response['status'] = 'success';
            $response['message'] = 'expenses successfully updated';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to update expenses';
        }

        return $response;
    }

    public function deleteExpense($id)
    {
        $response = [];

        if ($this->expenses->deleteExpense($id)) {
            $response['status'] = 'success';
            $response['message'] = 'expenses successfully deleted';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to delete expenses';
        }

        return $response;
    }
}
