<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <lecturer-side-bar></lecturer-side-bar>
            <div class="primary flex-1">
                <p v-if="errors.length">
                    Please correct the following error(s):<b/>
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
                </p>

                <form @submit="checkForm" class="w-full">
                    <div class="flex items-center border-b border-b-2 border-teal-500 py-2">
                        <textarea v-model="post.body" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" name="body" placeholder="What's in your mind?" aria-label="What's in your mind?"></textarea>
                        <button v-bind:class="[post.body == '' || post.body == null ? 'cursor-not-allowed' : '', 'flex-shrink-0 bg-blue hover:bg-blue-dark border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded']" type="submit">
                            Post
                        </button>
                    </div>
                    <div class="flex items-center p-2">
                        <div class="w-3/4">
                            <input v-model="post.post_category" id="general" value="general" type="radio" class="mr-1" />General
                            <input v-model="post.post_category" id="announcement" value="room_announcement" type="radio" class="ml-3 mr-1" />Announcement
                            <input v-model="post.post_category" id="course_material" value="course_material" type="radio" class="ml-3 mr-1" />Course Material
                        </div>
                        <div class="w-1/4">
                            <label for="file_input">
                                <font-awesome-icon icon="paperclip" />
                                <small>Attach File/Image/Video</small>
                            </label>
                            <input id="file_input" type="file" class="hidden" >
                        </div>
                    </div>
                </form>

                <div class="flex mb-4 mt-4">
                    <div class="w-3/5 bg-gray-400 h-12 border border-gray rounded p-3 mx-auto shadow-md">
                        Hello World
                    </div>
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
                classroom: {
                    section_id: null,
                    subject_id: null,
                    academic_yr_semester_id: null,
                },
                assigned_lecturer: {},
                learners: [],
                post: {
                    title : null,
                    body: null,
                    classroom_id: this.$route.params.id,
                    post_type: 'classroom',
                    post_category: 'general',
                },
                errors: [],
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
            },
            createPost() {
                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                });
                api.call('post', `/api/lecturer/post/store`, this.post).then(response=>{
                    loader.hide();
                    if( response.status == 200 ) {
                        alert(response.data.message);
                        this.post =  {
                            title : null,
                            body: null,
                            classroom_id: this.$route.params.id,
                            post_type: 'classroom',
                            post_category: 'general',
                        };
                    }else {
                        alert("Error in Posting");
                    }
                });
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.post.body) {
                    this.errors.push("Post Content should not be empty.");
                }

                if (!this.errors.length) {
                    e.preventDefault();
                    this.createPost();
                    return true;
                }

                e.preventDefault();
            },
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
        }
    }
</script>
