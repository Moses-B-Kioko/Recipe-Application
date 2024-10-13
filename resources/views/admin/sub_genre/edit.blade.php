@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Edit Sub Genre</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('sub-genre.index')}}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                    <form action="{{ route('sub-genre.update', $subGenre->id) }}" method="POST" name="subGenreForm" id="subGenreForm">
                            @csrf
                            @method('PUT') <!-- Since it's an update -->
                            <div class="card">
                                <div class="card-body">								
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name">Genre</label>
                                                <select name="genre" id="genre" class="form-control">
                                                    <option value="">Select a genre</option>
                                                    @if($categories->isNotEmpty())
                                                    @foreach ($categories as $category)
                                                    <option {{($subGenre->category_id == $category->id) ? 'selected': '' }} value="{{ $category->id}}">{{ $category->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $subGenre->name }}">	
                                                <p></p>
                                            </div>
                                        </div>	
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text"  name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $subGenre->slug }}">	
                                                <p></p>
                                            </div>
                                        </div>	
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                <option {{($subGenre->status == 1) ? 'selected': '' }} value="1">Active</option>
                                                <option {{($subGenre->status == 0) ? 'selected': '' }} value="0">Block</option>
                                                </select>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status">Show on Home</label>
                                            <select name="showHome" id="showHome" class="form-control" autocomplete="off"> <!-- Disable autocomplete for dropdown -->
                                                <option {{($subGenre->showHome == 'Yes') ? 'selected': '' }}  value="Yes">Yes</option>
                                                <option {{($subGenre->showHome == 'No') ? 'selected': '' }}  value="No">No</option>
                                            </select> 
                                        </div>
                                    </div>										
                                    </div>
                                </div>							
                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('sub-genre.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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

$("#subGenreForm").submit(function(event){
    event.preventDefault();

    var element = $("#subGenreForm");
    $("button[type=submit]").prop('disabled', true);
    $.ajax({
        url: '{{ route("sub-genre.update",$subGenre->id)}}',
        type: 'post',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response){
            $("button[type=submit]").prop('disabled', false);
            if(response["status"] == true){
                window.location.href="{{ route('sub-genre.index')}}";
                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                $("#genre").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");

            } else {

                if(response['notFound'] == true){
                    window.location.href="{{ route('sub-genre.index')}}";
                    return false;
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
                if(errors['genre']) {
                    $("#genre").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['genre']);
                } else {
                    $("#genre").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                }    
            }
        }, error: function(jqXHR, exception){
            console.log("Something went wrong");
        }
    })
  });
    $("#name").change(function(){
        element = $(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title: element.val()},
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response["status"] == true) {
                    $("#slug").val(response["slug"]);
                }
            }
        });
    });
</script>    
@endsection
