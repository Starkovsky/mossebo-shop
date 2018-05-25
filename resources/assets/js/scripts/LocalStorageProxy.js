export default {
    __data: {},

    __available: 'localStorage' in window && window['localStorage'] !== null,

    isAvailable() {
        return this.__available
    },

    add(identif, data) {
        this.__data[identif] = data

        if (!this.isAvailable()) return
        if (typeof data === 'function') return

        if (typeof data !== 'string') {
            data = JSON.stringify(data)
        }

        localStorage.setItem(identif, data)
    },

    get(identif) {
        if (identif in this.__data) {
            let data = this.__data[identif]

            if (typeof data !== 'string') {
                try {
                    data = JSON.parse(JSON.stringify(this.__data[identif]))
                }
                catch(e){
                    delete this.__data[identif]
                    return this.get(identif)
                }
            }

            return data
        }

        if (!this.isAvailable()) return

        let data = localStorage.getItem(identif)

        try {
            data = JSON.parse(data)
        }
        catch(e){}

        this.__data[identif] = data

        return data
    },

    has(identif) {
        if (!this.isAvailable()) return false

        return identif in localStorage
    },

    /*
      Достаем данные из хранилища.
      Если данных нет, или хранилище не доступно - используем getDataFunc для получения данных.
    */
    remember(identif, getDataFunc, callback) {
        if (! _.isFunction(callback)) return

        data = this.get(identif)

        if (data) {
            callback(data)
        }
        else {
            try {
                getDataFunc(data => {
                    this.add(identif, data)
                    callback(data)
                });
            }
            catch(e) {
                console.log(e)
            }
        }
    },

    forget(identif) {
        if (!this.isAvailable()) return

        localStorage.removeItem(identif)
    }
}
