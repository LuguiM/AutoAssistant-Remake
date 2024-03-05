<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }" v-if="prop.type === 'text'">
            <v-btn v-if="prop.title === 'Ver'" v-bind="props" size="small" @click="CrearVer" class="bg-primary" icon>
                <v-icon>mdi-comment-search-outline</v-icon>
                <v-tooltip activator="parent" location="top">Ver observacion</v-tooltip>
            </v-btn>

            <v-btn v-else v-bind="props" size="small" class="bg-grey2" icon>
                <v-icon>mdi-eye-outline</v-icon>
                <v-tooltip activator="parent" location="top">Crear observación</v-tooltip>
            </v-btn>

        </template>

        <template v-slot:activator="{ props }" v-else="prop.type ==='icon'">
            <v-btn v-if="prop.title === 'Ver'" v-bind="props" variant="flat" density="compact"
                icon="mdi-comment-search-outline"></v-btn>
            <v-btn v-else v-bind="props" variant="flat" density="compact" icon="mdi-eye-outline"></v-btn>
        </template>

        <v-card class="text-center bg-greyDark">
            <v-card-title class="text-primary font-weight-bold">{{ prop.title }} observación</v-card-title>
            <v-divider class="border-opacity-100" color="primary"></v-divider>
            <v-card-text class="pt-0" v-if="prop.title === 'Crear'">Escriba una observación referente al servicio para
                el
                conductor</v-card-text>
            <v-card-text class="pt-0" v-else>Observación hecha por el mecanico</v-card-text>

            <v-card-text>
                <v-textarea v-if="prop.title === 'Crear'" v-model="form.observacion" label="Observación" variant="solo" auto-grow rows="4"
                    row-height="30">
                </v-textarea>

                <v-textarea v-else readonly label="Observación" variant="solo" auto-grow rows="4" row-height="30"
                    v-model="observacion">
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
import { ref, defineProps } from 'vue'
import notify from '@/plugins/notify.js'
import { getData, putData } from '@/plugins/api.js';



const dialog = ref(false);

const observacion = ref("");

const prop = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Crear'
    },
    type: {
        type: String,
        required: true,
        default: 'icon'
    },
    id: {
        type: Number,
        required: true,
        default: 0,
    }

})

const emit = defineEmits(['actualizar'])
const form = ref({})



const CrearVer = async () => {
    if (prop.title === 'Crear') {
        form.value.estado_id = 2;
        try {
            await putData(('updateEstado/' + prop.id), form.value, { headers: { 'Content-Type': 'application/json' } });
        } catch (error) {
            console.log(error)
        } finally {
            emit('actualizar')
            dialog.value = false
        }
    } else {
        try {
            const data = await getData(('verObservacion/' + prop.id));

            if (!data.status) {
                notify(data.message, 'info');
                dialog.value = false;
            } else {
                observacion.value = data.data.observacion
            }

        } catch (error) {
            notify(error.message, 'error');
        }
    }

}

</script>