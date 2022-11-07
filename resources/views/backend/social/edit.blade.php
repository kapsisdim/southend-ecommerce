@extends('backend.layouts.master')
@section('title','Admin | Social Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Social</h5>
    <div class="card-body">
      <form method="post" action="{{route('social.update',$social->id)}}">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$social->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputLink" class="col-form-label">Link <span class="text-danger">*</span></label>
        <input id="inputLink" type="text" name="link" placeholder="Enter link"  value="{{$social->link}}" class="form-control">
        @error('link')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputIcon" class="col-form-label">Icon <span class="text-danger">*</span></label>
        <input id="inputIcon" type="text" name="icon" placeholder="Enter icon"  value="{{$social->icon}}" class="form-control">
        @error('icon')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush
