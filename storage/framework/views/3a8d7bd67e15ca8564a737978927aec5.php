<?php $__env->startSection('title', 'Move to Europe | Visas & Residency'); ?>
<?php $__env->startSection('meta_description', 'Compare European visa and residency options: Golden Visa, Passive Income, Digital Nomad, Startup, and Highly Skilled paths. Get a clear path, costs, and expert support.'); ?>

<?php $__env->startSection('content'); ?>
<div class="-my-6">
    
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-4">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                        Residency made predictable
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">
                        Move to Europe with a clear, compliant plan
                    </h1>
                    <p class="text-lg text-gray-700 mb-6">
                        We help investors, remote workers, founders, and skilled professionals pick the right pathway, prepare documents, and submit on time.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('contact')); ?>"
                           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-all">
                            Book a 15-min consult
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#pathways"
                           class="inline-flex items-center justify-center gap-2 border border-blue-200 text-blue-700 hover:bg-blue-50 font-semibold px-6 py-3 rounded-lg transition-all">
                            Explore pathways
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                    <ul class="mt-6 space-y-2 text-gray-700">
                        <li class="flex items-start gap-2"><span class="text-green-500">✔</span><span>Pathway match by profile, budget, and timeline.</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✔</span><span>Cost, taxes, and processing time shown upfront.</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✔</span><span>Application pack review to reduce refusals.</span></li>
                    </ul>
                </div>
                <div class="bg-white rounded-2xl shadow-xl border border-blue-50 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Top picks by profile</div>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">92% approval assisted</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-blue-50">
                            <p class="text-sm text-blue-700">Investors</p>
                            <p class="text-base font-semibold text-blue-900">Golden Visa, RBI</p>
                        </div>
                        <div class="p-3 rounded-xl bg-purple-50">
                            <p class="text-sm text-purple-700">Remote pros</p>
                            <p class="text-base font-semibold text-purple-900">Digital Nomad</p>
                        </div>
                        <div class="p-3 rounded-xl bg-green-50">
                            <p class="text-sm text-green-700">Founders</p>
                            <p class="text-base font-semibold text-green-900">Startup/Entrepreneur</p>
                        </div>
                        <div class="p-3 rounded-xl bg-amber-50">
                            <p class="text-sm text-amber-700">Skilled talent</p>
                            <p class="text-base font-semibold text-amber-900">Blue Card & work permits</p>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <p class="text-sm text-gray-600">Outcome</p>
                        <p class="text-base font-semibold text-gray-900">Residency card in hand, ready to relocate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="pathways" class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Choose the path that fits you</h2>
                    <p class="text-gray-700">We compare eligibility, budget, and processing time before you commit.</p>
                </div>
                <a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center gap-2 text-blue-700 font-semibold hover:text-blue-900">
                    Ask for a tailored recommendation
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                    $pathways = [
                        ['flag' => '🇵🇹', 'title' => 'Golden / RBI', 'who' => 'Investors seeking residency via capital', 'cost' => '€250k–€500k+', 'time' => '4–8 months', 'countries' => 'Portugal, Spain, Greece, Italy, Malta'],
                        ['flag' => '💻', 'title' => 'Digital Nomad', 'who' => 'Remote employees and freelancers', 'cost' => '€0 real estate required', 'time' => '4–10 weeks', 'countries' => 'Portugal, Spain, Estonia, Croatia, Malta'],
                        ['flag' => '🏦', 'title' => 'Passive Income', 'who' => 'Financially independent, no local work', 'cost' => 'Proof of income + housing', 'time' => '6–10 weeks', 'countries' => 'Portugal (D7), Spain, Greece, France, Italy'],
                        ['flag' => '🚀', 'title' => 'Startup / Entrepreneur', 'who' => 'Founders with scalable ideas', 'cost' => 'Business plan + proof of funds', 'time' => '6–12 weeks', 'countries' => 'Portugal, Spain, France, Netherlands, Estonia'],
                        ['flag' => '🧑‍🎓', 'title' => 'Highly Skilled / Blue Card', 'who' => 'Professionals with EU job offers', 'cost' => 'Employment contract + salary thresholds', 'time' => '4–12 weeks', 'countries' => 'Germany, Netherlands, France, Sweden, Denmark'],
                        ['flag' => '🎓', 'title' => 'Study-to-Work', 'who' => 'Students aiming for post-study work', 'cost' => 'Tuition + living proof', 'time' => '4–8 weeks', 'countries' => 'Germany, Netherlands, Sweden, France, Ireland'],
                    ];
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pathways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div class="text-2xl"><?php echo e($path['flag']); ?></div>
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold"><?php echo e($path['time']); ?></span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900"><?php echo e($path['title']); ?></h3>
                        <p class="text-sm text-gray-700"><?php echo e($path['who']); ?></p>
                        <div class="text-sm text-gray-900 font-medium">Typical cost: <?php echo e($path['cost']); ?></div>
                        <p class="text-sm text-gray-600">Best fit: <?php echo e($path['countries']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">What working with us looks like</h2>
                <p class="text-gray-700">A structured, low-friction path to approval.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-6 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-4">1</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Eligibility & pathway</h3>
                    <p class="text-sm text-gray-700">Profile + budget review, then a shortlist with clear pros/cons and timelines.</p>
                </div>
                <div class="p-6 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-4">2</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Application pack</h3>
                    <p class="text-sm text-gray-700">Document checklist, financial evidence, forms, and booking your biometrics slot.</p>
                </div>
                <div class="p-6 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-4">3</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Submission & follow-up</h3>
                    <p class="text-sm text-gray-700">We review before submission, track status, and prep you for arrival.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <p class="text-sm uppercase tracking-wide text-blue-100 mb-2">Why people choose us</p>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Transparent guidance, faster submissions, fewer surprises</h2>
                    <ul class="space-y-2 text-blue-50">
                        <li class="flex items-start gap-2"><span class="text-white">•</span><span>Realistic timelines and costs before you start.</span></li>
                        <li class="flex items-start gap-2"><span class="text-white">•</span><span>Document review to reduce RFE/refusal risks.</span></li>
                        <li class="flex items-start gap-2"><span class="text-white">•</span><span>Coaching for interviews and consulate appointments.</span></li>
                    </ul>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-blue-100 text-sm">Client outcomes</p>
                            <p class="text-white text-xl font-bold">92% approval assisted</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold">Since 2022</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-white">
                        <div class="p-3 rounded-lg bg-white/10 border border-white/10">
                            <p class="font-semibold">Investors</p>
                            <p class="text-blue-100">Portugal, Spain, Greece</p>
                        </div>
                        <div class="p-3 rounded-lg bg-white/10 border border-white/10">
                            <p class="font-semibold">Remote workers</p>
                            <p class="text-blue-100">Portugal, Spain, Malta</p>
                        </div>
                        <div class="p-3 rounded-lg bg-white/10 border border-white/10">
                            <p class="font-semibold">Founders</p>
                            <p class="text-blue-100">France, Netherlands, Estonia</p>
                        </div>
                        <div class="p-3 rounded-lg bg-white/10 border border-white/10">
                            <p class="font-semibold">Skilled talent</p>
                            <p class="text-blue-100">Germany, Sweden, Denmark</p>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold px-6 py-3 rounded-lg hover:bg-blue-50 transition">
                            Speak with an expert
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center justify-center gap-2 border border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition">
                            Create free account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/visa/index.blade.php ENDPATH**/ ?>