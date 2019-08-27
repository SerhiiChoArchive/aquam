setTimeout(function () {
    const msg = document.querySelector('.message')
    msg ? msg.remove() : null
}, 3000)

;(function ShowFilePathAfterChoosingFile() {
    const showPathIn = document.getElementById('file-path')
    const fileInput = document.getElementById('input-file')

    if (!fileInput) return

    fileInput.addEventListener('change', function (e) {
        showPathIn.innerText = e.target.files[0].name
    })
})()
