import './materialize'
import UploadImage from './UploadImage'
import LazyLoader from './LazyLoader'

document.addEventListener('DOMContentLoaded', () => {
    ;(function RunLazyLoader() {
        const images = document.querySelectorAll('.lazy-loader')
        images ? new LazyLoader(images).start() : null
    })()

    ;(function ListenForFileUploading() {
        const inputs = document.querySelectorAll('._upload-image')

        if (!inputs)
            return

        new UploadImage(inputs).listen()
    })()
})
