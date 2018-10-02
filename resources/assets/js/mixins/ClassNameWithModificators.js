function addModifs(acc, modifs) {
    if (_.isString(modifs)) {
        modifs = [modifs]
    }

    if (_.isArray(modifs)) {
        acc = [
            ... acc,
            ... modifs
        ]
    }

    return acc
}


export default {
    props: [
        'classNameModificators'
    ],

    methods: {
        classNameWithModificators(baseClass, modifs) {
            let modifiers = addModifs([], this.classNameModificators)
            modifiers = addModifs(modifiers, _.isArray(modifs) ? modifs : [].slice.call(arguments, 1))


            if (_.isEmpty(modifiers)) {
                return baseClass
            }

            return baseClass + ' ' + modifiers.map(modif => baseClass + '--' + modif).join(' ')
        }
    }
}
