<?php
require 'connection.php';
if (isset($_POST['save_user'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $salt = '$2y$12$' . bin2hex(random_bytes(22));
    $hashedPassword = crypt($password, $salt);
    $result = mysqli_query($con, "SELECT id,email from users where email = '$email'");
    if (mysqli_fetch_array($result)) {
        echo json_encode(
            [
                'status' => 500,
                'icon' => 'error',
                'title' => 'Oops..',
                'text' => 'Email Already Taken!',
            ]
        );
        return;
    }
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'assets/images/';
        $timestamp = time();
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = $timestamp . '.' . $fileExtension;
        $uploadFile = $uploadDir . $newFileName;
        $imageFileType = strtolower($fileExtension);
        $validExtensions = ['jpg', 'png'];
        if (in_array($imageFileType, $validExtensions)) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo json_encode(
                    [
                        'status' => 500,
                        'icon' => 'error',
                        'title' => 'Oops..',
                        'text' => 'Something Went Wrong!',
                    ]
                );
                return;
            }
        } else {
            echo json_encode(
                [
                    'status' => 500,
                    'icon' => 'error',
                    'title' => 'Oops..',
                    'text' => 'Only image files (JPG, PNG) are allowed!',
                ]
            );
            return;
        }
    } else {
        echo json_encode(
            [
                'status' => 500,
                'icon' => 'error',
                'title' => 'Oops..',
                'text' => 'No file uploaded or there was an upload error!',
            ]
        );
        return;
    }
    $query = "INSERT INTO users (name,email,password,address,contact,gender,profile,company) VALUES ('$name','$email','$hashedPassword','$address','$contact','$gender','$newFileName','$company')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $res = [
            'status' => 200,
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'User Created Successfully!',
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'icon' => 'error',
            'title' => 'Oops..',
            'text' => 'User Not Created!',
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['update_User'])) {
    $id = mysqli_real_escape_string($con, $_POST['user_id']);
    $name = mysqli_real_escape_string($con, $_POST['edit_name']);
    $email = mysqli_real_escape_string($con, $_POST['edit_email']);
    $address = mysqli_real_escape_string($con, $_POST['edit_address']);
    $contact = mysqli_real_escape_string($con, $_POST['edit_contact']);
    $gender = mysqli_real_escape_string($con, $_POST['edit_gender']);
    $company = mysqli_real_escape_string($con, $_POST['edit_company']);
    $query = "SELECT password,profile from users where id = $id";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_array($result);
    if (isset($_POST['edit_password'])) {
        $password = mysqli_real_escape_string($con, $_POST['edit_password']);
        $salt = '$2y$12$' . bin2hex(random_bytes(22));
        $hashedPassword = crypt($password, $salt);
    } else {
        $hashedPassword = $data['password'];
    }
    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['name'] != "") {
        $uploadDir = 'assets/images/';
        $timestamp = time();
        $fileExtension = pathinfo($_FILES['edit_image']['name'], PATHINFO_EXTENSION);
        $newFileName = $timestamp . '.' . $fileExtension;
        $uploadFile = $uploadDir . $newFileName;
        $imageFileType = strtolower($fileExtension);
        $validExtensions = ['jpg', 'png'];
        if (in_array($imageFileType, $validExtensions)) {
            if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $uploadFile)) {
                unlink("assets/images/" . $data['profile']);
            } else {
                echo json_encode(
                    [
                        'status' => 500,
                        'icon' => 'error',
                        'title' => 'Oops..',
                        'text' => 'Something Went Wrong!',
                    ]
                );
                return;
            }
        } else {
            echo json_encode(
                [
                    'status' => 500,
                    'icon' => 'error',
                    'title' => 'Oops..',
                    'text' => 'Only image files (JPG, PNG) are allowed!',
                ]
            );
            return;
        }
    } else {
        $newFileName = $data['profile'];
    }

    $query = "UPDATE users SET name='$name', email='$email', password='$hashedPassword', address='$address', contact='$contact', gender='$gender',profile='$newFileName',company='$company' WHERE id=$id";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $res = [
            'status' => 200,
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'User Updated Successfully!'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'icon' => 'error',
            'title' => 'Oops..',
            'text' => 'USer Not Updated!'
        ];
        echo json_encode($res);
        return;
    }
}
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);
    $query = "SELECT * FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) == 1) {
        $user = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'USer Fetch Successfully by id!',
            'data' => $user
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'User Not Found!'
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $result = mysqli_query($con, "SELECT profile FROM users WHERE id = '$user_id'");
    $data = mysqli_fetch_array($result);
    if ($data) {
        $profile_image = $data['profile'];
        if ($profile_image && file_exists("assets/images/" . $profile_image)) {
            unlink("assets/images/" . $profile_image);
        }
        $query = mysqli_query($con, "DELETE FROM users WHERE id = '$user_id'");
        if ($query) {
            $res = [
                'status' => 200,
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'User Deleted Successfully!'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 500,
                'icon' => 'error',
                'title' => 'Oops..',
                'text' => 'Something Went Wrong!'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $res = [
            'status' => 500,
            'icon' => 'error',
            'title' => 'Oops..',
            'text' => 'User Not Found!'
        ];
        echo json_encode($res);
        return;
    }
}
