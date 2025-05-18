import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useFetchJson } from '@/composables/useFetchJson'
import { addTrait, getFinalPersonality, resetTraits } from '@/composables/usePersonalityTracker'

export function useChapterLogic() {
    const route = useRoute()
    const router = useRouter()

    const storyId = ref(route.params.storyId ?? 1)
    const data = ref(null)
    const error = ref(null)
    const showContent = ref(false)
    const showEndingModal = ref(false)

    const normalizePersona = str =>
        str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase()

    async function fetchChapter() {
        showContent.value = false
        showEndingModal.value = false

        const chapterId = route.params.chapterId
        const endpoint = chapterId
            ? `/chapters/${chapterId}`
            : `/story/${storyId.value}/first-chapter`

        const { data: d, error: e } = useFetchJson(endpoint)

        setTimeout(() => {
            data.value = d.value
            error.value = e.value
            showContent.value = true
        }, 300)
    }

    function goToChapter(nextId, traits) {
        const traitsArray = typeof traits === 'string'
            ? traits.split(',').map(t => t.trim())
            : Array.isArray(traits)
                ? traits
                : []

        if (traitsArray.length > 0) {
            traitsArray.forEach(trait => addTrait(trait))
            logTraits()
        }

        setTimeout(() => {
            router.push(`/story/${storyId.value}/chapter/${nextId}`)
        }, 100)
    }

    function continueStory() {
        const isEnding = data.value?.is_ending
        const hasChoices = data.value?.choices?.length > 0

        if (isEnding && !hasChoices) {
            if (data.value?.is_chest_room) {
                const persona = getFinalPersonality()
                const slug = normalizePersona(persona)
                router.push(`/story/${storyId.value}/ending/${slug}`)
            } else {
                showEndingModal.value = true
            }
        } else {
            const chapterIdParam = route.params.chapterId
            const currentChapterId = chapterIdParam ? parseInt(chapterIdParam) : 1
            const nextChapterId = currentChapterId + 1
            router.push(`/story/${storyId.value}/chapter/${nextChapterId}`)
        }
    }

    function restartStory() {
        resetTraits()
        router.push(`/story/${storyId.value}/chapter/1`)
    }

    function logTraits() {
        const cookie = document.cookie.split('; ').find(c => c.startsWith('echo_traits='))
        const chapterId = route.params.chapterId || 'début'

        if (cookie) {
            const traits = JSON.parse(decodeURIComponent(cookie.split('=')[1]))
            console.log(`Traits du joueur au chapitre ${chapterId} :`)
            console.table(traits)
        } else {
            console.info(`Aucun cookie trouvé. Nouvelle session au chapitre ${chapterId}.`)
        }
    }

    return {
        data,
        error,
        showContent,
        showEndingModal,
        fetchChapter,
        goToChapter,
        continueStory,
        restartStory
    }
}
