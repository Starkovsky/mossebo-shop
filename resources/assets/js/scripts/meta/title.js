export default function setTitle(title) {
    let titleEl = document.querySelector('.js-main-title, .title-h1')

    if (titleEl) {
        titleEl.innerHTML = title
    }
}
