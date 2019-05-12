<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">

                <!--Academic year create start-->
                <div class="w-full">
                    <div v-if="errors" class="pb-4">
                        <p v-for="error in errors" class="text-red">{{error}}</p>
                    </div>
                    <h2>Academic Year</h2>
                    <form class="w-full max-w-md">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="from-date">
                                    From
                                </label>
                                <input v-model="from_date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="from_date" id="from-date" type="number" placeholder="From">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="to-date">
                                    To
                                </label>
                                <input v-model="to_date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="to_date" id="to-date" type="number" placeholder="To">
                            </div>
                        </div>
                        <button v-if="!creating" v-on:click="create" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Create
                        </button>
                        <img v-if="creating" width="30" height="30" src="/img/loading.gif">

                    </form>
                </div>
                <!--Academic Year create End-->

                <!--Academic Year Table Start-->
                <div class="w-full">
                    <table v-if="academic_years && !show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                        <thead>
                        <tr>
                            <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">From</th>
                            <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">To</th>
                            <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="academic_year in academic_years" class="hover:bg-blue-lightest">
                            <td class="py-4 px-6 border-b border-grey-light">{{academic_year.from_date}}</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{academic_year.to_date}}</td>
                            <td class="py-4 px-6 border-b border-grey-light">
                                <button v-on:click="addSemesterModal(academic_year)" class="bg-green rounded p-1 text-sm pl-2 pr-2">Add Semester</button>
                                <button v-on:click="editAcademicYearModal(academic_year)" class="bg-orange rounded p-1 text-sm pl-2 pr-2">Edit</button>
                                <button v-on:click="deleteAlert(academic_year)" class="bg-red rounded p-1 text-sm pl-2 pr-2">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <modal name="edit-ay-modal">
                        <div class="m-4">
                            <h2 class="mb-2">Edit AY {{ edit_ay.from_date + ' - ' + edit_ay.to_date }}</h2>
                            <form class="w-full max-w-md">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="from-date">
                                            From
                                        </label>
                                        <input v-model="edit_ay.from_date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="from_date" id="from-date" type="number" placeholder="From">
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="to-date">
                                            To
                                        </label>
                                        <input v-model="edit_ay.to_date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="to_date" id="to-date" type="number" placeholder="To">
                                    </div>
                                </div>
                                <button v-if="!updating_ay" v-on:click="updateAy" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                    Update
                                </button>
                                <img v-if="updating_ay" width="30" height="30" src="/img/loading.gif">

                            </form>
                        </div>
                    </modal>

                    <div v-if="show_loading" class="text-center">
                        <img width="40" height="40" src="/img/loading.gif">
                        <p>Getting Information .. </p>
                    </div>

                    <v-dialog/>

                </div>
                <!--Academic Year table End-->

                <!--Semester create Start-->
                <div class="w-full mb-5">
                    <div v-if="errors" class="pb-4">
                        <p v-for="error in errors" class="text-red">{{error}}</p>
                    </div>
                    <h2>Semester</h2>
                    <form class="w-full max-w-md">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="semester-name">
                                    Name
                                </label>
                                <input v-model="semester.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="semester-name" type="text" placeholder="Name">
                            </div>
                        </div>
                        <button v-if="!semester.creating" v-on:click="createSemester" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Create
                        </button>
                        <img v-if="semester.creating" width="30" height="30" src="/img/loading.gif">

                    </form>
                </div>
                <!--Semester create End-->

                <!--Semester Table Start-->
                <div class="w-full">
                    <table v-if="semesters && !semester.show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                        <thead>
                        <tr>
                            <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Name</th>
                            <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Slug</th>
                            <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="sem in semesters" class="hover:bg-blue-lightest">
                            <td class="py-4 px-6 border-b border-grey-light">{{sem.name}}</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{sem.slug}}</td>
                            <td class="py-4 px-6 border-b border-grey-light">
                                <button v-on:click="editSemesterModal(sem)" class="bg-orange rounded p-1 text-sm pl-2 pr-2">Edit</button>
                                <button v-on:click="deleteSemesterAlert(sem)" class="bg-red rounded p-1 text-sm pl-2 pr-2">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <modal name="edit-semester-modal">
                        <div class="m-4">
                            <h2 class="mb-2">Edit {{ edit_semester.name }} Semester</h2>
                            <form class="w-full max-w-md">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="edit-semester-name">
                                            Name
                                        </label>
                                        <input v-model="edit_semester.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="edit-semester-name" type="text" placeholder="Name">
                                    </div>
                                </div>
                                <button v-if="!edit_semester.creating" v-on:click="updateSemester" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                    Update
                                </button>
                                <img v-if="edit_semester.creating" width="30" height="30" src="/img/loading.gif">

                            </form>
                        </div>
                    </modal>

                    <div v-if="semester.show_loading" class="text-center">
                        <img width="40" height="40" src="/img/loading.gif">
                        <p>Getting Information .. </p>
                    </div>

                </div>
                <!--Semester table End-->

                <!--Academic Year Semester Start-->
                <modal name="add-semester-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Add Semester in AY {{ edit_ay.from_date }} {{ edit_ay.to_date }}</h2>
                        <form class="w-full max-w-md">
                            <div v-for="sem in semesters" class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        {{sem.name}}
                                    </label>
                                    <input v-bind:value="sem.id"  v-model="semester_arr" name="semester[]" type="checkbox"><br>
                                </div>
                            </div>
                            <button v-if="!edit_ay.creating" v-on:click="addSemesterToAy(edit_ay)" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                Add
                            </button>
                            <img v-if="edit_ay.creating" width="30" height="30" src="/img/loading.gif">

                        </form>
                    </div>
                </modal>
                <!--Academic Year Semester End-->
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
                from_date: null,
                to_date: null,
                errors: [],
                academic_years: [],
                show_loading: true,
                edit_ay: {
                    from_date: null,
                    to_date: null,
                },
                updating_ay: false,
                semester: {
                    name: '',
                    slug: '',
                    creating: false,
                    show_loading: true,
                },
                edit_semester: {
                    name: '',
                    slug: '',
                    creating: false,
                    show_loading: true,
                },
                semesters: [],
                semester_arr: [],
            };
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
                this.user = auth.user;
            });
            this.getAcademicYears();
            this.getSemesters();
        },
        methods: {
            getAcademicYears() {
              api.call('get', `/api/admin/academic-years`).then(response=>{
                  this.academic_years = response.data.data;
                  this.show_loading = false;
              });
            },
            getSemesters() {
                api.call('get', `/api/admin/semesters`).then(response=>{
                    this.semesters = response.data.data;
                    this.semester.show_loading = false;
                });
            },
            create() {
                this.creating = true;
                let data = {
                    from_date: this.from_date,
                    to_date: this.to_date,
                };
                api.call('post', '/api/admin/academic-years/store', data).then((response)=>{
                    this.creating = false;
                    if(response.data.status == 200) {
                        this.errors = [];
                        this.getAcademicYears();
                        alert(response.data.message);
                    }else{
                        this.errors.push(response.data.message);
                    }
                })

            },
            createSemester() {
                this.semester.creating = true;
                api.call('post', '/api/admin/semesters/store', this.semester).then((response)=>{
                    this.semester.creating = false;
                    if(response.data.status == 200) {
                        this.errors = [];
                        this.getSemesters();
                        this.semester.name = '';
                        alert(response.data.message);
                    }else{
                        this.errors.push(response.data.message);
                    }
                })
            },
            editAcademicYearModal(academic_year) {
                this.edit_ay = academic_year;
                this.$modal.show('edit-ay-modal');
            },
            editSemesterModal(semester) {
                this.edit_semester = semester;
                this.$modal.show('edit-semester-modal');
            },
            addSemesterModal(academic_year) {
                this.edit_ay = academic_year;
                this.$modal.show('add-semester-modal');
            },
            addSemesterToAy(edit_ay) {
                api.call('post', `/api/admin/academic-year-semester/${edit_ay.id}/store`, {semester_arr: this.semester_arr}).then(response=>{
                    if( response.data.status == 422 ) {
                        alert('Semester already exist in ' + edit_ay.from_date + ' - ' + edit_ay.to_date);
                    }
                });
            },
            updateAy() {
                this.updating_ay = true;
                api.call('post', `/api/admin/academic-years/update/${this.edit_ay.id}`, this.edit_ay).then(response=>{
                    this.updating_ay = false;
                    if(response.data.status == 200) {
                        this.errors = [];
                        alert(response.data.message);
                    }else{
                        this.errors.push(response.data.message);
                    }
                });
            },
            updateSemester() {
                this.edit_semester.show_loading = true;
                api.call('post', `/api/admin/semesters/update/${this.edit_semester.id}`, this.edit_semester).then(response=>{
                    this.edit_semester.show_loading = false;
                    if(response.data.status == 200) {
                        this.errors = [];
                        this.$modal.hide('edit-semester-modal');
                        this.getSemesters();
                        alert(response.data.message);
                    }else{
                        this.errors.push(response.data.message);
                        this.getSemesters();
                        this.$modal.hide('edit-semester-modal');
                    }
                });
            },
            deleteAlert(academic_year) {
                this.$modal.show('dialog', {
                    title: 'Warning!',
                    text: `Are you sure you want to delete AY ${academic_year.from_date} - ${academic_year.to_date}?`,
                    buttons: [
                        {
                            title: 'Deal with it',
                            handler: () => { this.destroy(academic_year) }
                        },
                        {
                            title: '',       // Button title
                            default: true,    // Will be triggered by default if 'Enter' pressed.
                            handler: () => { this.destroy(academic_year) } // Button click handler
                        },
                        {
                            title: 'Close'
                        }
                    ]
                })
            },
            destroy(academic_year) {
                api.call('get', `/api/admin/academic-years/destroy/${academic_year.id}`).then(response=>{
                    if(response.status === 200) {
                        this.getAcademicYears();
                        this.$modal.hide('dialog');
                        alert(response.data.message);
                    }
                })
            },
            deleteSemesterAlert(semester) {
                this.$modal.show('dialog', {
                    title: 'Warning!',
                    text: `Are you sure you want to delete ${semester.name} Semester?`,
                    buttons: [
                        {
                            title: 'Deal with it',
                            handler: () => { this.destroySemester(semester) }
                        },
                        {
                            title: '',       // Button title
                            default: true,    // Will be triggered by default if 'Enter' pressed.
                            handler: () => { this.destroySemester(semester) } // Button click handler
                        },
                        {
                            title: 'Close'
                        }
                    ]
                })
            },
            destroySemester(semester) {
                api.call('get', `/api/admin/semesters/destroy/${semester.id}`).then(response=>{
                    if(response.status === 200) {
                        this.getSemesters();
                        this.$modal.hide('dialog');
                        alert(response.data.message);
                    }
                })
            }
        }
    }
</script>
