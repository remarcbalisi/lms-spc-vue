<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <h2>Roles List</h2>
                <table v-if="roles && !show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                    <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Name</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Slug</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="role in roles" class="hover:bg-blue-lightest">
                        <td class="py-4 px-6 border-b border-grey-light">{{role.name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{role.slug}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <button v-on:click="editModal(role)" class="bg-orange rounded p-1 text-sm pl-2 pr-2">Edit</button>
                            <button v-on:click="deleteAlert(role)" class="bg-red rounded p-1 text-sm pl-2 pr-2">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <modal name="edit-modal">
                    <div class="m-4">
                        <h2 class="mb-2">Edit role {{ edit_role.name }}</h2>
                        <form class="w-full max-w-md">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="role-name">
                                        Role Name
                                    </label>
                                    <input v-model="edit_role.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" name="name" id="role-name" type="text" placeholder="Role Name">
                                </div>
                            </div>
                            <button v-if="!updating" v-on:click="update(edit_role.id)" class="bg-red-darker hover:bg-red-darkest text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
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
                roles: [],
                edit_role: {},
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
            editModal(role) {
                this.edit_role = role;
                this.$modal.show('edit-modal');
            },
            update(role_id) {
                this.updating = true;
                api.call('post', `/api/admin/roles/update/${role_id}`, {name: this.edit_role.name}).then(response=>{
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
                api.call('get', `/api/admin/roles/destroy/${$role.id}`).then(response=>{
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
