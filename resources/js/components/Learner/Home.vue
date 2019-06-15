<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <learner-side-bar></learner-side-bar>
            <div class="primary flex-1">
                <h1>Your Classrooms</h1>
                <table v-if="classroom_users" class="text-left m-4 w-full" style="border-collapse:collapse">
                    <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Subject</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Section</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Academic Year and Sem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="classroom_user in classroom_users" class="hover:bg-blue-lightest">
                        <td class="py-4 px-6 border-b border-grey-light">
                            <a href="javascript:;" v-on:click="viewClassroom(classroom)">
                                {{classroom_user.classroom.subject.name}}
                            </a>
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light">{{classroom_user.classroom.section.name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{classroom_user.classroom.academic_yr_semester.full_name}}</td>
                    </tr>
                    </tbody>
                </table>
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
                classroom_users: [],
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
            this.myClassrooms();
        },
        methods: {
            logout() {
                auth.logout();
            },
            myClassrooms() {
                api.call('get', '/api/learner/my-classrooms').then(response=>{
                    console.log(response);
                    this.classroom_users = response.data.data;
                });
            }
        }
    }
</script>
