import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
  resolve: {
    preserveSymlinks: true
  },
  plugins: [
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/sass/form.scss',
        'resources/js/app.js',
        'resources/js/Users.js'
      ],
      refresh: true
    })
  ]
});
