// import setTitle from './meta/title'
import setBreadcrumbs from './meta/breadcrumbs'

export default function setMeta(data) {
    let titleEl = document.getElementsByTagName('title')[0]
    let metaEls = document.getElementsByTagName('meta')

    ;[].forEach.call(metaEls, el => {
        let name = el.name

        if (name) {
            name = name.toLowerCase()

            if (name in data) {
                el.content = data[name]
            }
        }

        let property = el.attributes.property

        if (property) {
            property = property.value.toLowerCase()

            if (property in data) {
                el.content = data[property]
            }
        }
    })

    if ('title' in data) {
        // setTitle(data.title)
        titleEl.innerHTML = data.title
    }

    if ('breadcrumbs' in data) {
        setBreadcrumbs(data.breadcrumbs)
    }
}
