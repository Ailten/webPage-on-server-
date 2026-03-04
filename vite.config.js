import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/main.css', 'resources/js/main.js'],  // maybe doublon ? (already extend in view).
            refresh: true,
        }),
    ],

    // test.
    server: {
        host: '80.201.20.68',
        port: 8000,
        strictPort: true,
        hmr: {
            host: '80.201.20.68'
        },
        https: false
    }

});
