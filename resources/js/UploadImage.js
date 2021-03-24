export default class {
    constructor(inputs) {
        this.inputs = inputs
    }

    listen() {
        this.inputs.forEach(inp => inp.addEventListener('change', () => this.handleEvent(inp)))
    }

    handleEvent(input) {
        const formData = new FormData()
        const currentImage = document.getElementById(input.dataset.image)

        formData.append('file', input.files[0])
        formData.append('article', input.dataset.article)
        formData.append('category', input.dataset.category)

        this.makeRequest(formData, currentImage)
    }

    makeRequest(formData, currentImage) {
        fetch('/image-upload', {
            method: 'post',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': this.getCsrfToken()
            }
        })
            .then(res => res.text())
            .then(imageUrl => currentImage.src = imageUrl)
            .catch(err => console.error(err))
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
}