export default class BaseStorage {
    prepareIncomingData(data) {
        if (typeof data === 'function') return null

        if (typeof data === 'object') {
            return JSON.stringify(data)
        }

        return data
    }

    prepareOutgoingData(data) {
        try {
            return JSON.parse(data)
        }
        catch(e){
            return data
        }
    }
}
