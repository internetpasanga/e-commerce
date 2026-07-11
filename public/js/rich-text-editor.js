(function () {
    function icon(svgPath) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + svgPath + '</svg>';
    }

    var BUTTONS = [
        { command: 'bold', title: 'Bold', icon: icon('<path d="M6 4h8a4 4 0 0 1 0 8H6z"/><path d="M6 12h9a4 4 0 0 1 0 8H6z"/>') },
        { command: 'italic', title: 'Italic', icon: icon('<line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/>') },
        { command: 'underline', title: 'Underline', icon: icon('<path d="M6 4v6a6 6 0 0 0 12 0V4"/><line x1="4" y1="20" x2="20" y2="20"/>') },
        { command: 'strikeThrough', title: 'Strikethrough', icon: icon('<line x1="4" y1="12" x2="20" y2="12"/><path d="M16 6.5c-.7-1-2-1.5-4-1.5-2.5 0-4 1-4 2.5s1.5 2 4 2.5 4 1 4 2.5-1.5 2.5-4 2.5c-2 0-3.3-.5-4-1.5"/>') },
        { type: 'separator' },
        { command: 'formatBlock', value: 'h3', title: 'Heading', label: 'H' },
        { command: 'formatBlock', value: 'p', title: 'Paragraph', label: 'P' },
        { type: 'separator' },
        { command: 'insertUnorderedList', title: 'Bullet list', icon: icon('<line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><circle cx="4" cy="6" r="1"/><circle cx="4" cy="12" r="1"/><circle cx="4" cy="18" r="1"/>') },
        { command: 'insertOrderedList', title: 'Numbered list', icon: icon('<line x1="10" y1="6" x2="20" y2="6"/><line x1="10" y1="12" x2="20" y2="12"/><line x1="10" y1="18" x2="20" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M4 14h2l-2 2.5h2"/>') },
        { type: 'separator' },
        { command: 'link', title: 'Insert link', icon: icon('<path d="M10 13a5 5 0 0 0 7.07 0l2.83-2.83a5 5 0 0 0-7.07-7.07L11.5 4.5"/><path d="M14 11a5 5 0 0 0-7.07 0L4.1 13.83a5 5 0 0 0 7.07 7.07L12.5 19.5"/>') },
        { command: 'removeFormat', title: 'Clear formatting', icon: icon('<path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/><line x1="5" y1="5" x2="19" y2="19"/>') },
        { type: 'separator' },
        { command: 'undo', title: 'Undo', icon: icon('<path d="M9 14 4 9l5-5"/><path d="M4 9h11a5 5 0 0 1 0 10h-1"/>') },
        { command: 'redo', title: 'Redo', icon: icon('<path d="m15 14 5-5-5-5"/><path d="M20 9H9a5 5 0 0 0 0 10h1"/>') },
    ];

    function createEditor(textarea) {
        if (textarea.dataset.rteInitialized) {
            return;
        }
        textarea.dataset.rteInitialized = 'true';

        var wrapper = document.createElement('div');
        wrapper.className = 'rte-wrapper';
        textarea.parentNode.insertBefore(wrapper, textarea);

        var toolbar = document.createElement('div');
        toolbar.className = 'rte-toolbar';

        var editable = document.createElement('div');
        editable.className = 'rte-editable';
        editable.contentEditable = 'true';
        editable.innerHTML = textarea.value;

        function syncTextarea() {
            textarea.value = editable.innerHTML;
        }

        BUTTONS.forEach(function (btn) {
            if (btn.type === 'separator') {
                var sep = document.createElement('span');
                sep.className = 'rte-separator';
                toolbar.appendChild(sep);
                return;
            }

            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'rte-btn';
            button.title = btn.title;
            button.innerHTML = btn.icon || ('<span class="rte-btn-label">' + btn.label + '</span>');

            button.addEventListener('mousedown', function (event) {
                event.preventDefault();
            });

            button.addEventListener('click', function () {
                editable.focus();

                if (btn.command === 'link') {
                    var url = window.prompt('Enter URL');
                    if (url) {
                        document.execCommand('createLink', false, url);
                    }
                } else if (btn.command === 'formatBlock') {
                    document.execCommand('formatBlock', false, btn.value);
                } else {
                    document.execCommand(btn.command, false, null);
                }

                syncTextarea();
            });

            toolbar.appendChild(button);
        });

        editable.addEventListener('input', syncTextarea);
        editable.addEventListener('blur', syncTextarea);

        wrapper.appendChild(toolbar);
        wrapper.appendChild(editable);
        wrapper.appendChild(textarea);
        textarea.classList.add('rte-source');
    }

    function init() {
        document.querySelectorAll('[data-rich-text]').forEach(createEditor);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
