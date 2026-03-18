import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
        server: {
        host: '0.0.0.0',  // tambah ini
        port: 5173,        // tambah ini
        hmr: {
            host: '192.168.100.12',  // ganti dengan IP kamu
        },
    },
});
