<template>
    <div class="errors">
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        <h1>404</h1>
                        <div class="page-description">
                            The page you were looking for could not be found.
                        </div>
                        <div class="page-search">

                            <div class="mt-3">
                                <router-link to="/dashboard">Back to dashboard</router-link>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "error404"
    }
</script>

<style scoped>

</style>