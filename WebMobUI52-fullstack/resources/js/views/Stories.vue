<script setup>
import { useFetchJson } from '@/composables/useFetchJson'
import { useRouter } from 'vue-router'

const { data: stories, error, loading } = useFetchJson('/stories')
const router = useRouter()

function openStory(story) {
  if (!story.playable) return
  router.push(`/story/${story.id}`)
}
</script>


<template>
  <div class="page">
    <h1 class="title">Choisis ton aventure</h1>
    <div class="stories">
      <div
        v-for="story in stories"
        :key="story.id"
        class="story"
        :class="{ inactive: !story.playable }"
        @click="openStory(story)"
      >
        <img :src="story.cover" class="cover" />
        <h2>{{ story.title }}</h2>
        <p v-if="story.playable">{{ story.summary }}</p>
        <p v-else class="soon">En cours d'écriture...</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page {
  background: #22092c;
  color: white;
  padding: 2rem;
  font-family: 'VT323', monospace;
}
.title {
  font-size: 3rem;
  text-align: center;
  margin-bottom: 2rem;
}
.stories {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center;
}
.story {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  padding: 1rem;
  border-radius: 10px;
  width: 300px;
  cursor: pointer;
}
.story.inactive {
  opacity: 0.4;
  cursor: not-allowed;
}
.cover {
  width: 100%;
  border-radius: 8px;
}
.soon {
  font-style: italic;
  opacity: 0.7;
}
</style>
