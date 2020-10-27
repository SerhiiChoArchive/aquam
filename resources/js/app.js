import AsyncLoader from './AsyncLoader'
import './materialize'

document.addEventListener('DOMContentLoaded', () => {
    (function RunAsyncLoader() {
        let holders = document.querySelectorAll('.async-load')
        holders.length > 0 ? new AsyncLoader(holders).start() : null
    })()
})
