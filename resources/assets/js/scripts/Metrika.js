class Metrika {
    constructor() {

    }

    reachGoal(target, callback) {
        Promise.all([this._reachYandexGoal(target), this._reachGoogleGoal(target)])
            .then(callback)
    }

    _reachYandexGoal(target) {
        if (typeof yaCounter48404660 === 'object' && 'reachGoal' in yaCounter48404660) {
            yaCounter48404660.reachGoal(target)
        }
    }

    _reachGoogleGoal(target) {
        if (typeof ga === 'object' && 'getAll' in ga) {
            let tracker = ga.getAll()[0]

            if (tracker) {
                tracker.send("event", {
                    'eventAction': target,
                });
            }
        }
        else if (typeof ga === 'function') {
            ga('send', 'event', {
                'eventAction': target,
            })
        }
    }
}
