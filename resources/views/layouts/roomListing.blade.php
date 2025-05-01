@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Create a New Listing</h2>

    <div class="card shadow-sm p-4">
        <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Listing Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Enter listing title" value="{{ old('title') }}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                    <option value="">Select Category</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="bedsitter">Bedsitter</option>
                    <option value="one-bedroom">One-Bedroom</option>
                    <option value="two-bedroom">Two-Bedroom</option>
                </select>
                @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Describe the property">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (Ksh)</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Enter price" value="{{ old('price') }}">
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Location -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="county" class="form-label">County</label>
                    <input type="text" class="form-control @error('county') is-invalid @enderror" id="county" name="county" placeholder="Enter county" value="{{ old('county') }}">
                    @error('county')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="estate" class="form-label">Estate</label>
                    <input type="text" class="form-control @error('estate') is-invalid @enderror" id="estate" name="estate" placeholder="Enter estate" value="{{ old('estate') }}">
                    @error('estate')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="location" class="form-label">Google Map Location (Optional)</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Paste Google Maps link">
                </div>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="images" class="form-label">Upload Images</label>
                <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="image-preview" class="mt-2 d-flex flex-wrap"></div>
            </div>

            <!-- Video URL -->
            <div class="mb-3">
                <label for="video_url" class="form-label">Video URL (Optional)</label>
                <input type="url" class="form-control" id="video_url" name="video_url" placeholder="Paste YouTube or other video link">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Submit Listing</button>
        </form>
    </div>
</div>

<!-- Preview Selected Images -->
<script>
    document.getElementById('images').addEventListener('change', function(event) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'm-2');
                img.style.height = "100px";
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

@endsection
