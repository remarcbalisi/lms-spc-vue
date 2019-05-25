<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <lecturer-side-bar></lecturer-side-bar>
            <div class="primary flex-1">
                <div v-if="errors" class="pb-4">
                    <p v-for="error in errors" class="text-red">{{error}}</p>
                </div>
                <form class="w-full max-w-md">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="course-name">
                                Course Name
                            </label>
                            <input v-model="name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="course-name" type="text" placeholder="Course Name">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="college-id">
                                College
                            </label>
                            <div class="relative">
                                <select v-model="college_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="college_id" id="college-id">
                                    <option v-for="college in colleges" v-bind:value="college.id">{{ college.name }}</option>
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
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
                creating: false,
                name: '',
                college_id: null,
                errors: [],
                colleges: [],
            };
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
                this.user = auth.user;
            });
            this.getColleges();
        },
        methods: {
            create() {
                this.creating = true;
                let data = {
                    name: this.name,
                    college_id: this.college_id,
                };
                api.call('post', '/api/lecturer/courses/store', data).then((response)=>{
                    this.creating = false;
                    if(response.status == 200) {
                        this.errors = [];
                        alert(response.data.message);
                    }else{
                        for(let prop in response.data.errors) {
                            this.errors.push(response.data.errors[prop][0]);
                        }
                    }
                })

            },
            getColleges() {
                api.call('get', '/api/lecturer/colleges').then(response=>{
                    this.colleges = response.data.data;
                });
            }
        }
    }
</script>
