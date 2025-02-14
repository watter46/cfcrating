import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/field.css',
                'resources/css/flow-button.css',
                'resources/css/message.css',
                'resources/css/modal.css',
                'resources/css/player.css',
                'resources/css/rating.css',
                'resources/css/startingXi.css',
                'resources/css/tier.css',
                'resources/css/top.css',

                'resources/js/startingXi/draggable.js',
                'resources/js/startingXi/formation.js',
                'resources/js/startingXi/lineups.js',
                'resources/js/startingXi/startingXi.js',
                'resources/js/startingXi/title.js',
                'resources/js/tier/draggable.js',
                'resources/js/tier/players.js',
                'resources/js/tier/setting.js',
                'resources/js/tier/tier.js',
                'resources/js/tier/tierList.js',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/copyRatings.js',
                'resources/js/downloadImage.js',
                'resources/js/field.js',
                'resources/js/flowButton.js',
                'resources/js/modal.js',
                'resources/js/notify.js',
                'resources/js/rating.js'
            ],
            refresh: true,
        }),
    ]
});
