<template>
    <nav class="flex items-center justify-between flex-wrap bg-red-darker p-6">
        <div class="flex items-center flex-no-shrink text-white mr-6">
            <img class="fill-current h-8 w-8 mr-2" width="54" height="54" src="/img/spc_logo.png">
            <span class="font-semibold text-xl tracking-tight">
                <router-link class="font-semibold text-xl tracking-tight text-white no-underline" to="/">St. Peter's College</router-link>
            </span>
        </div>
        <div class="block lg:hidden">
            <button class="flex items-center px-3 py-2 border rounded text-teal-lighter border-teal-light hover:text-white hover:border-white">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
            </button>
        </div>
        <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
            <div class="text-sm lg:flex-grow">
                <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-white text-base hover:text-grey-darker mr-4 no-underline">
                    Home
                </a>
                <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-white text-base hover:text-grey-darker mr-4 no-underline">
                    About
                </a>
                <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-white text-base hover:text-grey-darker mr-4 no-underline">
                    Academics
                </a>
            </div>
            <div>
                <router-link to="/login" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-white mt-4 lg:mt-0 no-underline">My.SPC</router-link>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {

    }
</script>
