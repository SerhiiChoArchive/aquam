import AsyncLoader from './AsyncLoader'
import './materialize'
import UploadImage from './UploadImage'

document.addEventListener('DOMContentLoaded', () => {
    (function RunAsyncLoader() {
        let holders = document.querySelectorAll('.async-load')
        holders.length > 0 ? new AsyncLoader(holders).start() : null
    })()

    ;(function ListenForFileUploading() {
        const inputs = document.querySelectorAll('._upload-image')

        if (!inputs)
            return

        new UploadImage(inputs).listen()
    })()
})
