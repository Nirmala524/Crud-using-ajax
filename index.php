<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>PHP Ajax CRUD</title>
</head>

<body>
    <div class="modal fade" id="AddModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="userAdd" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact">Contact</label>
                            <input type="text" id="contact" name="contact" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image">Profile Picture</label>
                            <input type="file" name="image" id="image" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Company</label>
                            <br>
                            <div>
                                <label><input type="checkbox" name="company[]" value="Company A"> Company A</label><br>
                                <label><input type="checkbox" name="company[]" value="Company B"> Company B</label><br>
                                <label><input type="checkbox" name="company[]" value="Company C"> Company C</label><br>
                                <label><input type="checkbox" name="company[]" value="Company D"> Company D</label><br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="userUpdate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="user_id">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="edit_name" name="edit_name" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="edit_email" name="edit_email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="edit_password" name="edit_password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea name="edit_address" id="edit_address" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact">Contact</label>
                            <input type="text" id="edit_contact" name="edit_contact" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="gender">Gender</label>
                            <select id="edit_gender" name="edit_gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image">Profile Picture</label>
                            <input type="file" name="edit_image" id="edit_image" class="form-control" />
                            <div></div>
                            <img style="width: 100px; margin-top: 5px;" id="edit_image_view" src="" alt="profile image">
                        </div>
                        <div class="mb-3">
                            <label>Company</label>
                            <br>
                            <div>
                                <label><input type="checkbox" name="edit_company[]" value="Company A"> Company A</label><br>
                                <label><input type="checkbox" name="edit_company[]" value="Company B"> Company B</label><br>
                                <label><input type="checkbox" name="edit_company[]" value="Company C"> Company C</label><br>
                                <label><input type="checkbox" name="edit_company[]" value="Company D"> Company D</label><br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PHP Ajax CRUD
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddModal">
                                Add User
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Gender</th>
                                    <th>Profile</th>
                                    <th>Company</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require 'connection.php';
                                $query = "SELECT * FROM users";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $user) {
                                        $companies =  json_decode($user['company']);
                                        $company_names = implode(", ", $companies);
                                ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= $user['name'] ?></td>
                                            <td><?= $user['email'] ?></td>
                                            <td><?= $user['address'] ?></td>
                                            <td><?= $user['contact'] ?></td>
                                            <td><?= $user['gender'] ?></td>
                                            <td><img style="width: 100px;" src="assets/images/<?= $user['profile'] ?>" alt=""></td>
                                            <td><?= $company_names  ?></td>
                                            <td>
                                                <button type="button" value="<?= $user['id']; ?>" class="editBtn btn btn-success btn-sm">Edit</button>
                                                <button type="button" value="<?= $user['id']; ?>" class="deleteBtn btn btn-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/sweetalert2@11.js"></script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod("pattern", function(value, element, param) {
                if (this.optional(element)) {
                    return true;
                }
                if (typeof param === "string") {
                    param = new RegExp("^(?:" + param + ")$");
                }
                return param.test(value);
            }, "Invalid format.");
            $.validator.addMethod('extension', function(value, element, param) {
                const fileName = element.value.toLowerCase();
                const extensions = param.split("|");
                const fileExtension = fileName.split('.').pop();
                return extensions.includes(fileExtension);
            }, 'Invalid file type.');
            $('#image').on('change', function() {
                $(this).valid();
            });
            $("#userAdd").validate({
                rules: {
                    name: {
                        required: true,
                        pattern: /^[A-Za-z\s]+$/,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 50
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
                    },
                    address: {
                        required: true,
                        maxlength: 250,
                        pattern: /^[a-zA-Z0-9\s,\.]*$/
                    },
                    contact: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    gender: {
                        required: true
                    },
                    image: {
                        required: true,
                        extension: "jpg|png",
                    },
                    "company[]": {
                        required: true,
                        minlength: 1
                    }
                },
                messages: {
                    name: {
                        required: "Name is required",
                        pattern: "Name can only contain letters and spaces",
                        maxlength: "Name must be less than 50 characters"
                    },
                    email: {
                        required: "Email is required",
                        email: "Please enter a valid email address",
                        maxlength: "E-mail must be less than 50 characters"
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be grater than 6 characters",
                        pattern: "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character",
                    },
                    address: {
                        required: "Address is required",
                        maxlength: "Address must be less than 250 characters",
                        pattern: "Address can only contain letters, numbers, spaces, commas, and periods."
                    },
                    contact: {
                        required: "Contact number is required",
                        digits: "Contact number can only contain digits",
                        minlength: "Contact number must be exactly 10 digits",
                        maxlength: "Contact number must be exactly 10 digits"
                    },
                    gender: {
                        required: "Gender is required"
                    },
                    image: {
                        required: "Profile picture is required",
                        extension: "Only image files (jpg, png) are allowed.",
                    },
                    "company[]": {
                        required: "Select at least one company"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    if (element.attr("name") == "company[]") {
                        error.insertBefore(element.closest('div'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                focusout: function() {
                    $(this).valid();
                },
                keyup: function() {
                    $(this).valid();
                },
            });

            $(document).on('submit', '#userAdd', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var selectedcompany = [];
                $("input[name='company[]']:checked").each(function() {
                    selectedcompany.push($(this).val());
                });
                formData.append("company", JSON.stringify(selectedcompany));
                formData.append("save_user", true);
                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            customMessage(res.icon, res.title, res.text);
                            $('#myTable').load(location.href + " #myTable");
                            $('#AddModal').modal('hide');
                            $('#userAdd')[0].reset();
                        } else if (res.status == 500) {
                            customMessage(res.icon, res.title, res.text);
                        }
                    }
                });
            });

            $(document).on('click', '.editBtn', function() {
                var user_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "code.php?user_id=" + user_id,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 404) {
                            customMessage(res.icon, res.title, res.text);
                        } else if (res.status == 200) {
                            $('#user_id').val(res.data.id);
                            $('#edit_name').val(res.data.name);
                            $('#edit_email').val(res.data.email);
                            $('#edit_address').val(res.data.address);
                            $('#edit_contact').val(res.data.contact);
                            $('#edit_gender').val(res.data.gender);
                            $('#edit_image_view').attr('src', 'assets/images/' + res.data.profile);
                            var selectedCompanies = res.data.company;
                            $('input[name="edit_company[]"]').each(function() {
                                if (selectedCompanies.includes($(this).val())) {
                                    $(this).prop('checked', true);
                                }
                            });
                            $('#EditModal').modal('show');
                        }
                    }
                });
            });
            $("#userUpdate").validate({
                rules: {
                    edit_name: {
                        required: true,
                        pattern: /^[A-Za-z\s]+$/,
                        maxlength: 50
                    },
                    edit_email: {
                        required: true,
                        email: true,
                        maxlength: 50
                    },
                    edit_password: {
                        required: false,
                        minlength: 6,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
                    },
                    edit_address: {
                        required: true,
                        maxlength: 250,
                        pattern: /^[a-zA-Z0-9\s,\.]*$/
                    },
                    edit_contact: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    edit_gender: {
                        required: true
                    },
                    "edit_company[]": {
                        required: true,
                        minlength: 1
                    }
                },
                messages: {
                    edit_name: {
                        required: "Name is required",
                        pattern: "Name can only contain letters and spaces",
                        maxlength: "Name must be less than 50 characters"
                    },
                    edit_email: {
                        required: "Email is required",
                        email: "Please enter a valid email address",
                        maxlength: "E-mail must be less than 50 characters"
                    },
                    edit_password: {
                        required: "Password is required",
                        minlength: "Password must be grater than 6 characters",
                        pattern: "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character",
                    },
                    edit_address: {
                        required: "Address is required",
                        maxlength: "Address must be less than 250 characters",
                        pattern: "Address can only contain letters, numbers, spaces, commas, and periods."
                    },
                    edit_contact: {
                        required: "Contact number is required",
                        digits: "Contact number can only contain digits",
                        minlength: "Contact number must be exactly 10 digits",
                        maxlength: "Contact number must be exactly 10 digits"
                    },
                    edit_gender: {
                        required: "Gender is required"
                    },
                    "edit_company[]": {
                        required: "Select at least one company"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    if (element.attr("name") == "edit_image") {
                        error.insertAfter(element.closest('div'));
                    }
                    if (element.attr("name") == "company[]") {
                        error.insertBefore(element.closest('div'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                focusout: function() {
                    $(this).valid();
                },
                keyup: function() {
                    $(this).valid();
                },
            });

            $(document).on('submit', '#userUpdate', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("update_User", true);
                formData.append("user_id", $("#user_id").val());
                var selectedcompany = [];
                $("input[name='edit_company[]']:checked").each(function() {
                    selectedcompany.push($(this).val());
                });
                formData.append("edit_company", JSON.stringify(selectedcompany));
                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            customMessage(res.icon, res.title, res.text);
                            $('#EditModal').modal('hide');
                            $('#userUpdate')[0].reset();
                            $('#myTable').load(location.href + " #myTable");
                        } else if (res.status == 500) {
                            customMessage(res.icon, res.title, res.text);
                        }
                    }
                });

            });

            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28A745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var user_id = $(this).val();
                        $.ajax({
                            type: "POST",
                            url: "code.php",
                            data: {
                                'delete_user': true,
                                'user_id': user_id
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    customMessage(res.icon, res.title, res.text);
                                } else {
                                    customMessage(res.icon, res.title, res.text);
                                    $('#myTable').load(location.href + " #myTable");
                                }
                            }
                        });
                    }
                });
            });

            function customMessage(icon = "", title = "", text = "", footer = "") {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                });
            }
        });
    </script>
</body>

</html>