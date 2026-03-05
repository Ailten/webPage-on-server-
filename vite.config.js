import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/blackTheme.css',
                'resources/css/fightMain.css',
                'resources/css/fightResponcive.css',
                'resources/css/main.css', 
                'resources/css/responcive.css',
                
                'resources/js/bootstrap.js',
                'resources/js/fightMain.js',
                'resources/js/main.js',
            ],
            refresh: true,
        }),
    ],

    // test.
    //server: {
    //    host: '80.201.20.68',
    //    port: 8000,
    //    strictPort: true,
    //    hmr: {
    //        host: '80.201.20.68'
    //    },
    //    https: false
    //}

});
