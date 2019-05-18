<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <div v-if="errors" class="pb-4">
                    <p v-for="error in errors" class="text-red">{{error}}</p>
                </div>
                <form class="w-full max-w-md">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="section-name">
                                Section Name
                            </label>
                            <input v-model="section.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="section-name" type="text" placeholder="Section Name">
                        </div>
                    </div>
                    <button v-if="!creating" v-on:click="create" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Create
                    </button>
                    <img v-if="creating" width="30" height="30" src="/img/loading.gif">

                </form>
            </div>
        </main>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                authenticated: auth.check(),
                user: auth.user,
                section: {
                    name: '',
                    slug: '',
                },
                creating: false,
                errors: [],
            };
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
                this.user = auth.user;
            });
            Event.$on('userLoggedOut', () => {
                this.authenticated = false;
                this.$router.push('/login');
            });
        },
        methods: {
            logout() {
                auth.logout();
            },
            create() {
                this.creating = true;
                this.errors = [];
                api.call('post', '/api/admin/section/store', this.section).then(response=>{
                    this.creating = false;
                    if( response.status == 422 ) {
                        this.errors = response.data.errors;
                    }
                    else if( response.data.status == 422 ) {
                        this.errors.push(response.data.message);
                    }
                    else{
                        alert(response.data.message);
                    }
                });
            }
        }
    }
</script>
