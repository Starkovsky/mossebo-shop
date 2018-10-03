import ClassNameWithModificators from '../../mixins/ClassNameWithModificators'
import FontResizer from '../FontResizer'

export default {
    mixins: [
        ClassNameWithModificators
    ],

    components: {
        FontResizer
    },

    props: {
        id: null,

        image: null,
        backgroundImage1: null,
        backgroundImage2: null,

        gradientFrom: {
            default: '#fcc600'
        },

        gradientTo: {
            default: '#fdda55'
        },

        gradientType: {
            default: 'linear'
        },

        gradientAngle: {
            default: 45,
        },

        title: String,
        caption: String,
        buttonText: String,

        link: String,

        titleColor: String,
        captionColor: String,

        buttonColor: String,
        buttonBackground: String,
    },

    methods: {
        makeBackgroundUrl(image) {
            return 'url(' + image + ')'
        },
    },

    computed: {
        gradient() {
            if (this.gradientType === 'radial') {
                return `radial-gradient(${this.gradientFrom}, ${this.gradientTo})`
            }

            return `linear-gradient(${this.gradientAngle}deg, ${this.gradientFrom} 0%, ${this.gradientTo} 100%)`
        },

        buttonStyle() {
            let style = {}

            if (this.buttonColor) {
                style.color = this.buttonColor
            }

            if (this.buttonBackground) {
                style.backgroundColor = this.buttonBackground
            }

            return style
        },

        hasButton() {
            return !! this.buttonText
        }
    }
}
