<template>
    <div>
        <div v-if="getLoading">
            <Loader/>
        </div>
        <div v-else class="game">
            <p>Game {{id}}</p>
            <br>
            <GameGrid
                    :grid="getGameById"
                    :gameId="id"
                    :status="getGameById.status"
            />
        </div>
    </div>
</template>

<script>
    import Loader from "@/components/Loader";
    import GameGrid from "@/components/GameGrid";
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "Game",
        components: {
            GameGrid,
            Loader
        },
        props: ['id'],
        computed: {
            ...mapGetters(['getGameById', 'getLoading']),
        },
        methods: {
            ...mapActions(['getGame', 'startLoading']),
        },
        mounted() {
            this.getGame(this.id);
        },
        beforeMount() {

        },
    }
</script>

<style>

</style>