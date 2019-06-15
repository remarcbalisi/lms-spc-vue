<template>
    <div>
        <header class="py-6">
            <img width="50" height="50" src="/img/spc_logo.png">
        </header>
        <main class="flex">
            <learner-side-bar></learner-side-bar>
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
                            <label for="file_input">
                                <font-awesome-icon icon="paperclip" />
                                <small>Attach File/Image/Video</small>
                            </label>
                            <input id="file_input" type="file" class="hidden" >
                        </div>
                    </div>
                </form>

                <div v-for="p in posts" class="flex mb-4 mt-4">
                    <div class="w-4/5 bg-gray-400 border border-gray rounded p-2 mx-auto shadow">
                        <h5>
                            {{p.posted_by.first_name}} {{p.posted_by.middle_name}} {{p.posted_by.last_name}}
                        </h5>
                        <h6 class="mb-2 text-red-dark">{{p.post_category.name}}</h6>
                        <p>
                            {{p.body}}
                        </p>
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
                post: {
                    title : null,
                    body: null,
                    classroom_id: this.$route.params.id,
                    post_type: 'classroom',
                    post_category: 'general',
                },
                errors: [],
                posts: [],
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
            this.getPosts();
        },
        methods: {
            logout() {
                auth.logout();
            },
            getPosts() {
                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'bars',
                });
                api.call('get', `/api/learner/post/classroom/list/${this.$route.params.id}`).then(response=>{
                    console.log(response);
                    this.posts = response.data.data;
                    loader.hide();
                });
            },
            createPost() {
                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'bars',
                });
                api.call('post', `/api/learner/post/store`, this.post).then(response=>{
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
                        this.getPosts();
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
