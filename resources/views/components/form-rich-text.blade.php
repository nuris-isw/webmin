@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => 'Tulis konten di sini...',
])

<div class="space-y-2" x-data="{ content: '{{ addslashes($value) }}' }">
    @if($label)
        <label for="editor-{{ $name }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    <!-- Hidden input to submit the editor data -->
    <input type="hidden" name="{{ $name }}" id="input-{{ $name }}" x-model="content">

    <!-- Editor Wrapper -->
    <div class="rounded-md overflow-hidden border border-gray-300 dark:border-gray-700">
        <!-- Editor Container -->
        <div id="editor-{{ $name }}" class="min-h-50 bg-white dark:bg-[#1E1E1E] text-gray-900 dark:text-gray-100">
            {!! $value !!}
        </div>
    </div>

    @error($name)
        <p class="text-sm text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- Styles and Scripts for Quill -->
@once
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <style>
        /* Modern Design System overrides for Quill */
        .ql-toolbar.ql-snow {
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 1px solid #e5e7eb !important;
            background-color: #f9fafb;
        }
        .dark .ql-toolbar.ql-snow {
            border-bottom: 1px solid #374151 !important;
            background-color: #111827;
        }
        .ql-container.ql-snow {
            border: none !important;
        }
        .dark .ql-stroke {
            stroke: #9ca3af !important;
        }
        .dark .ql-fill {
            fill: #9ca3af !important;
        }
        .dark .ql-picker {
            color: #9ca3af !important;
        }
        .dark .ql-picker-options {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        .ql-editor {
            font-size: 0.875rem !important;
            line-height: 1.5rem !important;
            min-height: 200px;
        }
        .ql-editor.ql-blank::before {
            color: #9ca3af !important;
            font-style: normal !important;
        }
    </style>
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editorId = '#editor-{{ $name }}';
        const inputId = '#input-{{ $name }}';

        if (document.querySelector(editorId)) {
            const quill = new Quill(editorId, {
                theme: 'snow',
                placeholder: '{{ $placeholder }}',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'header': [1, 2, 3, false] }],
                        ['clean']
                    ]
                }
            });

            // Update hidden input on change
            quill.on('text-change', function() {
                const html = quill.root.innerHTML;
                // If it is just an empty tag, set it to empty string
                const isEmptyValue = html === '<p><br></p>' || html === '';
                document.querySelector(inputId).value = isEmptyValue ? '' : html;
            });
        }
    });
</script>
