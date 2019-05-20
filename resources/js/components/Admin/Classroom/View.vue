<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <admin-side-bar></admin-side-bar>
            <div class="primary flex-1">
                <h1>{{ classroom.full_name }}</h1>

                <h3 class="mt-3">Faculty: {{ assigned_lecturer.first_name }} {{ assigned_lecturer.middle_name }} {{ assigned_lecturer.last_name }}</h3>

                <h3 class="mt-3">Class List</h3>
                <table v-if="learners && !show_loading" class="text-left m-4 w-full" style="border-collapse:collapse">
                    <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Name</th>
                        <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Course</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="learner in learners" class="hover:bg-blue-lightest">
                        <td class="py-4 px-6 border-b border-grey-light">{{learner.first_name}} {{learner.last_name}}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{learner.course.name}}</td>
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
                classroom: {
                    section_id: null,
                    subject_id: null,
                    academic_yr_semester_id: null,
                },
                assigned_lecturer: {},
                learners: [],
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
            this.getClassroom();
        },
        methods: {
            logout() {
                auth.logout();
            },
            getClassroom() {
                api.call('get',`/api/admin/classroom/${this.$route.params.id}`).then(response=>{
                    this.classroom = response.data.data;
                    _.forEach(response.data.data.classroom_users, (element, i)=>{
                       if( element.user.role.slug == 'lecturer' ) {
                           this.assigned_lecturer = element.user;
                       }else{
                           this.learners.push(element.user);
                       }
                    });
                });
            }
        }
    }
</script>
