import 'materialize-css/dist/css/materialize.min.css'
import 'materialize-css/dist/js/materialize.min.js';

document.addEventListener('DOMContentLoaded', () => {
    M.Collapsible.init(document.querySelectorAll('.collapsible'))
    M.Sidenav.init(document.querySelectorAll('.sidenav'))
})