/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'


// Composables
import { createVuetify } from 'vuetify'

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
    theme: {
        themes: {
            light: {
                defaultFont: 'Museo Sans Regular, sans-serif',
                colors: {
                    primary: '#30a4f1',
                    secondary: '#30a4f1',
                    bold: '#000000',
                    error: '#FF3E1D',

                },
            },
        },
    },
    components,
    directives,
})
