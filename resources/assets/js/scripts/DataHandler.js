// Загрузка блоков данных с сервера по ключам с дублированием в localStorage.

import axios from 'axios'
import Core from './core'
import { LocalStorageProxy } from './LocalStorageProxy'

export default {
    data: {},
    storage: new LocalStorageProxy('__data' + '::' + Core.getLang()),
    expiredTime: 30 * 60 * 1000,

    get(dataKeys = []) {
        this.data = {}

        if (_.isString(dataKeys)) {
            dataKeys = [dataKeys]
        }

        if (dataKeys.length === 0) {
            return new Promise(resolve => resolve())
        }

        return this.getData(dataKeys)
    },

    storageDataIsValid(data) {
        if (_.isObject(data) && 'expires' in data) {
            return data.expires > Date.now()
        }

        return false
    },

    getFromStorage(key) {
        let data = this.storage.get(key)

        if (this.storageDataIsValid(data)) {
            this.data[key] = data.value
            return true
        }

        return false
    },

    getData(dataKeys) {
        return new Promise(resolve => {
            dataKeys = dataKeys.reduce((acc, key) => {
                if (!this.getFromStorage(key)) {
                    acc.push(key)
                }

                return acc
            }, [])

            if (dataKeys.length === 0) {
                resolve(this.data)
            }
            else {
                resolve(this.getFromServer(dataKeys))
            }
        })
    },

    getFromServer(dataKeys) {
        return new Promise((resolve) => {
            axios.get(Core.siteUrl('data'), {
                responseType: 'json',
                params: {dataKeys}
            })
                .then(response => {
                    let data = response.data

                    this.setDataToStorage(data)

                    this.data = {
                        ... this.data,
                        ... data
                    }

                    resolve(this.data)
                })
        })
    },

    setDataToStorage(data) {
        for (let key in data) {
            this.setItemToStorage(key, data[key])
        }
    },

    setItemToStorage(key, data) {
        this.storage.add(key, {
            expires: Date.now() + this.expiredTime,
            value: data
        })
    },

    flush() {
        this.storage.forgetAll()
    }
}
