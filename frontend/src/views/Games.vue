<template>
    <div>
        <div v-if="getLoading">
            <Loader/>
        </div>
        <div v-else>
            <h1>Games</h1>
            <br>
            <div v-if="allGames.length >0" class="games">
                <GameGrid
                        v-for="(grid,index) of allGames"
                        :key="index"
                        :grid="grid"
                        :gameId="grid.id"
                        :status="grid.status"
                />
            </div>
            <p v-else>No games</p>
        </div>
    </div>
</template>

<script>
    import GameGrid from "../components/GameGrid";
    import Loader from "../components/Loader";
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "Games",
        components: {
            Loader,
            GameGrid
        },
        computed: {
            ...mapGetters(['allGames', 'getLoading']),
        },
        methods: {
            ...mapActions(['getGames', 'startLoading']),
        },
        mounted() {
            this.getGames();
        },
        beforeMount() {

        },
    }
</script>

<style>

</style>