<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Search Bar -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Find Your Dream Job</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Keyword Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="Search by job title, company, or keywords...">
                </div>

                <!-- Location Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="location" type="text" 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="City, state, or remote">
                </div>

                <!-- Sort By -->
                <div>
                    <select wire:model.live="sort" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="latest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="salary_high">Highest Salary</option>
                        <option value="salary_low">Lowest Salary</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Filters Sidebar -->
            <div class="w-full lg:w-1/4 space-y-6">
                <!-- Active Filters -->
                @if($category || $jobType || $employmentType || $experience || $isRemote || $minSalary)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">Active Filters</h3>
                        <button wire:click="clearFilters" class="text-xs text-red-600 hover:text-red-800 font-medium">Clear All</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($isRemote)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Remote Only
                                <button wire:click="$set('isRemote', false)" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                            </span>
                        @endif
                        <!-- Add other active filter tags here if needed -->
                    </div>
                </div>
                @endif

                <!-- Job Type Filter -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 mb-4">Job Type</h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectJobType('')">
                            <input type="radio" name="jobType" value="" {{ $jobType === '' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm {{ empty($jobType) ? 'text-gray-900 font-semibold' : 'text-gray-600' }}">All Types</span>
                        </label>
                        @foreach($jobTypes as $type)
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectJobType('{{ $type->id }}')">
                            <input type="radio" name="jobType" value="{{ $type->id }}" {{ $jobType == $type->id ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm text-gray-600">{{ $type->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 mb-4">Category</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded sticky top-0 bg-white z-10" wire:click="selectCategory('')">
                            <input type="radio" name="category" value="" {{ $category === '' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm {{ empty($category) ? 'text-gray-900 font-semibold' : 'text-gray-600' }}">All Categories</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectCategory('{{ $cat->id }}')">
                            <input type="radio" name="category" value="{{ $cat->id }}" {{ $category == $cat->id ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm text-gray-600">{{ $cat->name }} <span class="text-xs text-gray-400">({{ $cat->jobs_count }})</span></span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-900 mb-4">Experience Level</h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectExperience('')">
                            <input type="radio" name="experience" value="" {{ $experience === '' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm {{ empty($experience) ? 'text-gray-900 font-semibold' : 'text-gray-600' }}">All Levels</span>
                        </label>
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectExperience('entry')">
                            <input type="radio" name="experience" value="entry" {{ $experience === 'entry' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm text-gray-600">Entry Level</span>
                        </label>
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectExperience('mid')">
                            <input type="radio" name="experience" value="mid" {{ $experience === 'mid' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm text-gray-600">Mid Level</span>
                        </label>
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectExperience('senior')">
                            <input type="radio" name="experience" value="senior" {{ $experience === 'senior' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm text-gray-600">Senior Level</span>
                        </label>
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded" wire:click="selectExperience('lead')">
                            <input type="radio" name="experience" value="lead" {{ $experience === 'lead' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" readonly>
                            <span class="ml-2 text-sm text-gray-600">Lead / Manager</span>
                        </label>
                    </div>
                </div>

                <!-- Remote Only Toggle -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-900 text-sm">Remote Only</span>
                        <button wire:click="$toggle('isRemote')" 
                                type="button" 
                                class="{{ $isRemote ? 'bg-blue-600' : 'bg-gray-200' }} relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                                role="switch" 
                                aria-checked="{{ $isRemote ? 'true' : 'false' }}">
                            <span class="{{ $isRemote ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listings (Modern Cards) -->
            <div class="w-full lg:w-3/4">
                
                <!-- Loading State -->
                <div wire:loading class="w-full mb-6">
                    <div class="animate-pulse flex space-x-4 p-4 bg-white rounded-xl">
                        <div class="rounded-full bg-gray-200 h-12 w-12"></div>
                        <div class="flex-1 space-y-4 py-1">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm text-gray-600">Showing <span class="font-bold text-gray-900">{{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }}</span> of <span class="font-bold text-gray-900">{{ $jobs->total() }}</span> jobs</p>
                </div>

                <div class="space-y-4">
                    @forelse($jobs as $job)
                    <div class="group relative bg-white rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="flex flex-col sm:flex-row gap-6">
                            
                            <!-- Company Logo -->
                            <div class="flex-shrink-0">
                                @if($job->company && $job->company->logo)
                                    <img class="h-16 w-16 rounded-lg object-cover bg-white border border-gray-100" src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-100">
                                        {{ substr($job->company->company_name ?? 'C', 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate pr-4">
                                        <a href="{{ route('jobs.show', $job) }}">
                                            <span class="absolute inset-0"></span>
                                            {{ $job->title }}
                                        </a>
                                    </h2>
                                    @if($job->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Featured
                                        </span>
                                    @endif
                                    @if($job->created_at->diffInDays() < 3)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                            New
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <span class="font-medium text-gray-900">{{ $job->company->company_name ?? 'Confidential' }}</span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="flex items-center">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $job->city }}{{ $job->country ? ', ' . $job->country : '' }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $job->jobType->name ?? 'Full-time' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                        {{ $job->experience_level ? ucfirst($job->experience_level) . ' Level' : 'Experience N/A' }}
                                    </span>
                                    @if($job->min_salary)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        ${{ number_format($job->min_salary) }} - ${{ number_format($job->max_salary) }}
                                    </span>
                                    @endif
                                    @if($job->is_remote)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        Remote
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Apply Button (Visible on Hover/Mobile) -->
                            <div class="hidden sm:flex flex-col justify-center items-end pl-4">
                                <span class="text-gray-400 text-xs mb-2">{{ $job->created_at->diffForHumans() }}</span>
                                <button class="bg-white text-blue-600 border border-blue-200 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors opacity-0 group-hover:opacity-100">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters to find what you're looking for.</p>
                        <div class="mt-6">
                            <button wire:click="clearFilters" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Clear All Filters
                            </button>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>

</div>