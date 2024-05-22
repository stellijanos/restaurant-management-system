// Import jQuery
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Import Bootstrap
import 'bootstrap';

// Import Tempus Dominus JS and CSS
import { DateTime, TempusDominus } from '@eonasdan/tempus-dominus';
import '@eonasdan/tempus-dominus/dist/css/tempus-dominus.css';

// Initialize Tempus Dominus
$(document).ready(function () {
    const picker1 = new TempusDominus(document.getElementById('start-date'), {
        display: {
            components: {
                decades: true,
                year: true,
                month: true,
                date: true,
                hours: false,
                minutes: false,
                seconds: false
            }
        },
        localization: {
            hourCycle: 'h23'
        }
    });

    const picker2 = new TempusDominus(document.getElementById('end-date'), {
        display: {
            components: {
                decades: true,
                year: true,
                month: true,
                date: true,
                hours: false,
                minutes: false,
                seconds: false
            }
        },
        localization: {
            hourCycle: 'h23'
        }
    });

    document.getElementById('start-date').addEventListener('change.td', (e) => {
        picker2.updateOptions({
            restrictions: {
                minDate: e.detail.date
            },
            display: {
                components: {
                    decades: true,
                    year: true,
                    month: true,
                    date: true,
                    hours: false,
                    minutes: false,
                    seconds: false
                }
            },
            localization: {
                hourCycle: 'h23'
            }
        });
    });

    document.getElementById('end-date').addEventListener('change.td', (e) => {
        picker1.updateOptions({
            restrictions: {
                maxDate: e.detail.date
            },
            display: {
                components: {
                    decades: true,
                    year: true,
                    month: true,
                    date: true,
                    hours: false,
                    minutes: false,
                    seconds: false
                }
            },
            localization: {
                hourCycle: 'h23'
            }
        });
    });
});













/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// app.mount('#app');

