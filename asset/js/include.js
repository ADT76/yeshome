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
