<!-- Check if there is an 'error' message in the session. -->
@if (Session::has('error'))
    <!-- If there is an error message, display an alert box with a danger (red) styling. -->
    <div class="alert alert-danger alert-dismissible">
        <!-- Button to close the alert. -->
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <!-- The heading of the alert box with a ban icon indicating an error. -->
        <h5><i class="icon fas fa-ban"></i> Error!</h5>   
        <!-- Display the error message stored in the session. -->
        {{ Session::get('error') }}
    </div>
@endif

<!-- Check if there is a 'success' message in the session. -->
@if (Session::has('success'))
    <!-- If there is a success message, display an alert box with a success (green) styling. -->
    <div class="alert alert-success alert-dismissible">
        <!-- Button to close the alert. -->
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <!-- The heading of the alert box with a check icon indicating success. -->
        <h5><i class="icon fas fa-check"></i> Success!</h5> 
        <!-- Display the success message stored in the session. -->
        {{ Session::get('success') }}
    </div>
@endif
