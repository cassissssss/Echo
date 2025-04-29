<script setup>
import { useFetchJson } from '@/composables/useFetchJson'
import { useRouter } from 'vue-router'

const { data: stories, error, loading } = useFetchJson('/stories')
const router = useRouter()

function openStory(story) {
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
        @click="openStory(story)"
        >
        <img :src="story.cover" class="cover" />
        <h2>{{ story.title }}</h2>
        <p>{{ story.summary }}</p>
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
  transition: transform 0.3s;
}
.story:hover {
  transform: scale(1.03);
}
.cover {
  width: 100%;
  border-radius: 8px;
  margin-bottom: 1rem;
}
</style>
