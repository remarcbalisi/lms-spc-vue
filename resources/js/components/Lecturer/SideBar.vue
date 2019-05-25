<template>
    <aside class="w-1/5">
        <section class="mb-6">
            <h5 class="uppercase mb-2">{{ user.first_name }}</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <a href="javascript:;" v-on:click="logout" class="text-black no-underline">
                        Logout
                    </a>
                </li>
            </ul>
        </section>

        <section class="mb-6">
            <h5 class="uppercase mb-2">Course</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/lecturer/course/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/lecturer/course/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>

        <section class="mb-6">
            <h5 class="uppercase mb-2">Subjects</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/lecturer/subject/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/lecturer/subject/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
        <section class="mb-6">
            <h5 class="uppercase mb-2">Sections</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/section/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/section/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
        <section class="mb-6">
            <h5 class="uppercase mb-2">Classrooms</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/classroom/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/classroom/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
    </aside>
</template>

<script>
    export default {
        data() {
            return{
                user: {
                    first_name: '',
                    last_name: '',
                },
            }
        },
        mounted() {
            auth.getUser().then(response=>{
                this.user = response.data;
            });
        },
        methods: {
            logout() {
                auth.logout().then(({data})=>{
                   this.$router.push('/login');
                });
            }
        }
    }
</script>
