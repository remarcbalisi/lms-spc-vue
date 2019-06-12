<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <lecturer-side-bar></lecturer-side-bar>
            <div class="primary flex-1">
                <h1>Visit Classroom</h1>
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
                api.call('get',`/api/lecturer/classroom/${this.$route.params.id}`).then(response=>{
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
