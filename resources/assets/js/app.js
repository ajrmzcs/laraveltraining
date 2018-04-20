
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

$(function () {

    let todayDate = moment().startOf('day');
    let YM = todayDate.format('YYYY-MM');
    let YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
    let TODAY = todayDate.format('YYYY-MM-DD');
    let TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        navLinks: true,
        events: '/test',
    });
});
