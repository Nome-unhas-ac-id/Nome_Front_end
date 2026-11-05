import Alpine from 'alpinejs';

window.Alpine = Alpine;
const { registerNome } = await import(/* @vite-ignore */ new URL('/js/nome-ui.js', window.location.origin).href);
registerNome(Alpine);
Alpine.start();
