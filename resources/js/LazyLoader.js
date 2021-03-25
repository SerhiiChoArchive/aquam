/**
 * Class that handles lazy loading images with
 * Intersection Observer
 */
export default class {
    /**
     * @param {object} images
     * @return {void}
     */
    constructor(images) {
        this.images = images
        this.observerOptions = {
            root: null,
            threshold: 0,
        }
    }

    /**
     * If image has tag IMG then set the src attribute to img url,
     * otherwise set the background of the element to given image url
     *
     * @return {void}
     */
    loadImage(img) {
        img.tagName === 'IMG'
            ? img.src = img.dataset.src
            : img.style.backgroundImage = `url(${img.dataset.bg})`

        img.style.opacity = 1
    }

    /**
     * Create observer object
     *
     * @return {void}
     */
    createObserver(img) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(img)
                    observer.unobserve(img)
                }
            })
        }, this.observerOptions)

        observer.observe(img)
    }

    /**
     * Creates image object, gets attributes from placeholder,
     * sets them on image object, adds classes to image and
     * when image is loaded, appends it to a placeholder
     *
     * @return {void}
     */
    start() {
        this.images.forEach(img => {
            !window['IntersectionObserver']
                ? this.loadImage(img)
                : this.createObserver(img)
        })
    }
}