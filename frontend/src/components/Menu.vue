<template>
    <b-row id="menu">
        <b-col cols="6" md="6" class="text-left">
            <router-link to="/games">
                <a href="#" class="btn btn-primary">Games</a>
            </router-link>
        </b-col>
        <b-col cols="6" md="6" class="text-right">
            <b-link
                    class="btn btn-success"
                    v-on:click="newGame()"
            >Game
            </b-link>
        </b-col>
    </b-row>

</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "Menu",

        methods: mapActions(['newGame'])
    }
</script>

<style scoped>
    #menu {
        margin: 35px 0;
    }
</style>