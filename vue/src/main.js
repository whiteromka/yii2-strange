import Vue from  '../node_modules/vue/dist/vue.common';
import HelloComponent from "@/components/HelloComponent"

window.Vue = Vue;
window.Vue.component('hello-component', HelloComponent)
