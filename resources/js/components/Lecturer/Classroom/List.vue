<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <lecturer-side-bar></lecturer-side-bar>
            <div class="primary flex-1">
                <h2>Classroom List</h2>
                <table v-if="classrooms && !show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                    <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Subject</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Section</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Academic Year and Sem</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="classroom in classrooms" class="hover:bg-blue-lightest">
                        <td class="py-4 px-6 border-b border-grey-light">
                            <a href="javascript:;" v-on:click="viewClassroom(classroom)">
                                {{classroom.subject.name}}
                            </a>
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light">{{classroom.section.name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{classroom.academic_yr_semester.full_name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <button v-on:click="visitClassroom(classroom)" class="bg-purple rounded p-1 text-sm pl-2 pr-2">Visit</button>
                            <button v-on:click="addFacultyModal(classroom)" class="bg-blue rounded p-1 text-sm pl-2 pr-2">Add Faculty</button>
                            <button v-on:click="addLearnerModal(classroom)" class="bg-green rounded p-1 text-sm pl-2 pr-2">Add Student</button>
                            <button v-on:click="editModal(classroom)" class="bg-orange rounded p-1 text-sm pl-2 pr-2">Edit</button>
                            <button v-on:click="deleteAlert(classroom)" class="bg-red rounded p-1 text-sm pl-2 pr-2">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <modal name="edit-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Edit Classroom</h2>
                        <form class="w-full max-w-md">

                            <button v-if="!updating" v-on:click="" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Update
                            </button>
                            <button v-if="!updating" v-on:click="$modal.hide('edit-modal')" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Close
                            </button>
                            <img v-if="updating" width="30" height="30" src="/img/loading.gif">

                        </form>
                    </div>
                </modal>

                <modal name="add-faculty-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Add Faculty</h2>
                        <form class="w-full max-w-md">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="faculty">
                                        Faculty
                                    </label>
                                    <div class="relative">
                                        <select v-model="classroom_user.user_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="faculty" id="faculty">
                                            <option v-for="lecturer in lecturers" v-bind:value="lecturer.id">{{ lecturer.first_name + ' ' + lecturer.last_name }}</option>
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button v-if="!updating" v-on:click="addFacultyModal(null, true)" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Add
                            </button>
                            <button v-if="!updating" v-on:click="$modal.hide('add-faculty-modal')" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Close
                            </button>
                            <img v-if="updating" width="30" height="30" src="/img/loading.gif">

                        </form>
                    </div>
                </modal>

                <modal name="add-learner-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Add Learner</h2>
                        <form class="w-full max-w-md">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="learner">
                                        Learner
                                    </label>
                                    <div class="relative">
                                        <select v-model="classroom_user.user_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey" name="learner" id="learner">
                                            <option v-for="learner in learners" v-bind:value="learner.id">{{ learner.first_name + ' ' + learner.last_name }}</option>
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button v-if="!updating" v-on:click="addLearnerModal(null, true)" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Add
                            </button>
                            <button v-if="!updating" v-on:click="$modal.hide('add-learner-modal')" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
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
                classrooms: [],
                classroom_user: {
                    user_id: null,
                    classroom_id: null,
                    is_enrolled: null,
                },
                updating: false,
                lecturers: [],
                learners: [],
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
            this.getClassrooms();
        },
        methods: {
            viewClassroom(classroom) {
                this.$router.push(`/lecturer/classroom/view/${classroom.id}`);
            },
            visitClassroom(classroom) {
                this.$router.push(`/lecturer/classroom/visit/${classroom.id}`);
            },
            getClassrooms() {
                api.call('get', '/api/lecturer/classrooms').then(response=>{
                   if(response.status === 200) {
                       this.show_loading = false;
                       this.classrooms = response.data.data;
                   }
                });
            },
            editModal(role) {
                this.edit_role = role;
                this.$modal.show('edit-modal');
            },
            getFacultyUsers() {
                api.call('get','/api/lecturer/users/by-role/lecturer').then(response=>{
                    this.lecturers = response.data.data;
                });
            },
            addFacultyModal(classroom = null, store=false) {
                if( store ) {
                    api.call('post', '/api/lecturer/classroom-user/store', this.classroom_user).then(response=>{
                        if( response.status === 200 ) {
                            alert(response.data.message);
                        }else{
                            alert(response.data.message);
                        }
                    });
                }else{
                    this.classroom_user.classroom_id = classroom.id;
                    this.getFacultyUsers();
                    this.$modal.show('add-faculty-modal');
                }
            },
            getLearnerUsers() {
                api.call('get','/api/lecturer/users/by-role/learner').then(response=>{
                    this.learners = response.data.data;
                });
            },
            addLearnerModal(classroom = null, store=false) {
                if( store ) {
                    api.call('post', '/api/lecturer/classroom-user/store', this.classroom_user).then(response=>{
                        if( response.status === 200 ) {
                            alert(response.data.message);
                        }else{
                            alert(response.data.message);
                        }
                    });
                }else{
                    this.classroom_user.classroom_id = classroom.id;
                    this.getLearnerUsers();
                    this.$modal.show('add-learner-modal');
                }
            },
            update(role_id) {
                this.updating = true;
                api.call('post', `/api/lecturer/roles/update/${role_id}`, {name: this.edit_role.name}).then(response=>{
                    if(response.status === 200) {
                        this.updating = false;
                        this.$modal.hide('edit-modal');
                        this.getRoles();
                        alert(response.data.message);
                    }
                })
            },
            deleteAlert($role) {
                this.$modal.show('dialog', {
                    title: 'Warning!',
                    text: `Are you sure you want to delete ${$role.name}?`,
                    buttons: [
                        {
                            title: 'Deal with it',
                            handler: () => { this.destroy($role) }
                        },
                        {
                            title: '',       // Button title
                            default: true,    // Will be triggered by default if 'Enter' pressed.
                            handler: () => { this.destroy($role) } // Button click handler
                        },
                        {
                            title: 'Close'
                        }
                    ]
                })
            },
            destroy($role) {
                api.call('get', `/api/lecturer/roles/destroy/${$role.id}`).then(response=>{
                    if(response.status === 200) {
                        this.$modal.hide('edit-modal');
                        this.getRoles();
                        this.$modal.hide('dialog');
                        alert(response.data.message);
                    }
                })
            }
        }
    }
</script>
