<script setup lang="ts">
    import axios from "axios"
    axios.get('http://localhost:80/api/portfolios/1')
        .then(function (res) {
            console.log(JSON.stringify(res.data))
        })
</script>

<template>
  <header>
      <div>
        <h1 class="text-3xl font-bold text-center"> Finizens - Prueba Técnica </h1>
      </div>
  </header>

  <main>
  </main>
</template>

