import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,

        /*
         * Browser accesses Vite using localhost:5173
         */
        origin: 'http://localhost:5173',

        /*
         * Laravel application is running at localhost:8080.
         * Allow the Laravel origin to access Vite.
         */
        cors: {
            origin: 'http://localhost:8080',
        },

        /*
         * HMR connection from browser
         */
        hmr: {
            host: 'localhost',
            port: 5173,
            protocol: 'ws',
        },

        watch: {
            ignored: [
                '**/storage/framework/views/**',
            ],
        },
    },
});
