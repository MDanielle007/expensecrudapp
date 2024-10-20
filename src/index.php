<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Simple Expense CRUD APP</title>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="card">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center">
                    <a class="nav-link active btl" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">Login</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link btr" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                        aria-controls="pills-profile" aria-selected="false">Signup</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <form id="loginForm">
                        <div class="form px-4 pt-5">
                            <input id="loginEmail" type="text" name="" class="form-control"
                                placeholder="Email or Phone">
                            <input id="loginPassword" type="password" name="" class="form-control" placeholder="Password">
                            <button type="submit" class="btn btn-dark btn-block">Login</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form id="signUpForm">
                        <div class="form px-4">
                            <input id="signUpUsername" type="text" name="" class="form-control" placeholder="Username">
                            <input id="signUpEmail" type="text" name="" class="form-control" placeholder="Email">
                            <input id="signUpPassword" type="text" name="" class="form-control" placeholder="Password">
                            <button type="submit" class="btn btn-dark btn-block">Signup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(() => {
            $('#loginForm').submit((e) => {
                e.preventDefault();
                // Perform login logic here
                const email = $('#loginEmail').val();
                const password = $('#loginPassword').val();

                $.ajax({
                    url: 'ajaxHandler.php',
                    type: 'POST',
                    data: {
                        url: 'auth',
                        email: email,
                        password: password
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'success') {
                            alert('Login successful');
                            window.location.href = 'expensesmgmt.php';
                        } else {
                            alert('Login failed');
                            $('#loginEmail').val('');
                            $('#loginPassword').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#signUpForm').submit((e) => {
                e.preventDefault();
                // Perform signup logic here
                const username = $('#signUpUsername').val();
                const email = $('#signUpEmail').val();
                const password = $('#signUpPassword').val();

                $.ajax({
                    url: 'ajaxHandler.php',
                    type: 'POST',
                    data: {
                        url: 'signup',
                        username: username,
                        email: email,
                        password: password
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'failed') {
                            alert(data.message);
                        }

                        if (data.status =='success') {
                            alert('Signup successful');
                            sessionStorage.setItem('')
                            $('#signUpUsername').val('');
                            $('#signUpEmail').val('');
                            $('#signUpPassword').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>