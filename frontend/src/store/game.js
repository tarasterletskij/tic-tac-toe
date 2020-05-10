import Vue from "vue";
import Vuex from "vuex"
import axios from 'axios'
import VueRouter from 'vue-router'
import router from "../router";

Vue.use(Vuex, axios, VueRouter);

let baseUrl = process.env.VUE_APP_ROOT_API

function errorFetch(error) {
    const status = error.response.status;
    if (status === 404) {
        router.push({name: 'notFound'})
    } else if (status === 400) {
        alert(error.response.data.reason);
    } else {
        console.log(error.response.data.detail)
    }
}

export default new Vuex.Store({
    state: {
        games: [],
        game: {},
        loading: true,
        board: '---------',
    },
    actions: {
        getGames({commit, state}) {
            state.loading = true
            axios.get(baseUrl)
                .then(
                    data => {
                        const games = data.data
                        commit('updateGames', games)

                    })
                .catch(error => {
                    errorFetch(error)
                    state.loading = false
                })
        },
        getGame({commit, state}, id) {
            state.loading = true
            axios.get(baseUrl + id)
                .then(
                    data => {
                        const game = data.data
                        commit('updateGame', game)
                    })
                .catch(error => {
                    errorFetch(error)
                    state.loading = false
                })
        },
        newGame({commit, state}) {
            state.loading = true
            const params = new URLSearchParams();
            params.append('board', state.board);
            axios.post(baseUrl, params)
                .then(
                    data => {
                        const location = data.data.location
                        commit('locationGame', location)

                    })
                .catch(error => {
                    errorFetch(error)
                    state.loading = false
                })
        },
        moveGame({commit, state}, {id, board}) {
            state.loading = true
            const params = new URLSearchParams();
            params.append('board', board);
            axios.put(baseUrl + id, params)
                .then(
                    data => {
                        const game = data.data
                        commit('updateGame', game)
                    })
                .catch(error => {
                    errorFetch(error)
                    state.loading = false
                })
        },
        deleteGame({commit, state}, id) {
            state.loading = true
            axios.delete(baseUrl + id)
                .then(
                    commit('deleteGame', id)
                )
                .catch(error => {
                    errorFetch(error)
                    state.loading = false
                })
        },
    },
    mutations: {
        updateGames(state, games) {
            state.loading = false
            state.games = games
        },
        updateGame(state, game) {
            state.loading = false
            game.isFinish = game.status !== 'RUNNING';
            const index = state.games.findIndex(item => item.id === game.id)
            state.games.splice(index, 1, game)
            state.game = game
        },
        locationGame(state, location) {
            state.loading = false
            router.push({name: 'game', params: {id: location}})
        },
        deleteGame(state, id) {
            state.loading = false
            state.games = state.games.filter(g => g.id !== id)
            router.push({name: 'games'})

        },
    },
    getters: {
        allGames(state) {
            return state.games
        },
        getGameById(state) {
            return state.game
        },
        getLoading(state) {
            return state.loading
        }
    }
})