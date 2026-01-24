@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp
<div>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="inline-flex rounded-full bg-blue-50 text-blue-700 px-4 py-1 text-xs font-semibold uppercase tracking-wider">Explore & Apply</div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <span class="font-semibold">Tabs:</span>
                        <a href="{{ route('jobs.index') }}" class="px-3 py-1 rounded-full border border-transparent bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Jobs</a>
                        <a href="{{ route('study-programs.index') }}" class="px-3 py-1 rounded-full border border-blue-200 bg-blue-50 text-blue-700 font-semibold">Study Programs</a>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Study Programs</h1>
                    <p class="mt-2 text-sm text-gray-600">Search, filter, and compare global admission programs by country, degree, subject, tuition, language, and study mode.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @auth
            @if(auth()->user()->hasRole('educational_institution'))
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Educational Institution Mode</p>
                        <p class="text-sm text-blue-700">Publish or manage your programs directly from here.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('institution.programs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">Add Program</a>
                        <a href="{{ route('institution.programs.index') }}" class="px-4 py-2 bg-white border border-blue-200 text-blue-700 rounded-md hover:bg-blue-50 text-sm">My Programs</a>
                    </div>
                </div>
            @endif
        @else
            <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-gray-900">Are you an educational institution?</p>
                    <p class="text-sm text-gray-600">Create an institution account to publish your study programs.</p>
                </div>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">Register as Institution</a>
            </div>
        @endauth
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full lg:w-1/4 space-y-6">
                <form wire:submit.prevent="applyFilters" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 sticky top-24 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Filters</h3>
                        <span class="text-xs text-gray-500">Live updates</span>
                    </div>
                    
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keyword</label>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Program or University" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Country (required) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                        <select wire:model.live="selectedCountry" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="" disabled>Select a country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedCountry')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Degree -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Degree Level</label>
                        <select wire:model.live="selectedDegree" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Degrees</option>
                            @foreach($degrees as $degree)
                                <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject / Field</label>
                        <div class="mb-2">
                            <input wire:model.live.debounce.300ms="subjectSearch" type="text" placeholder="Search subject..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <select wire:model.live="selectedSubject" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Language -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Language of Instruction</label>
                        <select wire:model.live="selectedLanguage" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Any Language</option>
                            @foreach($languages as $language)
                                <option value="{{ $language }}">{{ $language }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Study Mode -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Study Mode</label>
                        <select wire:model.live="selectedStudyMode" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Any Mode</option>
                            <option value="On-campus">On-campus</option>
                            <option value="Online">Online</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>

                    <!-- Intake -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Intake / Start Date (optional)</label>
                        <input wire:model.live.debounce.300ms="selectedIntake" type="text" placeholder="e.g. September 2025" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Tuition Fee Range -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Fee (€)</label>
                            <input wire:model.live.debounce.300ms="minFee" type="number" min="0" step="100" placeholder="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('minFee')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Fee (€)</label>
                            <input wire:model.live.debounce.300ms="maxFee" type="number" min="0" step="100" placeholder="20000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('maxFee')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Currency: EUR. Tuition filters use secure whereBetween queries.</p>

                    <!-- Actions -->
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm font-semibold">
                            Search
                        </button>
                        <button type="button" wire:click="resetFilters" class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors text-sm font-medium">
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results List -->
            <div class="w-full lg:w-3/4">
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-sm text-gray-500">Showing <span class="font-medium text-gray-900">{{ $programs->total() }}</span> programs</p>
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-600">Sort by fee</label>
                        <select wire:model.live="feeSort" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">Featured / Latest</option>
                            <option value="low_high">Low → High</option>
                            <option value="high_low">High → Low</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($programs as $program)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow {{ $program->is_featured ? 'ring-2 ring-yellow-400 bg-gradient-to-r from-yellow-50 to-white' : '' }}">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="flex items-start gap-4 flex-1">
                                    @if($program->university->logo)
                                        <div class="flex-shrink-0">
                                            <img src="{{ Storage::url($program->university->logo) }}" alt="{{ $program->university->name }}" class="w-16 h-16 object-contain rounded-lg border border-gray-200">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $program->degree->name }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                                {{ $program->subject->name }}
                                            </span>
                                            @if($program->is_featured)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900">
                                            <a href="{{ route('study-programs.show', [Str::slug($program->country->name), $program->slug]) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $program->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 font-medium">{{ $program->university->name }}</p>
                                        <div class="flex items-center text-sm text-gray-500 mt-2 gap-4 flex-wrap">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $program->country->name }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $program->duration }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @if($program->tuition_fee)
                                                    €{{ number_format($program->tuition_fee, 0) }} / year
                                                @else
                                                    Contact for fee
                                                @endif
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                                {{ $program->language }}
                                            </span>
                                            @if($program->study_mode)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                    {{ $program->study_mode }}
                                                </span>
                                            @endif
                                            @if($program->intake)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    Intake: {{ $program->intake }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 flex flex-col gap-2 w-full md:w-auto">
                                    <a href="{{ route('study-programs.show', [Str::slug($program->country->name), $program->slug]) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap">
                                        View Details
                                    </a>
                                    @if($program->program_url)
                                        <a href="{{ $program->program_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex justify-center items-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap">
                                            Apply (external)
                                        </a>
                                    @else
                                        <button disabled class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-md shadow-sm text-gray-400 bg-gray-50 cursor-not-allowed whitespace-nowrap">
                                            Apply (closed)
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No programs found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search terms.</p>
                            <div class="mt-6">
                                <button wire:click="resetFilters" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Reset Filters
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
