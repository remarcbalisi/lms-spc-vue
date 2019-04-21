<template>
    <aside class="w-1/5">
        <section class="mb-6">
            <h5 class="uppercase mb-2">User</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/user/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
        <section class="mb-6">
            <h5 class="uppercase mb-2">Role</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/role/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/role/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
        <section class="mb-6">
            <h5 class="uppercase mb-2">College</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/college/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/college/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
        <section class="mb-6">
            <h5 class="uppercase mb-2">Course</h5>
            <ul class="list-reset text-sm">
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/course/create">
                        Create
                    </router-link>
                </li>
                <li class="pb-4">
                    <router-link class="text-black no-underline" to="/admin/course/list">
                        List
                    </router-link>
                </li>
            </ul>
        </section>
    </aside>
</template>

<script>
    export default {
        methods: {
            logout() {
                auth.logout().then(({data})=>{
                   this.$router.push('/login');
                });
            }
        }
    }
</script>
