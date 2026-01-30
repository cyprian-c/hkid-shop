{{-- resources/views/admin/products/create.blade.php --}}

@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<h1 style="margin-bottom: 2rem;">Add New Product</h1>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf

    <div class="form-grid">
        <div class="form-group">
            <label for="name">Product Name *</label>
            <input type="text" id="name" name="name" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">Selling Price (KSh) *</label>
            <input type="number" id="price" name="price" step="0.01" required value="{{ old('price') }}">
        </div>

        <div class="form-group">
            <label for="cost_price">Cost Price (KSh)</label>
            <input type="number" id="cost_price" name="cost_price" step="0.01" value="{{ old('cost_price') }}">
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity *</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required value="{{ old('stock_quantity', 0) }}">
        </div>

        <div class="form-group">
            <label for="sku">SKU (Leave blank for auto-generation)</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku') }}">
        </div>
    </div>

    <div class="form-group">
        <label for="description">Description *</label>
        <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label for="images">Product Images</label>
        <input type="file" id="images" name="images[]" accept="image/*" multiple>
        <small>You can select multiple images</small>
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label for="sizes">Sizes (comma-separated)</label>
            <input type="text" id="sizes_input" placeholder="e.g., S, M, L, XL">
            <input type="hidden" id="sizes" name="sizes">
        </div>

        <div class="form-group">
            <label for="colors">Colors (comma-separated)</label>
            <input type="text" id="colors_input" placeholder="e.g., Red, Blue, Black">
            <input type="hidden" id="colors" name="colors">
        </div>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            Featured Product
        </label>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Active
        </label>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success">Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        // Process sizes
        const sizesInput = document.getElementById('sizes_input').value;
        if (sizesInput) {
            const sizesArray = sizesInput.split(',').map(s => s.trim()).filter(s => s);
            document.getElementById('sizes').value = JSON.stringify(sizesArray);
        }

        // Process colors
        const colorsInput = document.getElementById('colors_input').value;
        if (colorsInput) {
            const colorsArray = colorsInput.split(',').map(c => c.trim()).filter(c => c);
            document.getElementById('colors').value = JSON.stringify(colorsArray);
        }
    });
</script>
@endsection