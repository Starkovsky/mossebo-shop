export function makeEvent(eventName) {
    let myEvent

    if (typeof CustomEvent === 'undefined') {
        myEvent = document.createEvent(eventName)
        myEvent.initCustomEvent(eventName, false, true)
    }
    else {
        myEvent = new CustomEvent(eventName, {
            bubbles: false,
            cancelable: true
        })
    }

    return myEvent
}

export function dispatchEvent(el, eventName) {
    el.dispatchEvent(makeEvent(eventName))
}
