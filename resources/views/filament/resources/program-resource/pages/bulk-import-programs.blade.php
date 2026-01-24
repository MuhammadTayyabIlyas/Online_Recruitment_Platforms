<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                CSV Import Instructions
            </x-slot>

            <x-slot name="description">
                Follow these steps to bulk import study programs
            </x-slot>

            <div class="prose dark:prose-invert max-w-none">
                <ol class="space-y-2">
                    <li><strong>Download the template:</strong> Click the button below to download the CSV template with sample data.</li>
                    <li><strong>Fill your data:</strong> Open the template in Excel/Google Sheets and add your program data.</li>
                    <li><strong>Required columns:</strong>
                        <ul class="list-disc ml-6 mt-1">
                            <li><code>title</code> - Program name (required)</li>
                            <li><code>university_name</code> - University name (required, will be created if doesn't exist)</li>
                            <li><code>country_name</code> - Country name (required, will be created if doesn't exist)</li>
                            <li><code>degree_name</code> - Degree level (required, e.g., Bachelor, Master)</li>
                            <li><code>subject_name</code> - Subject/field (required, e.g., Computer Science)</li>
                        </ul>
                    </li>
                    <li><strong>Optional columns:</strong>
                        <ul class="list-disc ml-6 mt-1">
                            <li><code>language</code> - Language of instruction (default: English)</li>
                            <li><code>tuition_fee</code> - Annual tuition in EUR (numbers only)</li>
                            <li><code>duration</code> - Program duration (e.g., "2 years")</li>
                            <li><code>study_mode</code> - On-campus, Online, or Hybrid</li>
                            <li><code>intake</code> - Next intake (e.g., "September 2025")</li>
                            <li><code>program_url</code> - External application link</li>
                            <li><code>is_featured</code> - Set to "yes" or "1" for featured programs</li>
                            <li><code>description</code> - Program description</li>
                        </ul>
                    </li>
                    <li><strong>Upload:</strong> Save as CSV and upload below.</li>
                </ol>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="flex justify-center mb-6">
                <x-filament::button
                    wire:click="downloadTemplate"
                    icon="heroicon-o-arrow-down-tray"
                    color="success"
                    size="lg"
                >
                    Download CSV Template
                </x-filament::button>
            </div>
        </x-filament::section>

        <form wire:submit="import">
            {{ $this->form }}

            <div class="flex justify-end mt-6">
                <x-filament::button
                    type="submit"
                    size="lg"
                    icon="heroicon-o-arrow-up-tray"
                >
                    Import Programs
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
