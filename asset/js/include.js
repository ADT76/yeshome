// scripts/include.js
function includeHTML() {
    const includes = document.querySelectorAll('[data-include]');
    includes.forEach(el => {
        const file = el.getAttribute('data-include');
        fetch(file)
            .then(response => {
                if (!response.ok) throw new Error(`Fichier non trouvé: ${file}`);
                return response.text();
            })
            .then(html => {
                el.innerHTML = html;
            })
            .catch(error => {
                el.innerHTML = `<p style="color:red;">Erreur de chargement : ${error.message}</p>`;
            });
    });
}

document.addEventListener("DOMContentLoaded", includeHTML);


const btn = document.getElementById('mobile-menu-button');
const menu = document.getElementById('mobile-menu');

btn.addEventListener('click', () => {
    const isExpanded = btn.getAttribute('aria-expanded') === 'true';

    btn.setAttribute('aria-expanded', String(!isExpanded));
    menu.classList.toggle('hidden');
});