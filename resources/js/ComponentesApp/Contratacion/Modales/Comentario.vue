<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }">
            <v-btn v-if="prop.type === 'text'" v-bind="props" @click="obtenerCalificacion()" size="small"
                class="bg-success" icon>
                <v-icon>mdi-star-cog-outline</v-icon>
                <v-tooltip activator="parent" location="top">Reseñar servicio</v-tooltip>
            </v-btn>
            <v-btn v-else-if="prop.type === 'icon'" v-bind="props" @click="obtenerCalificacion()" variant="flat"
                density="compact" icon="mdi-star-cog-outline"></v-btn>
        </template>


        <v-card class="text-center bg-greyDark">
            <v-card-title class="text-primary font-weight-bold">
                Calificación del servicio
            </v-card-title>
            <v-divider class="border-opacity-100" color="primary"></v-divider>
            <v-card-text v-if="!exist">Califica este servicio de acuerdo a tu experiencia</v-card-text>
            <v-card-text v-else>Tu calificaión</v-card-text>

            <v-card-text>
                <div v-if="!exist">
                    <div class="d-flex gap-10 justify-center mb-4">
                        <v-rating v-model="form.calificacion" active-color="primary" empty-icon="mdi-cog-outline"
                        full-icon="mdi-cog" density="compact"></v-rating>
                        <pre>{{ form.calificacion }}</pre>
                    </div>
                    
                    <v-textarea  label="Comentario" variant="solo"></v-textarea>


                </div>

                <p v-else>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                    tempor
                    incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco
                    laboris nisi ut aliquip ex
                    ea commodo consequat.
                </p>
            </v-card-text>

            <v-card-actions class="mt-3">
                <v-btn v-if="!exist" class="bg-primary" @click="enviarComentario">Confimar</v-btn>
                <v-spacer></v-spacer>
                <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>


<script setup>
import { ref, defineProps } from 'vue'
import notify from '@/plugins/notify.js'
import { postData, getData } from '@/plugins/api.js';



const dialog = ref(false);

const prop = defineProps({
    type: {
        type: String,
        required: true,
        default: 'icon'
    },
    id: {
        type: Number,
        required: true,
        default: null
    },
    info:{
        required: false,
    }

})
const emit = defineEmits(['actualizar'])

const exist = ref(true);
const form = ref({})

const enviarComentario = async () => {

    try {
        form.value.estado_id = 3;
        await postData(('comentario/' + prop.id), form.value, { headers: { 'Content-Type': 'application/json' } });
    } catch (error) {
        notify(error, 'error');
    } finally {
        dialog.value = false;
        emit('actualizar')
    }
}

const obtenerCalificacion = async () => {
    try {
        const data = await getData(('comentario/' + prop.id));
        exist.value = data.exist;
        console.log(prop.info)

    } catch (error) {
        notify(error, 'warning');
    }
}

</script>