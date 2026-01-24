<?php $__env->startSection('title', 'Edit Profile'); ?>

<!-- International Phone CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Profile</h1>
        <p class="text-gray-600">Update your personal information</p>
    </div>

    <form action="<?php echo e(route('jobseeker.profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Basic Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Email (read-only) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" value="<?php echo e($user->email); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" disabled>
                    <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
                </div>

                <!-- International Phone Number -->
                <div class="md:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="hidden" name="country_code" id="country_code" value="<?php echo e(old('country_code', $user->country_code)); ?>">
                    <p class="mt-1 text-xs text-gray-500">Select your country code and enter your phone number</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div id="phone-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    <div id="phone-valid" class="mt-1 text-sm text-green-600 hidden">✓ Valid phone number</div>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                           value="<?php echo e(old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d'))); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Passport Number -->
            <div class="mt-6">
                <label for="passport_number" class="block text-sm font-medium text-gray-700">Passport Number</label>
                <input type="text" name="passport_number" id="passport_number" value="<?php echo e(old('passport_number', $user->profile?->passport_number)); ?>"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['passport_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Bio -->
            <div class="mt-6">
                <label for="bio" class="block text-sm font-medium text-gray-700">Professional Summary</label>
                <textarea name="bio" id="bio" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Write a brief professional summary about yourself..."><?php echo e(old('bio', $user->profile?->bio)); ?></textarea>
                <p class="mt-1 text-xs text-gray-500">Max 1000 characters</p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Current Address -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Current Address</h2>

            <div class="space-y-6">
                <!-- Street Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                    <input type="text" name="address" id="address" value="<?php echo e(old('address', $user->profile?->address)); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="e.g., 123 Main Street, Apt 4B">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <?php
                            $locationParts = $user->profile?->location ? explode(', ', $user->profile->location) : [];
                            $city = $user->profile?->city ?? $locationParts[0] ?? '';
                            $oldCountry = $locationParts[1] ?? '';
                        ?>
                        <input type="text" name="city" id="city" value="<?php echo e(old('city', $city)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="e.g., New York, Karachi, London">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal/ZIP Code</label>
                        <input type="text" name="postal_code" id="postal_code" value="<?php echo e(old('postal_code', $user->profile?->postal_code)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="e.g., 10001, SW1A 1AA">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Country of Residence -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">Country of Residence *</label>
                        <select name="country" id="country"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Country</option>
                            <?php
                            $countriesData = config('countries_provinces');
                            $selectedCountryIso = old('country_iso', $user->profile?->country_iso);
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $countriesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($code); ?>" <?php echo e($selectedCountryIso == $code ? 'selected' : ''); ?>>
                                    <?php echo e($data['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <input type="hidden" name="country_iso" id="country_iso" value="<?php echo e($selectedCountryIso); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Province/State (Dynamic) -->
                    <div id="province-wrapper" class="<?php echo e(empty($selectedCountryIso) ? 'hidden' : ''); ?>">
                        <label for="province" class="block text-sm font-medium text-gray-700">
                            <span id="province-label">Province/State</span>
                        </label>
                        <select name="province" id="province"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Province/State</option>
                        </select>
                        <input type="hidden" name="province_state_code" id="province_state_code" value="<?php echo e(old('province_state_code', $user->profile?->province_state_code)); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Photo -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Profile Photo</h2>

            <div class="flex items-center space-x-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->avatar): ?>
                    <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-2xl font-medium text-gray-500"><?php echo e(substr($user->name, 0, 1)); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700">Upload new photo</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*"
                           class="mt-1 block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF up to 2MB</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="<?php echo e(route('jobseeker.profile.index')); ?>" class="text-gray-600 hover:text-gray-900">Cancel</a>
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Save Changes
            </button>
        </div>
    </form>
</div>

<!-- International Phone JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector("#phone");
    const countryCodeInput = document.querySelector("#country_code");
    const phoneError = document.querySelector("#phone-error");
    const phoneValid = document.querySelector("#phone-valid");
    const countrySelect = document.querySelector("#country");
    const countryIsoInput = document.querySelector("#country_iso");

    // Initialize intl-tel-input
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "<?php echo e($user->country_code ?? 'us'); ?>",
        preferredCountries: ['us', 'gb', 'pk', 'in', 'ae'],
        separateDialCode: true,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
    });

    // Update hidden country code field when country changes
    phoneInput.addEventListener('countrychange', function() {
        const countryData = iti.getSelectedCountryData();
        countryCodeInput.value = countryData.iso2.toUpperCase();
    });

    // Validate phone on input
    phoneInput.addEventListener('blur', function() {
        phoneError.classList.add('hidden');
        phoneValid.classList.add('hidden');

        if (phoneInput.value.trim()) {
            if (iti.isValidNumber()) {
                phoneValid.classList.remove('hidden');
                phoneInput.classList.remove('border-red-500');
                phoneInput.classList.add('border-green-500');
            } else {
                phoneError.textContent = 'Please enter a valid phone number for the selected country';
                phoneError.classList.remove('hidden');
                phoneInput.classList.add('border-red-500');
                phoneInput.classList.remove('border-green-500');
            }
        } else {
            phoneInput.classList.remove('border-red-500', 'border-green-500');
        }
    });

    // Format phone number on form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (phoneInput.value.trim() && iti.isValidNumber()) {
            // Store in E.164 format
            phoneInput.value = iti.getNumber();
        }
    });

    // Handle country dropdown change
    countrySelect.addEventListener('change', function() {
        countryIsoInput.value = this.value;
        loadProvinces(this.value);
    });

    // Country-Province dependent dropdown data
    const countriesProvinces = <?php echo json_encode(config('countries_provinces'), 15, 512) ?>;

    // Load provinces based on selected country
    function loadProvinces(countryCode) {
        const provinceWrapper = document.getElementById('province-wrapper');
        const provinceSelect = document.getElementById('province');
        const provinceStateCodeInput = document.getElementById('province_state_code');
        const provinceLabel = document.getElementById('province-label');

        // Reset province selection
        provinceSelect.innerHTML = '<option value="">Select Province/State</option>';
        provinceStateCodeInput.value = '';

        if (!countryCode || !countriesProvinces[countryCode]) {
            provinceWrapper.classList.add('hidden');
            return;
        }

        const provinces = countriesProvinces[countryCode].provinces;

        // If country has no provinces, hide the field
        if (!provinces || Object.keys(provinces).length === 0) {
            provinceWrapper.classList.add('hidden');
            return;
        }

        // Show province field and populate options
        provinceWrapper.classList.remove('hidden');

        // Update label based on country
        if (countryCode === 'US' || countryCode === 'AU') {
            provinceLabel.textContent = 'State';
        } else if (countryCode === 'CA') {
            provinceLabel.textContent = 'Province';
        } else if (countryCode === 'GB') {
            provinceLabel.textContent = 'Country';
        } else {
            provinceLabel.textContent = 'Province/State';
        }

        // Populate province dropdown
        Object.entries(provinces).forEach(([code, name]) => {
            const option = document.createElement('option');
            option.value = code;
            option.textContent = name;
            provinceSelect.appendChild(option);
        });

        // Restore previously selected province if exists
        const savedProvinceCode = provinceStateCodeInput.value;
        if (savedProvinceCode && provinces[savedProvinceCode]) {
            provinceSelect.value = savedProvinceCode;
        }
    }

    // Handle province selection
    document.getElementById('province').addEventListener('change', function() {
        document.getElementById('province_state_code').value = this.value;
    });

    // Initialize provinces on page load
    document.addEventListener('DOMContentLoaded', function() {
        const selectedCountry = countrySelect.value;
        if (selectedCountry) {
            loadProvinces(selectedCountry);
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/jobseeker/profile/edit.blade.php ENDPATH**/ ?>