<script>
document.addEventListener('DOMContentLoaded', () => {
    const cityInputs = Array.from(document.querySelectorAll('[data-geo-city]'));
    const countryInputs = Array.from(document.querySelectorAll('[data-geo-country]'));
    const stateInputs = Array.from(document.querySelectorAll('[data-geo-state]'));
    const statusEls = Array.from(document.querySelectorAll('[data-geo-status]'));

    if (!cityInputs.length && !countryInputs.length && !stateInputs.length) {
        return;
    }

    const applyValue = (input, value) => {
        if (!input || input.value.trim() || !value) {
            return false;
        }

        input.value = value;
        input.dispatchEvent(new Event('input', { bubbles: true }));
        return true;
    };

    const setStatus = (message, variant = 'muted') => {
        statusEls.forEach((el) => {
            el.textContent = message;
            el.classList.remove('text-red-600', 'text-green-600', 'text-gray-500', 'hidden');

            if (variant === 'error') {
                el.classList.add('text-red-600');
            } else if (variant === 'success') {
                el.classList.add('text-green-600');
            } else {
                el.classList.add('text-gray-500');
            }
        });
    };

    setStatus('Detecting your city automatically…');

    fetch('https://ipapi.co/json/')
        .then((response) => {
            if (!response.ok) {
                throw new Error('IP lookup failed');
            }
            return response.json();
        })
        .then((data) => {
            const { city, region, country_name: countryName } = data || {};

            const filledCity = cityInputs.map((input) => applyValue(input, city)).some(Boolean);
            const filledState = stateInputs.map((input) => applyValue(input, region)).some(Boolean);
            const filledCountry = countryInputs.map((input) => applyValue(input, countryName)).some(Boolean);

            if (filledCity || filledState || filledCountry) {
                const detectedLocation = [city, countryName].filter(Boolean).join(', ');
                setStatus(detectedLocation ? `Detected ${detectedLocation} from your IP.` : 'Location detected from your IP.', 'success');
            } else {
                if (statusEls.length) {
                    setStatus('Using your existing city value.', 'muted');
                }
            }
        })
        .catch(() => {
            if (statusEls.length) {
                setStatus('Could not detect your city automatically. Please enter it manually.', 'error');
            }
        });
});
</script>
<?php /**PATH /var/www/placemenet/resources/views/layouts/partials/geo-autofill.blade.php ENDPATH**/ ?>