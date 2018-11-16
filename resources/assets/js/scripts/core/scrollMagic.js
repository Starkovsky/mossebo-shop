import ScrollMagic from 'scrollmagic'

class ScrollMagicHandler {
    constructor() {
        this.controller = null
    }

    getInstance() {
        if (! this.controller) {
            this.controller = new ScrollMagic.Controller({
                globalSceneOptions: {triggerHook: "onLeave"}
            })
        }

        return this.controller
    }

    makeScene(params) {
        const scene = new ScrollMagic.Scene(params)
        scene.addTo(this.getInstance())

        return scene
    }
}

const scrollMagicHandler = new ScrollMagicHandler()

export default scrollMagicHandler
