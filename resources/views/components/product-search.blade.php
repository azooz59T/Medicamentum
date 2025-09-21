<div class="row mb-4">
    <div class="col-md-12">
        <form method="GET" action="{{ $action }}" class="d-flex gap-2">
            <!-- Search Bar -->
            <div class="flex-grow-1">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Search products by name..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </div>
            
            <!-- Price Sort Button -->
            <div>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>
                </select>
            </div>
            
            <!-- Clear Button (only show if there are filters) -->
            @if(request('search') || request('sort'))
                <div>
                    <a href="{{ $action }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            @endif
        </form>
    </div>
</div>