function getYandexCounter() {
    return typeof yaCounter48404660 !== 'undefined' ? yaCounter48404660 : null
}

function reachYandexGoal(yandexCounter) {
    return (target, params = null) => {
        return new Promise(resolve => {
            yandexCounter.reachGoal(target, params, resolve)
        })
    }
}


class Metrika {
    constructor() {
        let yandexCounter = getYandexCounter()

        this.reachYandexGoal = yandexCounter ? reachYandexGoal(yandexCounter) : () => {}
    }

    reachGoal(target, params, callback) {
        Promise.all([this.reachYandexGoal])
            .then(callback)
    }
}

const metrika = new Metrika

export default metrika
