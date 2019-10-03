import AsyncLoader from './AsyncLoader'

;(function RunAsyncLoader() {
    let holders = document.querySelectorAll('.async-load')
    holders.length > 0 ? new AsyncLoader(holders).start() : null
})()

;(function MaterializeStuff() {
    document.addEventListener('DOMContentLoaded', function() {
        M.Collapsible.init(document.querySelectorAll('.collapsible'));
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        M.Sidenav.init(elems);
    });
})()
