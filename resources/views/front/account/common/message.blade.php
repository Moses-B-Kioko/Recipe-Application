<!-- Check if there is an 'error' message in the session. -->
@if (Session::has('error'))
    <!-- If there is an error message, display an alert box with a danger (red) styling. -->
    <div class="alert alert-danger alert-dismissible fade show">
        <!-- Button to close the alert. -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <!-- The heading of the alert box with a ban icon indicating an error. -->
        <h4><i class="icon fas fa-ban"></i> Error!</h4>   
        <!-- Display the error message stored in the session. -->
        {{ Session::get('error') }}
    </div>
@endif

<!-- Check if there is a 'success' message in the session. -->
@if (Session::has('success'))
    <!-- If there is a success message, display an alert box with a success (green) styling. -->
    <div class="alert alert-success alert-dismissible fade show">
        <!-- Button to close the alert. -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <!-- The heading of the alert box with a check icon indicating success. -->
        <h4><i class="icon fas fa-check"></i> Success!</h4> 
        <!-- Display the success message stored in the session. -->
        {{ Session::get('success') }}
    </div>
@endif
