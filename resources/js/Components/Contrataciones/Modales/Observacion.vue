<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }" v-if="prop.type ==='text'">
            <v-btn v-if="prop.title === 'Ver'" v-bind="props" class="bg-primary"  prepend-icon="mdi-comment-eye-outline">Ver observación</v-btn>

            <v-btn v-else v-bind="props" class="bg-grey2" prepend-icon="mdi-eye-outline">Observación</v-btn>

        </template>
        <template v-slot:activator="{ props }" v-else="prop.type ==='icon'">
            <v-btn v-if="prop.title === 'Ver'" v-bind="props" variant="flat" density="compact" icon="mdi-comment-eye-outline"></v-btn>
            <v-btn v-else v-bind="props" variant="flat" density="compact" icon="mdi-eye-outline"></v-btn>
        </template>

            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">{{ prop.title }} observación</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text class="pt-0" v-if="prop.title === 'Crear'">Escriba una observación referente al servicio para el conductor</v-card-text>
                <v-card-text class="pt-0" v-else>Observación hecha por el mecanico</v-card-text>

                <v-card-text>
                    <v-textarea v-if="prop.title === 'Crear'" label="Observación" variant="solo" auto-grow
                    rows="4"
                    row-height="30">
                    </v-textarea>

                    <v-textarea v-else readonly label="Observación" variant="solo" auto-grow
                    rows="4"
                    row-height="30"  v-model="observacion">
                    </v-textarea>
                </v-card-text>

                <v-card-actions class="mt-3">
                    <v-btn v-if="prop.title === 'Crear'" class="bg-primary" @click="CrearVer">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
        
    </v-dialog>
    
</template>

<script setup>
import {ref, defineProps} from 'vue'
import notify from '@/plugins/notify.js'


const dialog = ref(false);
                   
const observacion = ref("El dia escogido para el servicio no esta disponible se recomienda elegir otro dia apartir del sabado de esta semana")

const prop = defineProps({
    title: {
        type: String,
        required: true,
        default:'Crear'
    },
    type: {
        type: String,
        required: true,
        default: 'icon'
    }

})

const CrearVer = () =>{
    if(prop.title === 'Crear'){
        notify(`Observación enviada correctamente, se procede a informar al usuario`, 'info')
    }

    dialog.value = false
}

</script>