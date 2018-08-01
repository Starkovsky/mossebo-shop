import {LocalStorageProxy} from "../scripts/LocalStorageProxy"

function isObject(obj) {
    return _.isObject(obj) && !_.isFunction(obj)
}

function isEmpty(data) {
    if (_.isFunction(data)) {
        return true
    }

    if (_.isObject(data)) {
        return _.isEmpty(data)
    }

    return _.isNil(data)
}


/**
 * Преобразование вида
 *
 * data = {
 *     'key1.key2': value
 * }
 *
 * в
 *
 * data = {
 *     key1: {
 *         key2: value
 *     }
 * }
 *
 * @param data
 * @returns {{}}
 */
function flatDataToTree(data) {
    return Object.keys(data).reduce((acc, key) => {
        _.set(acc, key, data[key])

        return acc
    }, {})
}


function deepCopy(state, data = {}) {
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

/**
 * Получение не пустых данных (удаление пустых строк, объектов и т.д.), чтобы не захламлять localStorage
 *
 * @param data
 * @returns {*}
 */
function getNotEmptyData(data) {
    if (isEmpty(data)) {
        return null
    }

    let result

    if (_.isArray(data)) {
        result = []

        data.forEach(item => {
            item = getNotEmptyData(item)

            if (! isEmpty(item)) {
                result.push(item)
            }
        })
    }
    else if (isObject(data)) {
        result = {}

        for (let i in data) {
            let item = getNotEmptyData(data[i])

            if (! isEmpty(item)) {
                result[i] = item
            }
        }
    }
    else {
        result = data
    }

    return result
}


function camelize(string) {
    return _.startCase(_.capitalize(string)).replace(/\s/g, '')
}

function getMethodName(type, namespace, dataType) {
    return `_ls${camelize(type)}${camelize(namespace)}${camelize(dataType)}`
}

export default {
    initLocalStorageExtension({ state, dispatch }, namespace) {
        state.localStorageProxy = new LocalStorageProxy('__' + namespace)
        state.debouncers = {}
        state.localStorageNamespace = namespace

        return dispatch('initDataFromStorage')
    },

    updateLocalStorage({ state, dispatch }, types) {
        if (! _.isArray(types)) {
            types = [types]
        }

        types.forEach(type => {
            if (! (type in state.debouncers)) {
                state.debouncers[type] = _.throttle(() => {
                    dispatch('_lsGetData', type)
                        .then(data => {
                            if (_.isNil(data)) {
                                state.localStorageProxy.forget(type)
                            }
                            else {
                                state.localStorageProxy.add(type, data)
                            }
                        })
                }, 300)
            }

            state.debouncers[type]()
        })
    },

    _lsGetData({state, dispatch}, type) {
        let methodName = getMethodName('prepare', state.localStorageNamespace, type)

        if (methodName in this._actions) {
            return dispatch(methodName, null, {root: true})
                    .then(data => getNotEmptyData(data))
        }

        return getNotEmptyData(_.get(state, type))
    },

    initDataFromStorage({state, dispatch}) {
        let data = state.localStorageProxy.getAll()
        data = flatDataToTree(data)

        let chain = new Promise(resolve => resolve())

        for (let type in data) {
            let methodName = getMethodName('set', state.localStorageNamespace, type)

            if (methodName in this._actions) {
                chain.then(() => dispatch(methodName, data[type], {root: true}))
            }
            else if (type in state) {
                deepCopy(state[type], data[type])
            }
        }

        return chain
    },

    clearStorageData({state}) {
        state.localStorageProxy.forgetAll()
    },

    destroyLocalStorageInstance({ state }) {
        state.localStorageProxy = undefined
        state.debouncers = undefined
    }
}
