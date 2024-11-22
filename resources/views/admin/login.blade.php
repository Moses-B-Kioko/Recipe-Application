<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sets the character encoding for the document to UTF-8, ensuring proper display of text. -->
    <meta charset="utf-8">
    <!-- Ensures the page is responsive and scales properly on different devices, especially mobile. -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The title of the page that appears in the browser tab. -->
    <title>Laravel Shop :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <!-- Links to a Google Font (Source Sans Pro) for styling text across the page. -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!-- Links to the Font Awesome library for icons. The assets are stored locally in the 'admin-assets/plugins/fontawesome-free/css' directory. -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <!-- Links to the main stylesheet for the admin panel's theme, stored locally in the 'admin-assets/css' directory. -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css')}}">
    <!-- Links to a custom stylesheet for additional styles specific to this application. -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
    <!-- The main container for the login box. -->
    <div class="login-box">
        <!-- Includes any messages (e.g., error or success messages) from the 'admin.message' view file. -->
        @include('admin.message')
        <div class="card card-outline card-primary">
            <!-- The header of the login card, centered with the title "Administrative Panel". -->
            <div class="card-header text-center">
                <a href="#" class="h3">Administrative Panel</a>
            </div>
            <!-- The body of the login card. -->
            <div class="card-body">
                <!-- A message prompting the user to sign in. -->
                <p class="login-box-msg">Sign in to start your session</p>
                <!-- The login form that sends a POST request to the 'admin.authenticate' route for authentication. -->
                <form action="{{ route('admin.authenticate')}}" method="post">
                    <!-- Generates a CSRF token for security, protecting against cross-site request forgery attacks. -->
                    @csrf
                    <!-- Email input field with error handling. -->
                    <div class="input-group mb-3">
                        <!-- Preserves the user's email input if validation fails. -->
                        <input type="email" value="{{ old('email')}}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                        <!-- An icon appended to the email input field for visual enhancement. -->
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Displays validation errors for the email field if they occur. -->
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                    <!-- Password input field with error handling. -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password">
                        <!-- An icon appended to the password input field for visual enhancement. -->
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <!-- Displays validation errors for the password field if they occur. -->
                        @error('password')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Row for the submit button. -->
                    <div class="row">
                        <!-- The login button, placed within a grid system for layout control. -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
                <!-- A link for users who forgot their password, leading them to the password recovery page. -->
                <p class="mb-1 mt-3">
                    <a href="{{ route('admin.forgotPassword') }}">I forgot my password</a>
                </p>
            </div>
            <!-- End of the card body. -->
        </div>
        <!-- End of the card component. -->
    </div>
    <!-- End of the login box. -->
    
    <!-- jQuery -->
    <!-- Links to the jQuery library, stored locally in the 'admin-assets/plugins/jquery' directory. -->
    <script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <!-- Links to the Bootstrap 4 JS library, stored locally in the 'admin-assets/plugins/bootstrap/js' directory, for responsive design and UI components. -->
    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <!-- Links to the AdminLTE JS file, stored locally in the 'admin-assets/js' directory, which is the main JavaScript file for the admin panel's functionality. -->
    <script src="{{ asset('admin-assets/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- Links to the AdminLTE demo JS file. This is commented out as it's only for demonstration purposes. -->
    <!--<script src="js/demo.js"></script>-->
</body>
</html>
