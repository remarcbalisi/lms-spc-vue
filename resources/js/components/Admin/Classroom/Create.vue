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
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="section">
                                Section
                            </label>
                            <div class="relative">
                                <select v-model="classroom.section_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="section" id="section">
                                    <option v-for="section in sections" v-bind:value="section.id">{{ section.name }}</option>
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="subject">
                                Subject
                            </label>
                            <div class="relative">
                                <select v-model="classroom.subject_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="subject" id="subject">
                                    <option v-for="subject in subjects" v-bind:value="subject.id">{{ subject.name }}</option>
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="subject">
                                Academic Year and Semester
                            </label>
                            <div class="relative">
                                <select v-model="classroom.academic_yr_semester_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="subject" id="subject">
                                    <option v-for="academic_yr_semester in academic_yr_semesters" v-bind:value="academic_yr_semester.id">{{ academic_yr_semester.full_name }}</option>
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
                sections : [],
                subjects: [],
                academic_yr_semesters : [],
                classroom: {
                    section_id : null,
                    subject_id: null,
                    academic_yr_semester_id: null,
                },
                errors: [],
            };
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
                this.user = auth.user;
            });
            this.getSections();
            this.getSubjects();
            this.getAcademicYrSemesters();
        },
        methods: {
            getSections() {
              api.call('get', '/api/admin/sections').then(response=>{
                  this.sections = response.data.data;
              });
            },
            getSubjects() {
                api.call('get', '/api/admin/subjects').then(response=>{
                    this.subjects = response.data.data;
                });
            },
            getAcademicYrSemesters() {
                api.call('get', '/api/admin/academic-year-semester').then(response=>{
                    this.academic_yr_semesters = response.data;
                });
            },
            create() {
                this.creating = true;
                api.call('post', '/api/admin/classroom/store', this.classroom).then((response)=>{
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

            }
        }
    }
</script>
