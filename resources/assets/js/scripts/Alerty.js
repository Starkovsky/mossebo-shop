import BlankPlugin from './base/BlankPlugin'
import Core from "./core";

export default class Alerty extends BlankPlugin {
    constructor(content) {
        super()

        this.el = document.createElement('div')
        this.el.classList.add('popup')
        this.el.classList.add('block-ui')
        this.el.id = 'alerty'

        this.els = []

        if (typeof content === 'string') {
            this.setMessage(content)
        }
        else {
            ;['title', 'message', 'buttons', 'type', 'class'].forEach(key => {
                if (key in content) {
                    this['set' + key.charAt(0).toUpperCase() + key.slice(1)](content[key])
                }
            })
        }

        this.fillEl()
        this.open()
    }

    fillEl() {
        let containerEl = document.createElement('div')
        containerEl.classList.add('popup__container')

        this.els.forEach(el => containerEl.appendChild(el))

        this.el.appendChild(containerEl)
    }

    setTitle(titleHtml) {
        let el = document.createElement('h3')
        el.classList.add('popup__title')
        el.classList.add('title-h3')
        el.innerHTML = titleHtml

        let topEl = document.createElement('div')
        topEl.classList.add('popup__top')
        topEl.appendChild(el)

        this.els.push(topEl)
    }

    setMessage(messageHtml) {
        let el = document.createElement('div')
        el.classList.add('popup__message')
        el.innerHTML = messageHtml

        let contentEl = document.createElement('div')
        contentEl.classList.add('popup__content')
        contentEl.appendChild(el)

        this.els.push(contentEl)
    }

    setButtons(buttons) {
        let bottomEl = document.createElement('div')
        bottomEl.classList.add('popup__bottom')

        buttons.forEach(button => {

            let el = document.createElement('a')

            if ('href' in button) {
                el.href = button.href
            }

            if ('class' in button) {
                button.class.split(' ').forEach(className => el.classList.add(className))
            }

            if ('onclick' in button) {
                el.onclick = button.onclick
            }

            if ('text' in button) {
                el.innerHTML = button.text
            }


            let buttonEl = document.createElement('div')
            buttonEl.classList.add('popup__button')
            buttonEl.appendChild(el)

            bottomEl.appendChild(buttonEl)
        })

        this.els.push(bottomEl)
    }

    setType(type) {
        this.setClass(type)
    }

    setClass(classList) {
        if (! classList) return

        classList.split(' ').forEach(className => this.el.classList.add(className))
    }

    open() {
        this.el.style.display = 'none'
        document.body.appendChild(this.el)

        $.fancybox.open(
            {
                src: '#alerty',
            }, {
                ... Core.getFancyboxConfig(),
                afterClose: this.close.bind(this)
            },
        );
    }

    close() {
        $.fancybox.close()
        this.destroy()
        this.el.parentNode.removeChild(this.el)
    }
}
