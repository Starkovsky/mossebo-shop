function isObject(obj) {
    return _.isObject(obj) && !_.isFunction(obj)
}

function deepCopy(state, data) {
    for (let i in state) {
        if (i in data) {
            if (isObject(state[i])) {
                if (isObject(data[i])) {
                    deepCopy(state[i], data[i])
                }
            }
            else {
                state[i] = data[i]
            }
        }
    }
}

function getNotEmptyData(data) {
    let result

    if (isObject(data)) {
        result = {}

        for (let i in data) {
            let a = getNotEmptyData(data[i])

            if (!_.isEmpty(a)) {
                result[i] = a
            }
        }
    }
    else {
        result = data
    }

    return result
}

export default {
    initLocalStorageExtension({ state, dispatch }, localStorageProxy) {
        state.localStorageProxy = localStorageProxy
        state.debouncers = {}

        dispatch('initDataFromStorage')
    },

    updateLocalStorage({ state }, type) {
        if (! (type in state.debouncers)) {
            state.debouncers[type] = _.debounce(() => {
                let data = getNotEmptyData(state[type])

                if (_.isBoolean(data) || !_.isEmpty(data)) {
                    state.localStorageProxy.add(type, data)
                }
                else {
                    state.localStorageProxy.forget(type)
                }
            }, 300)
        }

        state.debouncers[type]()
    },

    initDataFromStorage({state}) {
        let data = state.localStorageProxy.getAll()

        if (!_.isEmpty(data)) {
            deepCopy(state, data)
        }
    },

    clearStorageData() {
        state.localStorageProxy.forgetAll()
    },

    destroyLocalStorageInstance({ state }) {
        state.localStorageProxy = undefined
        state.debouncers = undefined
    }
}
