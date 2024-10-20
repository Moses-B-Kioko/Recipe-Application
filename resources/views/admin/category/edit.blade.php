@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Edit Category</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('categories.index')}}" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
            <form action="" method="post" id="categoryForm" name="categoryForm" id="categoryForm"> <!-- Disable autofill for the entire form if needed -->
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                 placeholder="Name" value="{{$category->name}}"> <!-- Added autocomplete -->
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control"
                                 placeholder="Slug" value="{{$category->slug}}"> <!-- Added autocomplete -->
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" > <!-- Disable autocomplete for dropdown -->
                                    <option {{ ($category-> status == 1) ? 'selected' : ''}} value="1">Active</option>
                                    <option {{ ($category-> status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_id">Image</label>
                                <input type="hidden" id="image_id" name="image_id" value="" > <!-- Disable autocomplete for hidden field -->
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($category->image))
                            <div>
                            <img id="uploadedImage" width="250" src="{{ asset('uploads/category/thumb/'.$category->image) }}" alt="">
                        </div>
                        @endif	

                        </div>	
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Show on Home</label>
                                <select name="showHome" id="showHome" class="form-control" > <!-- Disable autocomplete for dropdown -->
                                    <option {{ ($category-> showHome == 'Yes') ? 'selected' : ''}}  value="Yes">Yes</option>
                                    <option {{ ($category-> showHome == 'No') ? 'selected' : ''}} value="No">No</option>
                                </select> 
                            </div>
                        </div>							
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    // Function to convert the name to a slug
    function generateSlug(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }

    // Automatically update the slug field when the name field is changed
    $('#name').on('keyup', function() {
        var name = $(this).val();
        var slug = generateSlug(name);
        $('#slug').val(slug);  // Assign the generated slug to the slug input field
    });

  $("#categoryForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled', true);
    $.ajax({
        url: '{{ route("categories.update", $category->id)}}',
        type: 'put',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response){
            $("button[type=submit]").prop('disabled', false);
            if(response["status"] == true){
                
                window.location.href="{{ route('categories.index')}}";

                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
            } else {

                if(response['errors'] == true) {
                    window.location.href="{{ route('categories.index')}}";
                }

                var errors = response['errors'];
                if(errors['name']) {
                    $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                } else {
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                }
                if(errors['slug']) {
                    $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
                } else {
                    $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                }
            }
        }, error: function(jqXHR, exception){
            console.log("Something went wrong");
        }
    })
  });

  Dropzone.autoDiscover = false;
  const dropzone = $("#image").dropzone({
    init: function() {
      this.on('addedfile', function(file) {
        if (this.files.length > 1) {
          this.removeFile(this.files[0]);
        }
      });
    },
    url: "{{ route('temp-images.create') }}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
      if (response.image_id) {
        $("#image_id").val(response.image_id);
          // Show the uploaded image
      $("#uploadedImage").attr('src', response.ImagePath).show();
      } else {
        console.log("No image_id received from the server.");
        alert("File uploaded but no image ID received.");
      }
    }
  });
</script>    
@endsection
