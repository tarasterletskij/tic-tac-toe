<template>
    <div class="game-grid">
        <p>Status: <b>{{status}}</b></p>
        <b-col align-self="center">
            <b-row>
                <Spot
                        v-for="(item, index) of grid.board"
                        :key="index"
                        :spot="{'index':index, 'item':item}"
                        @move="move"
                />
            </b-row>
            <br>
            <b-button class="btn btn-danger"
                      v-on:click="deleteGame(grid.id)"
            >Remove
            </b-button>
        </b-col>
    </div>
</template>

<script>
    import Spot from "./Spot";
    import {mapActions} from "vuex";

    export default {
        name: "GameGrid",
        components: {
            Spot,
        },
        props: {
            gameId: {
                required: true
            },
            status: {
                required: true
            },
            grid: {
                type: Object,
                required: true
            },
        },
        methods: {
            ...mapActions(['moveGame', 'deleteGame']),

            move(spot, playerSymbol, computerSymbol) {
                if (!this.grid.isFinish) {
                    if ([computerSymbol, playerSymbol].includes(spot.item)) {
                        alert('This spot is busy');
                    } else {
                        this.grid.board = this.replaceAt(this.grid.board, spot.index, playerSymbol);
                        this.moveGame({id: this.gameId, board: this.grid.board})
                    }
                } else {
                    alert('Game is finish! Status: ' + this.status);
                }

            },
            replaceAt(string, index, replace) {
                return string.substring(0, index) + replace + string.substring(index + 1);
            }
        }
    }
</script>

<style>
    .game-grid {
        display: inline-block;
        width: 50%;
        margin: 25px;
    }

    .games .game-grid {
        display: inline-block;
        width: 20%;
        margin: 25px;
    }
</style>