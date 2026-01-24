<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
        <input type="text" name="title" value="{{ old('title', $program->title ?? '') }}" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        @error('title')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Educational Institution *</label>
        <select name="university_id" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select Educational Institution</option>
            @foreach($universities as $university)
                <option value="{{ $university->id }}" @selected(old('university_id', $program->university_id ?? '') == $university->id)>{{ $university->name }}</option>
            @endforeach
        </select>
        @error('university_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        <p class="text-xs text-gray-500 mt-1">Can’t find it? <a href="{{ route('institution.universities.create') }}" class="text-blue-600 hover:text-blue-800">Add new educational institution</a>.</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
        <select name="country_id" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" @selected(old('country_id', $program->country_id ?? '') == $country->id)>{{ $country->name }}</option>
            @endforeach
        </select>
        @error('country_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Degree *</label>
        <select name="degree_id" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select Degree</option>
            @foreach($degrees as $degree)
                <option value="{{ $degree->id }}" @selected(old('degree_id', $program->degree_id ?? '') == $degree->id)>{{ $degree->name }}</option>
            @endforeach
        </select>
        @error('degree_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
        <select name="subject_id" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected(old('subject_id', $program->subject_id ?? '') == $subject->id)>{{ $subject->name }}</option>
            @endforeach
        </select>
        @error('subject_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Language *</label>
        <input type="text" name="language" value="{{ old('language', $program->language ?? 'English') }}" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        @error('language')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Study Mode *</label>
        <select name="study_mode" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            @foreach(['On-campus','Online','Hybrid'] as $mode)
                <option value="{{ $mode }}" @selected(old('study_mode', $program->study_mode ?? '') == $mode)>{{ $mode }}</option>
            @endforeach
        </select>
        @error('study_mode')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tuition Fee (EUR)</label>
        <input type="number" name="tuition_fee" min="0" step="100" value="{{ old('tuition_fee', $program->tuition_fee ?? '') }}" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        @error('tuition_fee')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
        <input type="text" name="duration" value="{{ old('duration', $program->duration ?? '') }}" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. 2 years">
        @error('duration')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Intake</label>
        <input type="text" name="intake" value="{{ old('intake', $program->intake ?? '') }}" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. September 2025">
        @error('intake')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Application Deadline</label>
        <input type="date" name="application_deadline" value="{{ old('application_deadline', optional($program->application_deadline ?? null)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        @error('application_deadline')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Program URL (optional)</label>
        <input type="url" name="program_url" value="{{ old('program_url', $program->program_url ?? '') }}" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="https://">
        @error('program_url')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>
