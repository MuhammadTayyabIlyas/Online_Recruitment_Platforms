<?php $__env->startSection('title', $blog->meta_title ?? $blog->title); ?>
<?php $__env->startSection('meta_description', $blog->meta_description ?? $blog->excerpt); ?>
<?php $__env->startSection('meta_keywords', $blog->meta_keywords); ?>

<?php $__env->startPush('head'); ?>
<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo e(route('blogs.show', $blog->slug)); ?>">
<meta property="og:title" content="<?php echo e($blog->meta_title ?? $blog->title); ?>">
<meta property="og:description" content="<?php echo e($blog->meta_description ?? $blog->excerpt); ?>">
<meta property="og:image" content="<?php echo e(Storage::url($blog->featured_image)); ?>">
<meta property="article:published_time" content="<?php echo e($blog->published_at->toIso8601String()); ?>">
<meta property="article:modified_time" content="<?php echo e($blog->updated_at->toIso8601String()); ?>">
<meta property="article:author" content="<?php echo e($blog->author->name); ?>">
<meta property="article:section" content="<?php echo e($blog->category->name); ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo e(route('blogs.show', $blog->slug)); ?>">
<meta name="twitter:title" content="<?php echo e($blog->meta_title ?? $blog->title); ?>">
<meta name="twitter:description" content="<?php echo e($blog->meta_description ?? $blog->excerpt); ?>">
<meta name="twitter:image" content="<?php echo e(Storage::url($blog->featured_image)); ?>">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo e(route('blogs.show', $blog->slug)); ?>">

