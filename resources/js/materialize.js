import 'materialize-css/dist/js/materialize.min.js'

document.addEventListener('DOMContentLoaded', () => {
    M.Collapsible.init(document.querySelectorAll('.collapsible'))
    M.Tabs.init(document.querySelector('.tabs'))
    M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
        coverTrigger: false,
        constrainWidth: false,
    })
})