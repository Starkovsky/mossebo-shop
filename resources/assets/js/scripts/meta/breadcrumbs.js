export default function setBreadcrumbs(data) {
    let breadcrumbsEl = document.querySelector('.shop-breadcrumbs')

    if (!breadcrumbsEl) return

    breadcrumbsEl.parentNode.replaceChild(buildNewBreadcrumbs(data), breadcrumbsEl)
}

function buildNewBreadcrumbs(data) {
    let breadcrumbsEl = document.createElement('nav')
    breadcrumbsEl.className = 'shop-breadcrumbs'
    let containerEl = document.createElement('div')
    containerEl.className = 'shop-breadcrumbs__container'

    return data.reduce((acc, itemData, index) => {
        let itemEl = document.createElement('div')
        itemEl.className = 'shop-breadcrumbs__item'
        let separatorEl = itemEl.cloneNode()
        let linkEl

        if (itemData.link) {
            linkEl = document.createElement('a')
            linkEl.className = 'shop-breadcrumbs__link link'
            linkEl.setAttribute('href', itemData.link)
        }
        else {
            linkEl = document.createElement('span')
            linkEl.className = 'shop-breadcrumbs__active'
        }

        linkEl.innerHTML = itemData.title

        itemEl.appendChild(linkEl)
        containerEl.appendChild(itemEl)

        if (data.length - 1 > index) {
            separatorEl.innerHTML = '<svg class="shop-breadcrumbs__separator"><use xlink:href="/assets/images/icons.svg#symbol-chevron-right"></use></svg>'
            containerEl.appendChild(separatorEl)
        }

        return containerEl
    }, containerEl)
}
