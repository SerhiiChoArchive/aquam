/**
 * Class that handles async loading images
 */
export default class {
    /**
     * @param {object} holders Temporary placeholders for images
     * @return {void}
     */
    constructor(holders) {
        this.holders = holders
    }

    /**
     * Appends image to a placeholder and removes class from
     * placeholder and appended image object
     *
     * @param {object} image
     * @param {object} holder
     * @return {void}
     */
    loadImageInDOM(image, holder) {
        image.onload = () => {
            holder.appendChild(image)
            holder.classList.remove('async-load')
            setTimeout(() => image.classList.remove('hide'), 1);
        }
    }

    /**
     * Adds classes to a DOM element
     *
     * @param {object} elem Element that needs to have classes
     * @param {array} classes Classes that needs to be added to elem
     * @return {void}
     */
    addClassesTo(elem, classes) {
        classes.forEach(className => elem.classList.add(className))
    }

    /**
     * Adds given attributes to a given image
     *
     * @param {object} image Image that needs new attributes
     * @param {object} attrs Attributes that needs to be added to image
     * @return {void}
     */
    setAttributes(image, attrs) {
        attrs.width ? (image.width = attrs.width) : ''
        attrs.height ? (image.height = attrs.height) : ''
        attrs.class ? (image.className = attrs.class) : ''
        attrs.src ? (image.src = attrs.src) : ''
        attrs.alt ? (image.alt = attrs.alt) : ''
    }

    /**
     * Get all attributes from placeholder DOM elements,
     * and return them
     *
     * @param {object} holder
     * @return {object}
     */
    getAttributes(holder) {
        return {
            class: holder.getAttribute('data-class'),
            width: holder.getAttribute('data-width'),
            height: holder.getAttribute('data-height'),
            src: holder.getAttribute('data-async-load'),
            alt: holder.getAttribute('data-alt'),
        }
    }

    /**
     * Creates image object, gets attributes from placeholder,
     * sets them on image object, adds classes to image and
     * when image is loaded, appends it to a placeholder
     *
     * @return {void}
     */
    start() {
        this.holders.forEach(holder => {
            const img = new Image()
            const attrs = this.getAttributes(holder)

            this.setAttributes(img, attrs)
            this.addClassesTo(img, ['async-loaded', 'hide'])
            this.loadImageInDOM(img, holder)
        })
    }
}
