<template>
    <b-col cols="4" class="spot bg-move "
           v-bind:class="markSpot(spot.item)"
           v-on:click="$emit('move',spot,playerSymbol,computerSymbol)"
    ></b-col>
</template>

<script>
    export default {
        name: "Spot",
        components: {},
        data() {
            return {
                playerSymbol: 'X',
                computerSymbol: 'O'
            }
        },
        props: {
            spot: {
                type: Object,
                required: true
            },
        },
        methods: {
            markSpot(spot) {
                if (spot === this.playerSymbol) {
                    return 'player-move'
                } else if (spot === this.computerSymbol) {
                    return 'computer-move'
                }
            },
            move(spot, playerSymbol, computerSymbol) {
                this.$emit('move', spot, playerSymbol, computerSymbol)
            }
        }
    }
</script>

<style>
    .spot {
        height: 150px;
        border: 5px solid black;
        cursor: pointer;
    }

    .games .spot {
        height: 75px;
    }

    .spot:hover {
        background-color: #d2cece;
    }

    .spot:nth-child(3n+1) {
        border-left: 0;
    }

    .spot:nth-child(3n+3) {
        border-right: 0
    }

    .spot:nth-child(-n+3) {
        border-top: 0
    }

    .spot:nth-child(n+7) {
        border-bottom: 0
    }

    .player-move {
        background-image: url("../assets/player.png");
        cursor: auto;
    }

    .player-move:hover, .computer-move:hover {
        background-color: inherit;
    }

    .computer-move {
        background-image: url("../assets/computer.png");
        cursor: auto;
    }

    .bg-move {
        background-repeat: no-repeat;
        background-size: 60%;
        background-position: center;
    }
</style>