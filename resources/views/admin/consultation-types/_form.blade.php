@php $type = $type ?? null; @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $type?->name) }}" required
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               placeholder="e.g. Career Coaching Session">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  placeholder="Describe what this consultation covers...">{{ old('description', $type?->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes) *</label>
        <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', $type?->duration_minutes ?? 30) }}" required min="10" max="480"
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('duration_minutes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="buffer_minutes" class="block text-sm font-medium text-gray-700 mb-1">Buffer Between Slots (minutes)</label>
        <input type="number" name="buffer_minutes" id="buffer_minutes" value="{{ old('buffer_minutes', $type?->buffer_minutes ?? 10) }}" min="0" max="60"
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('buffer_minutes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (EUR) *</label>
        <input type="number" name="price" id="price" value="{{ old('price', $type?->price ?? 0) }}" required min="0" step="0.01"
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="max_advance_days" class="block text-sm font-medium text-gray-700 mb-1">Max Advance Booking (days)</label>
        <input type="number" name="max_advance_days" id="max_advance_days" value="{{ old('max_advance_days', $type?->max_advance_days ?? 60) }}" min="1" max="365"
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('max_advance_days') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
        <select name="color" id="color" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @foreach(['blue', 'indigo', 'green', 'red', 'yellow', 'purple', 'pink', 'orange', 'teal', 'cyan'] as $color)
                <option value="{{ $color }}" {{ old('color', $type?->color ?? 'blue') === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $type?->sort_order ?? 0) }}" min="0"
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>

    <div class="md:col-span-2 space-y-4">
        <div class="flex items-center">
            <input type="hidden" name="is_free" value="0">
            <input type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free', $type?->is_free ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <label for="is_free" class="ml-2 text-sm text-gray-700">Free Consultation (no payment required)</label>
        </div>

        <div class="flex items-center">
            <input type="hidden" name="allows_online" value="0">
            <input type="checkbox" name="allows_online" id="allows_online" value="1" {{ old('allows_online', $type?->allows_online ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <label for="allows_online" class="ml-2 text-sm text-gray-700">Allow Online Meetings</label>
        </div>

        <div class="flex items-center">
            <input type="hidden" name="allows_in_person" value="0">
            <input type="checkbox" name="allows_in_person" id="allows_in_person" value="1" {{ old('allows_in_person', $type?->allows_in_person ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <label for="allows_in_person" class="ml-2 text-sm text-gray-700">Allow In-Person Meetings</label>
        </div>
    </div>
</div>
