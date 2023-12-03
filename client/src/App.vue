<!-- src/App.vue -->
<template>
  <div id="app">
    <div class="flex">
      <aside class="w-1/5 border-r-2 border-r-gray-100 h-screen">
        <h1 class="p-5 text-2xl font-bold">Easy API</h1>
        <ul class="px-5">
          <li>
            <router-link to="/projects">Projects</router-link>
          </li>
        </ul>
      </aside>
      <div class="flex flex-col w-full">
        <nav class="p-5 border-b-2 border-b-gray-100"></nav>
        <main class="p-5">
          <router-view></router-view>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  color: #2c3e50;
}
</style>
