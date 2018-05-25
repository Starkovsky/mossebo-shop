export default {
    props: [
        'classNameModificators'
    ],

    methods: {
        classNameWithModificators(baseClass) {
            let addModif = (acc, modif) => acc + ' ' + baseClass + '--' + modif
            let modif = this.classNameModificators

            if (_.isArray(modif)) {
                return modif.reduce(addModif, baseClass)
            }

            if (_.isString(modif)) {
                return addModif(baseClass, modif)
            }

            return baseClass
        }
    }
}
