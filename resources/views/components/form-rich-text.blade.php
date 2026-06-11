@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => 'Tulis konten di sini...',
])

<div class="space-y-2">
    @if($label)
        <label for="editor-{{ $name }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    {{-- Hidden input to hold the HTML value for form submission --}}
    <input type="hidden" name="{{ $name }}" id="input-{{ $name }}" value="{{ old($name, $value) }}">

    {{-- Editor Wrapper --}}
    <div class="rounded-md overflow-hidden border border-gray-300 dark:border-gray-700 focus-within:border-brand-red focus-within:ring-1 focus-within:ring-brand-red/30 transition">
        {{-- Editor Container — Quill renders here, initial value passed via data attribute --}}
        <div
            id="editor-{{ $name }}"
            class="min-h-[200px] bg-white dark:bg-[#1E1E1E] text-gray-900 dark:text-gray-100"
            data-initial-value="{{ htmlspecialchars(old($name, $value ?? ''), ENT_QUOTES, 'UTF-8') }}"
        ></div>
    </div>

    @error($name)
        <p class="text-sm text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Styles and Scripts for Quill (loaded only once per page) --}}
@once
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <style>
        /* ============================================
           WebMin Design System — Quill Editor Overrides
           ============================================ */

        /* Toolbar */
        .ql-toolbar.ql-snow {
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 1px solid #e5e7eb !important;
            background-color: #f9fafb;
            padding: 8px 12px !important;
            border-radius: 0 !important;
        }
        .dark .ql-toolbar.ql-snow {
            border-bottom: 1px solid #374151 !important;
            background-color: #111827;
        }

        /* Container */
        .ql-container.ql-snow {
            border: none !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        /* Dark mode icon colors */
        .dark .ql-stroke {
            stroke: #9ca3af !important;
        }
        .dark .ql-fill {
            fill: #9ca3af !important;
        }
        .dark .ql-picker {
            color: #9ca3af !important;
        }
        .dark .ql-picker-label {
            color: #9ca3af !important;
        }
        .dark .ql-picker-options {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #e5e7eb !important;
        }
        .dark .ql-picker-item:hover,
        .dark .ql-picker-item.ql-selected {
            color: #f3f4f6 !important;
        }
        .dark .ql-toolbar button:hover .ql-stroke,
        .dark .ql-toolbar button.ql-active .ql-stroke {
            stroke: #f9fafb !important;
        }
        .dark .ql-toolbar button:hover .ql-fill,
        .dark .ql-toolbar button.ql-active .ql-fill {
            fill: #f9fafb !important;
        }

        /* Editor area */
        .ql-editor {
            font-size: 0.875rem !important;
            line-height: 1.6rem !important;
            min-height: 200px;
            padding: 14px 16px !important;
        }

        /* Placeholder */
        .ql-editor.ql-blank::before {
            color: #9ca3af !important;
            font-style: normal !important;
            font-size: 0.875rem;
        }

        /* Blockquote */
        .ql-editor blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 12px;
            color: #6b7280;
        }
        .dark .ql-editor blockquote {
            border-left-color: #374151;
            color: #9ca3af;
        }

        /* Code block */
        .ql-editor code,
        .ql-editor pre {
            background: #f3f4f6;
            border-radius: 4px;
            font-family: monospace;
        }
        .dark .ql-editor code,
        .dark .ql-editor pre {
            background: #1f2937;
            color: #e5e7eb;
        }
    </style>
@endonce

<script>
    (function() {
        function initQuillEditor(editorId, inputId, placeholder) {
            const editorEl = document.getElementById(editorId);
            const inputEl  = document.getElementById(inputId);

            if (!editorEl || !inputEl) return;

            const quill = new Quill('#' + editorId, {
                theme: 'snow',
                placeholder: placeholder,
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'header': [1, 2, 3, 4, false] }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // ─── Pre-populate editor with existing content (critical for edit forms) ───
            // Quill v2 ignores innerHTML on init — use dangerouslyPasteHTML instead.
            const initialContent = editorEl.dataset.initialValue || '';
            if (initialContent && initialContent.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(initialContent);
                // Move cursor to end
                quill.setSelection(quill.getLength(), 0);
            }

            // ─── Sync hidden input whenever the editor changes ───
            quill.on('text-change', function() {
                const html = quill.root.innerHTML;
                const isEmpty = html === '<p><br></p>' || html.trim() === '';
                inputEl.value = isEmpty ? '' : html;
            });
        }

        // Initialize after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            initQuillEditor(
                'editor-{{ $name }}',
                'input-{{ $name }}',
                '{{ addslashes($placeholder) }}'
            );
        });
    })();
</script>
