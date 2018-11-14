import BlankPlugin from './base/BlankPlugin'

class InstagramDataLoader extends BlankPlugin {
    constructor() {
        super()
        this.loaded = {}
    }

    makeKey(profileName, count) {
        return profileName + '-' + count
    }

    getData(profileName, count, callback) {
        let key = this.makeKey(profileName, count)

        if (key in this.loaded) {
            callback(this.loaded[key])

            return
        }

        this.on(key, data => {
            callback(data)
        })

        this.load({
            profile: profileName,
            count
        })
    }

    setData(profileName, images) {
        let key = this.makeKey(profileName, images.length)

        this.loaded[key] = images
        this.trigger(key, images)
    }

    load(params) {
        let script = document.createElement('script')

        params = Object.keys(params).reduce((acc, key) => {
            acc.push(key + '=' + encodeURIComponent(params[key]))

            return acc
        }, [])

        script.src = '//services.mossebo.ru/api/v1/instagram?callback=showInstagramWidget&' + params.join('&')
        script.type  = 'text/javascript'
        script.async = true

        document.body.appendChild(script)
    }
}


window.showInstagramWidget = function (data) {
    instagramDataLoader.setData(data.profile, data.images)
}

let instagramDataLoader = new InstagramDataLoader()

export default instagramDataLoader
