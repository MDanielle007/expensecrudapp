<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <title>Simple Expense CRUD APP</title>
</head>

<body>
    <nav class="navbar navbar-expand navbar-light bg-dark topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <div class="text-light align-middle d-flex justify-content-center align-items-center ps-5">
                <h4>
                    Expenses Management
                </h4>
            </div>
            <div class="topbar-divider d-none d-sm-block"></div>

            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle text-gray-400" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-gray-400">
                        <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        <?= isset($_SESSION['email']) ? $_SESSION['email'] : 'Email not available'; ?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <div class="container py-4 ">
        <form id="expenseForm" class="row gy-2 gx-3 align-items-center">
            <input type="hidden" class="form-control" id="id">
            <div class="col-12 col-sm-6 col-md-3">
                <label for="petName">Expense</label>
                <input type="text" class="form-control" id="expenseName">
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label for="petType">Category</label>
                <select class="form-select" id="expenseCategory">
                    <option selected>Choose...</option>
                    <option value="Food & Dining">Food & Dining</option>
                    <option value="Transport">Transport</option>
                    <option value="Housing">Housing</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Insurance">Insurance</option>
                    <option value="Education">Education</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Miscellaneous">Miscellaneous</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label for="expenseAmount">Amount</label>
                <input type="number" class="form-control" id="expenseAmount">
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label for="expenseDate">Date</label>
                <input type="date" class="form-control" id="expenseDate">
            </div>
            <div class="col-12 col-md-8">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <table id="dataTable" class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Expense</th>
                    <th scope="col">Category</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editExpenseName" class="form-label">Expense</label>
                        <input type="text" class="form-control" id="editExpenseName">
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseCategory" class="form-label">Category</label>
                        <select class="form-select" id="editExpenseCategory">
                            <option selected>Choose...</option>
                            <option value="Food & Dining">Food & Dining</option>
                            <option value="Transport">Transport</option>
                            <option value="Housing">Housing</option>
                            <option value="Utilities">Utilities</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Insurance">Insurance</option>
                            <option value="Education">Education</option>
                            <option value="Shopping">Shopping</option>
                            <option value="Miscellaneous">Miscellaneous</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="editExpenseAmount">
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editExpenseDate">
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseDescription" class="form-label">Description</label>
                        <textarea name="editExpenseDescription" class="form-control"
                            id="editExpenseDescription"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkUserLogin() {
            const loginStatus = <?= isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false; ?>;

            if (!loginStatus) {
                window.location.href = '/login.php';
                return;
            }
        }

        function fetchData() {
            $.ajax({
                url: 'ajaxHandler.php',
                type: 'POST',
                data: { url: 'getAll' },
                dataType: 'json',
                success: function (data) {
                    var tbody = $('#dataTable tbody');
                    tbody.empty();
                    data.forEach(function (expense) {
                        var row = $('<tr>');
                        row.append('<td>' + expense.expense_id + '</td>');
                        row.append('<td>' + expense.expense_name + '</td>');
                        row.append('<td>' + expense.category + '</td>');
                        row.append('<td>' + expense.amount + '</td>');
                        row.append('<td>' + expense.expense_date + '</td>');
                        row.append('<td><button class="btn btn-warning btn-edit" data-id="' + expense.expense_id + '">Edit</button> ' +
                            '<button class="btn btn-danger btn-delete" data-id="' + expense.expense_id + '">Delete</button></td>');
                        tbody.append(row);
                    });
                }
            });
        }

        $(document).ready(() => {
            checkUserLogin();
            fetchData();

            $('#expenseForm').on('submit', function (event) {
                event.preventDefault();

                const expenseName = $('#expenseName').val();
                const category = $('#expenseCategory').val();
                const amount = Number($('#expenseAmount').val());
                const expenseDate = $('#expenseDate').val();
                const description = $('#description').val();

                const formatedDate = new Intl.DateTimeFormat("en-CA", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    timeZone: "Asia/Manila",
                })
                    .format(new Date(expenseDate))
                    .split("/")
                    .reverse()
                    .join("-");

                if (expenseName === '' || category === 'Choose...' || amount <= 0 || expenseDate === '' || description === '') {
                    alert('Please fill in all fields.');
                    return;
                }

                $.post('ajaxHandler.php', {
                    url: 'insert',
                    expenseName: expenseName,
                    category: category,
                    amount: amount,
                    expenseDate: formatedDate,
                    description: description
                }, function (response) {
                    console.log(response);

                    alert(response.message);
                    $('#expenseForm')[0].reset();
                    fetchData();
                }, 'json');
            });

            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                $.post('ajaxHandler.php', { url: 'get', id: id }, function (data) {
                    $('#editId').val(data.expense_id);
                    $('#editExpenseName').val(data.expense_name);
                    $('#editExpenseCategory').val(data.category);
                    $('#editExpenseAmount').val(data.amount);
                    $('#editExpenseDate').val(data.expense_date);
                    $('#editExpenseDescription').val(data.description);
                    $('#editModal').modal('show');
                }, 'json');
            });

            $('#saveChanges').click(function () {
                const id = $('#editId').val();
                const expenseName = $('#editExpenseName').val();
                const category = $('#editExpenseCategory').val();
                const amount = $('#editExpenseAmount').val();
                const expenseDate = $('#editExpenseDate').val();
                const description = $('#editExpenseDescription').val();

                const formatedDate = new Intl.DateTimeFormat("en-CA", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    timeZone: "Asia/Manila",
                })
                    .format(new Date(expenseDate))
                    .split("/")
                    .reverse()
                    .join("-");
                console.log({
                    id: id,
                    expenseName: expenseName,
                    category: category,
                    amount: amount,
                    expenseDate: formatedDate,
                    description: description
                });

                $.post('ajaxHandler.php', {
                    url: 'update',
                    id: id,
                    expenseName: expenseName,
                    category: category,
                    amount: amount,
                    expenseDate: formatedDate,
                    description: description
                }, function (response) {
                    alert(response.message);
                    $('#editModal').modal('hide');
                    fetchData();
                }, 'json');
            });

            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this expense?')) {
                    $.post('ajaxHandler.php', { url: 'delete', id: id }, function (response) {
                        alert(response.message);
                        fetchData();
                    }, 'json');
                }
            });
        });
    </script>
</body>

</html>
