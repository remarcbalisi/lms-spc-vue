<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <h1>Test</h1>
            </div>
        </main>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                authenticated: auth.check(),
                user: auth.user
            };
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
                this.user = auth.user;
            });
        },
        methods: {
            logout() {
                auth.logout().then(({data})=>{
                    this.$router.push('/login');
                });

            }
        }
    }
</script>
