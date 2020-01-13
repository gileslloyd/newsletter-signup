<template>

    <div>

        <section class="hero is-primary is-small">
            <div class="hero-head">
                <nav class="navbar">
                    <div class="container">
                        <div class="navbar-brand">
                            <span class="navbar-burger burger" data-target="navbarMenuHeroA">
                            <span></span>
                            <span></span>
                            <span></span>
                          </span>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="hero-body">
                <div class="container has-text-centered">
                    <h2 class="title">
                        Newsletter Sign-up
                    </h2>
                </div>
            </div>

        </section>

        <section class="section">

            <div class="container">

                <router-view></router-view>

            </div>

        </section>

    </div>

</template>

<script>
export default {

    name: 'app',

}
</script>

<style>

    .primary-logo {
        width: 200px;
    }

    .list {
        margin-left: 0 !important;
    }

</style>