<!-- Structured Data (JSON-LD) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "<?php echo e($blog->title); ?>",
  "description": "<?php echo e($blog->excerpt); ?>",
  "image": "<?php echo e(Storage::url($blog->featured_image)); ?>",
  "datePublished": "<?php echo e($blog->published_at->toIso8601String()); ?>",
  "dateModified": "<?php echo e($blog->updated_at->toIso8601String()); ?>",
  "author": {
    "@type": "<?php echo e($blog->author->user_type === 'educational_institution' ? 'Organization' : 'Person'); ?>",
    "name": "<?php echo e($blog->author->name); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "PlaceMeNet",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo e(asset('images/logo.png')); ?>"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php echo e(route('blogs.show', $blog->slug)); ?>"
  },
  "articleSection": "<?php echo e($blog->category->name); ?>",
  "keywords": "<?php echo e($blog->meta_keywords); ?>",
  "wordCount": <?php echo e(str_word_count(strip_tags($blog->content))); ?>,
  "timeRequired": "PT<?php echo e($blog->reading_time); ?>M"
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumbs -->
<div class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 py-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="<?php echo e(route('blogs.index')); ?>" class="ml-1 text-gray-600 hover:text-blue-600 transition">Blog</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="<?php echo e(route('blogs.category', $blog->category->slug)); ?>" class="ml-1 text-gray-600 hover:text-blue-600 transition"><?php echo e($blog->category->name); ?></a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-gray-500 truncate"><?php echo e(Str::limit($blog->title, 50)); ?></span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Article Header -->
        <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
            <!-- Featured Image -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blog->featured_image): ?>
                <div class="relative h-96 overflow-hidden">
                    <img src="<?php echo e(Storage::url($blog->featured_image)); ?>"
                         alt="<?php echo e($blog->featured_image_alt); ?>"
                         class="w-full h-full object-cover">

                    <!-- Category Badge Overlay -->
                    <div class="absolute top-6 left-6">
                        <a href="<?php echo e(route('blogs.category', $blog->category->slug)); ?>"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white bg-opacity-90 hover:bg-opacity-100 text-gray-900 shadow-lg transition">
                            <?php echo e($blog->category->icon); ?> <?php echo e($blog->category->name); ?>

                        </a>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blog->is_featured): ?>
                        <div class="absolute top-6 right-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-400 text-yellow-900 shadow-lg">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Featured
                            </span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Article Content -->
            <div class="p-8 lg:p-12">
                <!-- Title -->
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo e($blog->title); ?>

                </h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-8 pb-8 border-b border-gray-200">
                    <div class="flex items-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blog->author->profile_picture): ?>
                            <img src="<?php echo e(Storage::url($blog->author->profile_picture)); ?>"
                                 alt="<?php echo e($blog->author->name); ?>"
                                 class="w-10 h-10 rounded-full mr-3">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-3">
                                <?php echo e(substr($blog->author->name, 0, 1)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div>
                            <div class="font-medium text-gray-900"><?php echo e($blog->author->name); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e(ucfirst(str_replace('_', ' ', $blog->author->user_type))); ?></div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span><?php echo e($blog->published_at->format('F d, Y')); ?></span>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span><?php echo e(number_format($blog->views_count)); ?> views</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><?php echo e($blog->reading_time); ?> min read</span>
                    </div>
                </div>

                <!-- Excerpt -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blog->excerpt): ?>
                    <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-blue-500 rounded-r-lg">
                        <p class="text-xl text-gray-700 leading-relaxed font-medium"><?php echo e($blog->excerpt); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    <?php echo $blog->content; ?>

                </div>

                <!-- Tags/Keywords -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blog->meta_keywords): ?>
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = explode(',', $blog->meta_keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                                    #<?php echo e(trim($keyword)); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Share Buttons -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Share this article</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('blogs.show', $blog->slug))); ?>"
                           target="_blank"
                           rel="noopener"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>

                        <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(route('blogs.show', $blog->slug))); ?>&text=<?php echo e(urlencode($blog->title)); ?>"
                           target="_blank"
                           rel="noopener"
                           class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </a>

                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(urlencode(route('blogs.show', $blog->slug))); ?>"
                           target="_blank"
                           rel="noopener"
                           class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>

                        <button onclick="copyToClipboard()"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Author Bio -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg shadow-sm border border-blue-200 p-8 mb-8">
            <div class="flex items-start gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blog->author->profile_picture): ?>
                    <img src="<?php echo e(Storage::url($blog->author->profile_picture)); ?>"
                         alt="<?php echo e($blog->author->name); ?>"
                         class="w-24 h-24 rounded-full flex-shrink-0">
                <?php else: ?>
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold flex-shrink-0">
                        <?php echo e(substr($blog->author->name, 0, 1)); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">About <?php echo e($blog->author->name); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo e($blog->author->bio ?? 'Contributing ' . ucfirst(str_replace('_', ' ', $blog->author->user_type)) . ' on PlaceMeNet, sharing valuable insights and guidance.'); ?>

                    </p>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">
                            <strong><?php echo e($blog->author->blogs_count); ?></strong> <?php echo e(Str::plural('article', $blog->author->blogs_count)); ?> published
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Posts -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedBlogs->count() > 0): ?>
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Related Articles</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedBlog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('blogs.show', $relatedBlog->slug)); ?>" class="group">
                            <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden h-full flex flex-col">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedBlog->featured_image): ?>
                                    <div class="relative overflow-hidden h-48">
                                        <img src="<?php echo e(Storage::url($relatedBlog->featured_image)); ?>"
                                             alt="<?php echo e($relatedBlog->featured_image_alt); ?>"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="p-5 flex-1 flex flex-col">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-3 self-start">
                                        <?php echo e($relatedBlog->category->name); ?>

                                    </span>

                                    <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition flex-1">
                                        <?php echo e($relatedBlog->title); ?>

                                    </h3>

                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span><?php echo e($relatedBlog->reading_time); ?> min read</span>
                                    </div>
                                </div>
                            </article>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .prose {
        max-width: none;
    }
    .prose h1 {
        font-size: 2.25rem;
        font-weight: 800;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        color: #1f2937;
        line-height: 1.2;
    }
    .prose h2 {
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #374151;
        line-height: 1.3;
    }
    .prose h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.75rem;
        margin-bottom: 0.875rem;
        color: #4b5563;
        line-height: 1.4;
    }
    .prose p {
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        line-height: 1.8;
        color: #4b5563;
        font-size: 1.125rem;
    }
    .prose img {
        margin-top: 2rem;
        margin-bottom: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .prose ul, .prose ol {
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        padding-left: 1.75rem;
    }
    .prose li {
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
        line-height: 1.75;
        color: #4b5563;
    }
    .prose a {
        color: #3b82f6;
        text-decoration: underline;
        font-weight: 500;
    }
    .prose a:hover {
        color: #2563eb;
    }
    .prose strong {
        font-weight: 700;
        color: #1f2937;
    }
    .prose blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1.5rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        font-style: italic;
        color: #6b7280;
        margin-top: 2rem;
        margin-bottom: 2rem;
        background: #f9fafb;
        border-radius: 0.25rem;
    }
    .prose code {
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.9em;
        color: #1f2937;
    }
    .prose pre {
        background: #1f2937;
        color: #f3f4f6;
        padding: 1.25rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .prose pre code {
        background: transparent;
        padding: 0;
        color: inherit;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            alert('Link copied to clipboard!');
        }, function() {
            alert('Failed to copy link');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/blogs/show.blade.php ENDPATH**/ ?>