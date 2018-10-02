// Загрузка блоков данных с сервера по ключам с дублированием в localStorage.

import axios from 'axios'
import Core from './core'
import BlankPlugin from './base/BlankPlugin'
import { LocalStorageProxy } from './storage/LocalStorageProxy'

class DataHandler extends BlankPlugin {
    constructor() {
        super()

        this.data = {}
        this.storage = new LocalStorageProxy('__data' + '::' + Core.getLang())
        this.expiredTime = 30 * 60 * 1000
        this.keysToLoad = []
        this.keysInProcess = []

        this.requestDebouncer = _.debounce(() => {
            this.request()
        }, 128)
    }

    get(dataKeys = []) {
        if (_.isString(dataKeys)) {
            dataKeys = [dataKeys]
        }

        let availableKeys = Core.config('data-types')
        dataKeys = dataKeys.filter(key => availableKeys.indexOf(key) !== -1)

        if (dataKeys.length === 0) {
            return new Promise(resolve => resolve({}))
        }

        return this.getData(dataKeys)
    }

    storageDataIsValid(data) {
        if (_.isObject(data) && 'expires' in data) {
            return data.expires > Date.now()
        }

        return false
    }

    getFromStorage(key) {
        let data = this.storage.get(key)

        if (this.storageDataIsValid(data)) {
            this.data[key] = data.value
            return true
        }

        return false
    }

    getData(dataKeys) {
        return new Promise(resolve => {
            dataKeys = dataKeys.reduce((acc, key) => {
                if (! this.getFromStorage(key)) {
                    acc.push(key)
                }

                return acc
            }, [])

            if (dataKeys.length === 0) {
                resolve(this.data)
            }
            else {
                this.getFromServer(dataKeys)
                    .then(() => resolve(this.data))
            }
        })
    }

    getFromServer(dataKeys) {
        let keys = dataKeys.reduce((acc, key) => {
            if (this.keysInProcess.indexOf(key) === -1) {
                acc.push(key)
            }

            return acc
        }, [])

        keys.forEach(key => {
            if (this.keysToLoad.indexOf(key) === -1) {
                this.keysToLoad.push(key)
            }
        })

        if (this.keysToLoad && this.keysToLoad.length) {
            this.requestDebouncer()

            return new Promise(resolve => {
                let destroy = this.on('loaded', () => {
                    if (dataKeys.filter(key => ! (key in this.data)).length === 0) {
                        destroy()
                        resolve()
                    }
                })
            })
        }

        return new Promise(resolve => resolve({}))
    }

    request() {
        this.keysInProcess = this.keysToLoad
        this.keysToLoad = []

        axios.get(Core.siteUrl('data'), {
            responseType: 'json',
            params: {
                dataKeys: this.keysInProcess
            }
        })
            .then(response => {
                let data = response.data

                this.setDataToStorage(data)

                this.data = {
                    ... this.data,
                    ... data
                }

                this.keysInProcess = []

                this.trigger('loaded')
            })
    }

    setDataToStorage(data) {
        for (let key in data) {
            if (_.isBoolean(data[key])) {
                this.setItemToStorage(key, data[key])
            }
            else if (!_.isEmpty(data[key])) {
                this.setItemToStorage(key, data[key])
            }
        }
    }

    setItemToStorage(key, data) {
        this.storage.add(key, {
            expires: Date.now() + this.expiredTime,
            value: data
        })
    }

    flush() {
        this.storage.forgetAll()
    }
}

export default new DataHandler()
