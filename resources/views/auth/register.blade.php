@extends('layouts.app')

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const passwordStrengthIndicator = document.getElementById('password-strength-indicator');
    const passwordStrengthText = document.getElementById('password-strength-text');

    function evaluatePasswordStrength(password) {
        let strength = 0;
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        strength = Object.values(checks).filter(Boolean).length;

        if (password.length >= 12) strength += 0.5;
        if (password.length >= 16) strength += 0.5;

        return { score: Math.min(strength, 5), checks };
    }

    function updatePasswordStrength() {
        const password = passwordInput.value;
        const { score, checks } = evaluatePasswordStrength(password);
        
        if (password.length === 0) {
            passwordStrengthIndicator.style.display = 'none';
            return;
        }

        passwordStrengthIndicator.style.display = 'block';
        
        // Update visual indicator
        const segments = passwordStrengthIndicator.querySelectorAll('.strength-segment');
        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500', 'bg-green-600'];
        const widths = ['w-1/5', 'w-2/5', 'w-3/5', 'w-4/5', 'w-full'];
        
        segments.forEach((segment, index) => {
            segment.className = 'strength-segment h-full transition-all duration-300';
            if (index < score) {
                segment.classList.add(colors[index]);
            } else {
                segment.classList.add('bg-gray-200');
            }
        });

        // Update text
        const strengthText = [
            'Very Weak',
            'Weak', 
            'Fair',
            'Strong',
            'Very Strong'
        ];

        passwordStrengthText.textContent = strengthText[Math.min(Math.floor(score), 4)];
        passwordStrengthText.className = 'text-xs font-medium ' + [
            'text-red-600',
            'text-orange-600',
            'text-yellow-600',
            'text-green-600',
            'text-green-700'
        ][Math.min(Math.floor(score), 4)];

        // Update individual checks
        Object.entries(checks).forEach(([key, passed]) => {
            const element = document.getElementById(`check-${key}`);
            if (element) {
                const icon = element.querySelector('svg');
                if (passed) {
                    element.classList.add('text-green-600');
                    element.classList.remove('text-gray-400');
                    icon.innerHTML = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>';
                } else {
                    element.classList.add('text-gray-400');
                    element.classList.remove('text-green-600');
                    icon.innerHTML = '<path d="M6 18L18 6M6 6l12 12"/>';
                }
            }
        });
    }

    function checkPasswordMatch() {
        const match = passwordInput.value === passwordConfirmationInput.value;
        const confirmationGroup = passwordConfirmationInput.closest('div');
        
        if (passwordConfirmationInput.value.length === 0) {
            confirmationGroup.classList.remove('border-green-300', 'border-red-300');
            document.getElementById('password-match-indicator').style.display = 'none';
            return;
        }

        document.getElementById('password-match-indicator').style.display = 'block';
        
        if (match) {
            confirmationGroup.classList.add('border-green-300');
            confirmationGroup.classList.remove('border-red-300');
            document.getElementById('password-match-text').textContent = 'Passwords match';
            document.getElementById('password-match-text').className = 'text-xs font-medium text-green-600';
        } else {
            confirmationGroup.classList.add('border-red-300');
            confirmationGroup.classList.remove('border-green-300');
            document.getElementById('password-match-text').textContent = 'Passwords do not match';
            document.getElementById('password-match-text').className = 'text-xs font-medium text-red-600';
        }
    }

    passwordInput.addEventListener('input', updatePasswordStrength);
    passwordInput.addEventListener('input', checkPasswordMatch);
    passwordConfirmationInput.addEventListener('input', checkPasswordMatch);

    // Toggle password visibility
    const togglePassword = document.getElementById('toggle-password');
    const togglePasswordConfirm = document.getElementById('toggle-password-confirmation');

    function createToggleHandler(input, button) {
        button.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            const icon = button.querySelector('svg');
            if (type === 'password') {
                icon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>';
            } else {
                icon.innerHTML = '<path d="M13.875 18.825A10.05 10.05 0 0110 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0110 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            }
        });
    }

    createToggleHandler(passwordInput, togglePassword);
    createToggleHandler(passwordConfirmationInput, togglePasswordConfirm);
});
</script>
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full">
        <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl ring-1 ring-white/20">
            {{-- Logo/Brand --}}
            <div class="text-center mb-8">
                <div class="mx-auto h-14 w-14 rounded-xl bg-white shadow-md ring-2 ring-blue-100 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet logo" class="h-12 w-12 object-cover">
                </div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Create Your Account</h2>
                <p class="text-sm text-gray-600 mt-1">Join thousands of professionals on PlaceMeNet</p>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Please correct the following:</h3>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                {{-- Name Field --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input id="name"
                           name="name"
                           type="text"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           autofocus
                           class="appearance-none relative block w-full px-3 py-3 border {{ $errors->has('name') ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' }} placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200"
                           placeholder="Enter your full name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                    <input id="email"
                           name="email"
                           type="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           class="appearance-none relative block w-full px-3 py-3 border {{ $errors->has('email') ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' }} placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200"
                           placeholder="Enter your email address">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">We'll verify this email for your security.</p>
                </div>

                {{-- Phone Field (Optional) --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number (Optional)</label>
                    <input id="phone"
                           name="phone"
                           type="tel"
                           value="{{ old('phone') }}"
                           autocomplete="tel"
                           class="appearance-none relative block w-full px-3 py-3 border {{ $errors->has('phone') ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' }} placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200"
                           placeholder="+1 234 567 8900">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Used for login and security alerts.</p>
                </div>

                {{-- User Type Field --}}
                <div>
                    <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1">Account Type *</label>
                    <select id="user_type"
                            name="user_type"
                            required
                            class="appearance-none relative block w-full px-3 py-3 border {{ $errors->has('user_type') ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' }} text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200">
                        <option value="">Select Account Type</option>
                        <option value="employer" {{ old('user_type') === 'employer' ? 'selected' : '' }}>Employer - Post Jobs & Find Candidates</option>
                        <option value="job_seeker" {{ old('user_type') === 'job_seeker' ? 'selected' : '' }}>Job Seeker - Find & Apply to Jobs</option>
                        <option value="educational_institution" {{ old('user_type') === 'educational_institution' ? 'selected' : '' }}>Educational Institution - Publish Study Programs</option>
                        <option value="student" {{ old('user_type') === 'student' ? 'selected' : '' }}>Student - Browse & Apply to Study Programs</option>
                    </select>
                    @error('user_type')
                        <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field with Strength Indicator --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                    <div class="relative">
                        <input id="password"
                               name="password"
                               type="password"
                               required
                               autocomplete="new-password"
                               class="appearance-none relative block w-full px-3 py-3 pr-10 border {{ $errors->has('password') ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' }} placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200"
                               placeholder="Create a strong password">
                        
                        {{-- Password Toggle Button --}}
                        <button type="button"
                                id="toggle-password"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors"
                                aria-label="Toggle password visibility">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Password Strength Indicator --}}
                    <div id="password-strength-indicator" class="mt-2" style="display: none;">
                        <div class="flex h-1 bg-gray-200 rounded-full overflow-hidden">
                            <div class="strength-segment h-full w-1/5 bg-gray-200 transition-all duration-300"></div>
                            <div class="strength-segment h-full w-1/5 bg-gray-200 transition-all duration-300"></div>
                            <div class="strength-segment h-full w-1/5 bg-gray-200 transition-all duration-300"></div>
                            <div class="strength-segment h-full w-1/5 bg-gray-200 transition-all duration-300"></div>
                            <div class="strength-segment h-full w-1/5 bg-gray-200 transition-all duration-300"></div>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <p id="password-strength-text" class="text-xs font-medium text-gray-600"></p>
                            <span class="text-xs text-gray-500"></span>
                        </div>
                    </div>

                    {{-- Password Requirements --}}
                    <div class="mt-3 bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs font-medium text-gray-700 mb-2">Password must contain:</p>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div id="check-length" class="flex items-center text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                8+ characters
                            </div>
                            <div id="check-uppercase" class="flex items-center text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Uppercase letter
                            </div>
                            <div id="check-lowercase" class="flex items-center text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Lowercase letter
                            </div>
                            <div id="check-number" class="flex items-center text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Number
                            </div>
                            <div id="check-special" class="flex items-center text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Special character
                            </div>
                            <div id="check-minimum" class="flex items-center text-green-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Your data is encrypted
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password Field --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                    <div class="relative">
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               required
                               autocomplete="new-password"
                               class="appearance-none relative block w-full px-3 py-3 pr-10 border {{ $errors->has('password_confirmation') ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300' }} placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200"
                               placeholder="Confirm your password">
                        
                        {{-- Password Toggle Button --}}
                        <button type="button"
                                id="toggle-password-confirmation"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors"
                                aria-label="Toggle password visibility">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Password Match Indicator --}}
                    <div id="password-match-indicator" style="display: none;" class="mt-1">
                        <p id="password-match-text" class="text-xs font-medium"></p>
                    </div>

                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Security Agreement --}}
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-600">
                            By signing up, you agree to our <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Privacy Policy</a> and <a href="{{ route('terms') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Terms of Service</a>. We'll protect your data with enterprise-grade security.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    Create Secure Account
                </button>
            </div>

            {{-- Sign In Link --}}
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                        Sign in securely
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
