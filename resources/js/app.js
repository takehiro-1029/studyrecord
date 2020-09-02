/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import ScrollReveal from 'scrollreveal'
import moment from 'vue-moment'
Vue.use(moment)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('index-chart', require('./components/IndexChart.vue').default);
Vue.component('line-chart', require('./components/LineChart.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


//top画面のふわっと出る表示(画面遷移時に一瞬表示されるのを防ぐためにopacity設定)
$(window).on('load', function () {
    window.sr = ScrollReveal();
    sr.reveal('.js-top_header-animation', {
        viewFactor: 0.2,
        duration: 2000,
        origin: 'bottom',
        distance: '50px',
        reset: false
    });

    sr.reveal('.js-top_main-animation', {
        viewFactor: 0.2,
        duration: 2000,
        origin: 'bottom',
        distance: '100px',
        reset: false
    });
//    $('.l-main__top').css('opacity', 1);
//    $('.l-header_top').css('opacity', 1);
    
    $('.l-main__top').fadeIn(0); 
    $('.l-header_top').fadeIn(0); 
    $('.l-footer').fadeIn(0); 
    $('.p-header_main__actions').fadeIn(0); 
});

//マウスオーバーしたときにユーザー情報表示
$(function () {
    $('.js-hover').on('click mouseenter', function () {
        $('.js-show').addClass('js-show_user');
    });
    $('.js-show').hover(function () {}, function () {
        $('.js-show').removeClass('js-show_user');
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.js-hover').length && !$(e.target).closest('.js-show_user').length　&& $('.js-show').hasClass('js-show_user')) {
            $('.js-show').removeClass('js-show_user');
        }
    });
});


//グラフの高さと背景を白に設定
//$(function () {
//    var ctx = document.getElementById("line-chart").getContext("2d");
//    //ctx.canvas.parentNode.style.height = '250px';
//    ctx.canvas.parentNode.style.backgroundColor = '#fff';
//    ctx.canvas.style.height = '250px';
//});

//ページ遷移時にスクロール位置に戻る
//$('.js-scroll_top').click(function(){
//    var scrollPos= $(document).scrollTop();
//    sessionStorage.setItem('key',scrollPos);
//});
//$(document).ready(function(){
//    var pos = sessionStorage.getItem('key');
////    $('html,body').animate({ scrollTop: pos }, 'slow');
//    $(window).scrollTop(pos);
//    sessionStorage.clear();
//});

// SPメニュー
$(function() {
    $('.js-toggle-sp-menu').on('click', function () {
        $(this).toggleClass('active');
        $('.js-toggle-sp-menu-target').toggleClass('active');
    });
});

