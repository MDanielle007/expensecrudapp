<?php
session_start();
require_once 'controllers/ExpensesController.php';
require_once 'controllers/UsersController.php';

$users = new UsersController();
$expenses = new ExpensesController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    switch ($url) {
        case 'auth':
            $data = $users->auth($_POST['email'], $_POST['password']);
            echo json_encode($data);
            break;
        case 'signup':
            $data = $users->signUp($_POST['username'], $_POST['email'], $_POST['password']);
            echo json_encode($data);
            break;
        case 'getAll':
            $data = $expenses->getAllExpensesByUser();
            echo json_encode($data);
            break;
        case 'get':
            $data = $expenses->getExpenseById($_POST['id']);
            echo json_encode($data);
            break;
        case 'insert':
            $result = $expenses->insertExpense($_POST['expenseName'], $_POST['category'], $_POST['amount'], $_POST['expenseDate'], $_POST['description']);
            echo json_encode($result);
            break;
        case 'update':
            $result = $expenses->updateExpense($_POST['id'], $_POST['expenseName'], $_POST['category'], $_POST['amount'], $_POST['expenseDate'], $_POST['description']);
            echo json_encode($result);
            break;
        case 'delete':
            $result = $expenses->deleteExpense($_POST['id']);
            echo json_encode($result);
            break;
    }
}