import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

function toggleBox() {
    const box = document.getElementById('myBox');

    if (box.classList.contains('hidden')) {
        box.classList.remove('hidden');
        box.classList.remove('slide-up');
        box.classList.add('slide-down');
    } else {
        box.classList.remove('slide-down');
        box.classList.add('slide-up');

        setTimeout(() => {
            box.classList.add('hidden');
        }, 300);
    }
}
