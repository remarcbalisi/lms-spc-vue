<template>
    <div>
        <landing-nav-bar></landing-nav-bar>
        <div class="container mx-auto w-1/4 mt-6">
            <div class="w-full max-w-xs">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h2 class="mb-5 text-center text-red-darker" >Log In</h2>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input v-model="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Email">
                    </div>
                    <div class="mb-6">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input v-model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    </div>
                    <div class="flex items-center justify-between">
                        <button v-if="!logging_in" v-on:click="login" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Sign In
                        </button>
                        <img v-if="logging_in" class="w-1/6" src="/img/loading.gif">
                        <a class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker" href="#">
                            Forgot Password?
                        </a>
                    </div>
                </form>
                <p class="text-center text-grey text-xs">
                    ©2019 St.Peter's College. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                logging_in: false,
            }
        },

        methods: {
            login() {
                this.logging_in = true;
                let data = {
                    email: this.email,
                    password: this.password
                };

                axios.post('/api/login', data)
                    .then(({data}) => {
                        this.logging_in = false;
                        auth.login(data.token, data.user);
                        this.$router.push(`/${data.user.role.slug}/home`);
                    })
                    .catch(({response}) => {
                        this.logging_in = false;
                        alert(response.data.message);
                    });
            }
        }
    }
</script>
