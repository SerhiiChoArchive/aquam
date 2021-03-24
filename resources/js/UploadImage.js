export default class {
    constructor(inputs) {
        this.inputs = inputs
    }

    listen() {
        this.inputs.forEach(inp => inp.addEventListener('change', () => this.handleEvent(inp)))
    }

    handleEvent(input) {
        const formData = new FormData()

        formData.append('file', input.files[0])
        formData.append('article', input.dataset.article)

        this.makeRequest(formData)
    }

    makeRequest(formData) {
        fetch('/image-upload', {
            method: 'post',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': this.getCsrfToken()
            }
        })
            .then(res => res.text())
            .then(res => console.log(res))
            .catch(err => console.error(err))
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
}