import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./views/Home";
import Games from "./views/Games";
import Game from "./views/Game";
import NotFound from "./views/NotFound";

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/games',
            component: Games,
            name:'games',
        },
        {
            path: '/game/:id',
            component: Game,
            name:'game',
            props: true,

        },
        {
            path: '*',
            component: NotFound,
            name:'notFound',
        }
    ]
})