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
                    primary: '#1279C1',
                    secondary: '#303134',
                    terceary: '#32525C',
                    bold: '#000000',
                    error: '#dc3545',
                    greenDark: '#32525C',
                    greyDark: '#D9D9D9'
                },
            },
        },
    },
    components,
    directives,
})
