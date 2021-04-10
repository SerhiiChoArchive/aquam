import './materialize'
import UploadImage from './UploadImage'
import smoothLoader from 'smooth-loader'

smoothLoader()

document.addEventListener('DOMContentLoaded', () => {
    ;(function ListenForFileUploading() {
        const inputs = document.querySelectorAll('._upload-image')

        if (!inputs)
            return

        new UploadImage(inputs).listen()
    })()
})
