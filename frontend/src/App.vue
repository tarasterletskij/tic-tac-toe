<template>
    <div id="app">
        <div class="container">
            <div class="row col-md-12">
                <router-link to="/" class="mx-auto">
                    <img alt="logo" src="@/assets/logo.png" width="350">
                </router-link>
            </div>
            <Menu/>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Menu from "./components/Menu";

    export default {
        name: 'App',
        components: {
            Menu
        },
    }
</script>

<style>
    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 15px;
    }
</style>
