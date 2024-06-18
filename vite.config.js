import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
          '~': path.resolve(__dirname, 'node_modules'),
          '@': path.resolve(__dirname, 'resources/js'),
          '@css': path.resolve(__dirname, 'resources/css'),
          '@img': path.resolve(__dirname, 'resources/img'),
          '@views': path.resolve(__dirname, 'resources/js/views'),
          '@pages': path.resolve(__dirname, 'resources/js/views/pages'),
          '@store': path.resolve(__dirname, 'resources/js/store'),
          '@Services': path.resolve(__dirname, 'resources/js/Services'),
          '@router': path.resolve(__dirname, 'resources/js/router'),
          '@Components': path.resolve(__dirname, 'resources/js/Components'),
        },
    }
});
