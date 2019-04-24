<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <h2>Courses List</h2>
                <table v-if="courses && !show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                    <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Name</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Slug</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">College</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="course in courses" class="hover:bg-blue-lightest">
                        <td class="py-4 px-6 border-b border-grey-light">{{course.name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{course.slug}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{course.college.name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <button v-on:click="editModal(course)" class="bg-orange rounded p-1 text-sm pl-2 pr-2">Edit</button>
                            <button v-on:click="deleteAlert(course)" class="bg-red rounded p-1 text-sm pl-2 pr-2">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <modal name="edit-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Edit course {{ edit_course.name }}</h2>
                        <form class="w-full max-w-md">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="course-name">
                                        Course Name
                                    </label>
                                    <input v-model="edit_course.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="course-name" type="text" placeholder="Course Name">
                                </div>
                            </div>

                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="college-id">
                                        College
                                    </label>
                                    <div class="relative">
                                        <select v-model="college_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="college_id" id="college-id">
                                            <option v-for="college in colleges" v-bind:value="college.id" v-bind:selected="college.id === edit_course.college_id">{{ college.name }}</option>
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button v-if="!updating" v-on:click="update(edit_course.id)" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Update
                            </button>
                            <button v-if="!updating" v-on:click="$modal.hide('edit-modal')" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Close
                            </button>
                            <img v-if="updating" width="30" height="30" src="/img/loading.gif">

                        </form>
                    </div>
                </modal>

                <v-dialog/>

                <div v-if="show_loading" class="text-center">
                    <img width="40" height="40" src="/img/loading.gif">
                    <p>Getting Information .. </p>
                </div>
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
                errors: [],
                show_loading : true,
                courses: [],
                edit_course: {},
                updating: false,
                colleges: [],
                college_id: null,
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
            this.getCourses();
            this.getColleges();
        },
        methods: {
            getCourses() {
                api.call('get', '/api/admin/courses').then(response=>{
                   if(response.status === 200) {
                       this.show_loading = false;
                       this.courses = response.data.data;
                   }
                });
            },
            getColleges() {
                api.call('get', '/api/admin/colleges').then(response=>{
                    this.colleges = response.data.data;
                });
            },
            editModal(course) {
                this.edit_course = course;
                this.$modal.show('edit-modal');
            },
            update(course_id) {
                this.updating = true;
                let data = {
                    name: this.edit_course.name,
                    college_id: this.college_id,
                }
                api.call('post', `/api/admin/courses/update/${course_id}`, data).then(response=>{
                    if(response.status === 200) {
                        this.updating = false;
                        this.$modal.hide('edit-modal');
                        this.getCourses();
                        alert(response.data.message);
                    }
                })
            },
            deleteAlert(course) {
                this.$modal.show('dialog', {
                    title: 'Warning!',
                    text: `Are you sure you want to delete ${course.name}?`,
                    buttons: [
                        {
                            title: 'Deal with it',
                            handler: () => { this.destroy(course) }
                        },
                        {
                            title: '',       // Button title
                            default: true,    // Will be triggered by default if 'Enter' pressed.
                            handler: () => { this.destroy(course) } // Button click handler
                        },
                        {
                            title: 'Close'
                        }
                    ]
                })
            },
            destroy(course) {
                api.call('get', `/api/admin/courses/destroy/${course.id}`).then(response=>{
                    if(response.status === 200) {
                        this.$modal.hide('edit-modal');
                        this.getCourses();
                        this.$modal.hide('dialog');
                        alert(response.data.message);
                    }
                })
            }
        }
    }
</script>
