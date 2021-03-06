<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <h2>Colleges List</h2>
                <table v-if="colleges && !show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                    <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Name</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Slug</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="college in colleges" class="hover:bg-blue-lightest">
                        <td class="py-4 px-6 border-b border-grey-light">{{college.name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{college.slug}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <button v-on:click="editModal(college)" class="bg-orange rounded p-1 text-sm pl-2 pr-2">Edit</button>
                            <button v-on:click="deleteAlert(college)" class="bg-red rounded p-1 text-sm pl-2 pr-2">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <modal name="edit-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Edit role {{ edit_college.name }}</h2>
                        <form class="w-full max-w-md">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="college-name">
                                        College Name
                                    </label>
                                    <input v-model="edit_college.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="college-name" type="text" placeholder="College Name">
                                </div>
                            </div>
                            <button v-if="!updating" v-on:click="update(edit_college.id)" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
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
                colleges: [],
                edit_college: {},
                updating: false,
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
            this.getColleges();
        },
        methods: {
            getColleges() {
                api.call('get', '/api/admin/colleges').then(response=>{
                   if(response.status === 200) {
                       this.show_loading = false;
                       this.colleges = response.data.data;
                   }
                });
            },
            editModal(college) {
                this.edit_college = college;
                this.$modal.show('edit-modal');
            },
            update(college_id) {
                this.updating = true;
                api.call('post', `/api/admin/colleges/update/${college_id}`, {name: this.edit_college.name}).then(response=>{
                    if(response.status === 200) {
                        this.updating = false;
                        this.$modal.hide('edit-modal');
                        this.getColleges();
                        alert(response.data.message);
                    }
                })
            },
            deleteAlert(college) {
                this.$modal.show('dialog', {
                    title: 'Warning!',
                    text: `Are you sure you want to delete ${college.name}?`,
                    buttons: [
                        {
                            title: 'Deal with it',
                            handler: () => { this.destroy(college) }
                        },
                        {
                            title: '',       // Button title
                            default: true,    // Will be triggered by default if 'Enter' pressed.
                            handler: () => { this.destroy(college) } // Button click handler
                        },
                        {
                            title: 'Close'
                        }
                    ]
                })
            },
            destroy(college) {
                api.call('get', `/api/admin/colleges/destroy/${college.id}`).then(response=>{
                    if(response.status === 200) {
                        this.$modal.hide('edit-modal');
                        this.getColleges();
                        this.$modal.hide('dialog');
                        alert(response.data.message);
                    }
                })
            }
        }
    }
</script>
