import mask from '@alpinejs/mask';

if (window.Alpine) {
    window.Alpine.plugin(mask);
} else {
    console.warn('Alpine.js não encontrado ao tentar registrar o plugin de máscara. Isso pode indicar um problema de carregamento.');
}
