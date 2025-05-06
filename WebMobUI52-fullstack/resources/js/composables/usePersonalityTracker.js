import Cookies from 'js-cookie'

const COOKIE_NAME = 'echo_traits'
const COOKIE_DURATION = 7

export function addTrait(trait) {
    const current = getTraits()
    current[trait] = (current[trait] || 0) + 1
    Cookies.set(COOKIE_NAME, JSON.stringify(current), { expires: COOKIE_DURATION })
}

export function getTraits() {
    const raw = Cookies.get(COOKIE_NAME)
    return raw ? JSON.parse(raw) : {}
}

export function resetTraits() {
    Cookies.remove(COOKIE_NAME)
}

export function getFinalPersonality() {
    const traits = getTraits()

    if (!traits || Object.keys(traits).length === 0) return 'barde' // fallback

    const personalityMap = {
        sorcière: ['intuition', 'solitude', 'curiosité', 'prise_de_risque', 'mystère'],
        guerrière: ['courage', 'initiative', 'impulsivité', 'loyauté', 'combativité'],
        fée: ['compassion', 'émerveillement', 'nature', 'douceur', 'discrétion'],
        reine: ['autorité', 'intelligence', 'observation', 'décision', 'réflexion'],
        chevalier: ['bravoure', 'honneur', 'fidélité', 'structure', 'volonté'],
        barde: ['créativité', 'humour', 'imprévisibilité', 'charme', 'légèreté'],
        dragon: ['puissance', 'indépendance', 'mystère', 'maîtrise_de_soi'],
        paysan: ['simplicité', 'bon_sens', 'prudence', 'instinct']
    }

    const scores = {}

    for (const [persona, keys] of Object.entries(personalityMap)) {
        scores[persona] = keys.reduce((sum, k) => sum + (traits[k] || 0), 0)
    }

    // Trouver la personnalité dominante
    return Object.entries(scores).sort((a, b) => b[1] - a[1])[0]?.[0] || 'barde'
}
