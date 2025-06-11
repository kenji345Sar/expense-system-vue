import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // ← これを追加

export default defineConfig({
    server: {
        host: true,
        port: 5173,
        hmr: {
            host: '127.0.0.1',
            protocol: 'http',
        },
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // ← これを追加！
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
