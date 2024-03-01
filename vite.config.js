import { defineConfig } from 'vite';


export default defineConfig({
    root: './public/assets',
    base: '/build/',
    server: {
        port: 3000,
    },
    build: {
        assetsDir: '',
        outDir: '../public/build/',
        rollupOptions: {
            input: {
                'main.js': './assets/script.js',
            }
        }
    },
});