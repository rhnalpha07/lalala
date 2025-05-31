<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Artist Name</label>
        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('name', $artist->name ?? '') }}" required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
        <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('bio', $artist->bio ?? '') }}</textarea>
        @error('bio')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
        <input type="text" name="genre" id="genre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('genre', $artist->genre ?? '') }}">
        @error('genre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="gradient_start_color" class="block text-sm font-medium text-gray-700">Gradient Start Color</label>
            <div class="mt-1 flex items-center">
                <input type="color" name="gradient_start_color" id="gradient_start_color" class="h-10 w-20 p-0 border-gray-300" value="{{ old('gradient_start_color', $artist->gradient_start_color ?? '#e11d48') }}">
                <input type="text" value="{{ old('gradient_start_color', $artist->gradient_start_color ?? '#e11d48') }}" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="gradient_start_color_text" oninput="document.getElementById('gradient_start_color').value = this.value">
            </div>
            @error('gradient_start_color')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="gradient_end_color" class="block text-sm font-medium text-gray-700">Gradient End Color</label>
            <div class="mt-1 flex items-center">
                <input type="color" name="gradient_end_color" id="gradient_end_color" class="h-10 w-20 p-0 border-gray-300" value="{{ old('gradient_end_color', $artist->gradient_end_color ?? '#7e22ce') }}">
                <input type="text" value="{{ old('gradient_end_color', $artist->gradient_end_color ?? '#7e22ce') }}" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="gradient_end_color_text" oninput="document.getElementById('gradient_end_color').value = this.value">
            </div>
            @error('gradient_end_color')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Preview Gradient</label>
        <div id="gradient_preview" class="mt-1 h-20 w-full rounded-md" style="background-image: linear-gradient(to right, {{ old('gradient_start_color', $artist->gradient_start_color ?? '#e11d48') }}, {{ old('gradient_end_color', $artist->gradient_end_color ?? '#7e22ce') }});"></div>
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Artist Image</label>
        <div class="mt-1 flex items-center">
            @if(isset($artist) && $artist->image)
                <div class="mr-4">
                    <img src="{{ Storage::url($artist->image) }}" alt="Current artist image" class="h-20 w-20 object-cover rounded">
                </div>
            @endif
            <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
        </div>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startColorInput = document.getElementById('gradient_start_color');
    const endColorInput = document.getElementById('gradient_end_color');
    const startColorText = document.getElementById('gradient_start_color_text');
    const endColorText = document.getElementById('gradient_end_color_text');
    const preview = document.getElementById('gradient_preview');
    
    function updateGradient() {
        preview.style.backgroundImage = `linear-gradient(to right, ${startColorInput.value}, ${endColorInput.value})`;
        startColorText.value = startColorInput.value;
        endColorText.value = endColorInput.value;
    }
    
    startColorInput.addEventListener('input', updateGradient);
    endColorInput.addEventListener('input', updateGradient);
    
    startColorText.addEventListener('input', function() {
        startColorInput.value = this.value;
        updateGradient();
    });
    
    endColorText.addEventListener('input', function() {
        endColorInput.value = this.value;
        updateGradient();
    });
});
</script> 