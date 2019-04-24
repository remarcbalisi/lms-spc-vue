<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <form class="w-full max-w-md">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="first-name">
                                First Name
                            </label>
                            <input v-model="new_user.first_name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="first_name" id="first-name" type="text" placeholder="First Name">
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="middle-name">
                                Middle Name
                            </label>
                            <input v-model="new_user.middle_name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="middle_name" id="middle-name" type="text" placeholder="Middle Name">
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="last-name">
                                Last Name
                            </label>
                            <input v-model="new_user.last_name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="last_name" id="last-name" type="text" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="password">
                                Password
                            </label>
                            <input v-model="new_user.password" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="password" id="password" type="password" placeholder="******************">
                            <p class="text-grey-dark text-xs italic">Make it as long and as crazy as you'd like</p>
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="confirm-password">
                                Password
                            </label>
                            <input v-model="new_user.password_confirmation" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="password_confirmation" id="confirm-password" type="password" placeholder="******************">
                            <p v-if="new_user.password != new_user.password_confirmation" class="text-red text-xs italic">Password didn't match!</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-2">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="role-id">
                                Role
                            </label>
                            <div class="relative">
                                <select v-model="new_user.role_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="role_id" id="role-id">
                                    <option v-for="role in roles" v-bind:value="role.slug">{{ role.name }}</option>
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div v-if="new_user.role_id == 'learner'" class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-state">
                                Course
                            </label>
                            <div class="relative">
                                <select v-model="new_user.course_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" id="grid-state">
                                    <option value="cs">New Mexico</option>
                                    <option>Missouri</option>
                                    <option>Texas</option>
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button v-on:click="store" type="button">Create</button>
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
                new_user: {
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    role_id: '',
                    course_id: '',
                    password: '',
                    password_confirmation: '',
                },
                empty_fields: [],
                roles : [],
            };
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
                this.user = auth.user;
            });
            Event.$on('userLoggedOut', () => {
                this.$router.push('/login');
            });
            this.getRoles();
        },
        methods: {
            getRoles() {
                api.call('get', '/api/admin/roles').then(response=>{
                    if(response.status === 200) {
                        this.show_loading = false;
                        this.roles = response.data.data;
                    }
                });
            },
            logout() {
                auth.logout();

            },
            validate() {
                this.empty_fields = [];
                Object.keys(this.new_user).forEach(key => {
                    let value = this.new_user[key];
                    if( !value ) {
                        if( key == "course_id" && this.new_user.role_id == "learner" ) {
                            this.empty_fields.push(key);
                        }
                        else if( key == "course_id" && this.new_user.role_id != "learner" ) {
                            //
                        }
                        else{
                            this.empty_fields.push(key);
                        }
                    }
                });
                if ( this.new_user.password != this.new_user.password_confirmation ) {
                    this.empty_fields.push('password_confirmation');
                    alert('Your password didn\'t match');
                }
                return this.empty_fields;
            },
            store() {
                this.validate();
                console.log();
                if( this.validate().length == 0 ) {
                    api.call('post', `/api/admin/users/store`, this.new_user).then(response=>{
                        if(response.status == 200) {
                            alert(response.data.message);
                        }
                    });
                }
            }
        }
    }
</script>
