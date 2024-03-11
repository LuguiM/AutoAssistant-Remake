<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }">
            <v-btn v-if="prop.type === 'text'" v-bind="props" @click="obtenerCalificacion()" size="small"
                class="bg-cyan-darken-4" icon>
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
            <v-card-text v-if="cargando">
                <v-row class="fill-height" align-content="center" justify="center">
                    <v-col class="text-subtitle-1 text-center" cols="12">
                        Cargando...
                    </v-col>
                    <v-col cols="6">
                        <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
                    </v-col>
                </v-row>
            </v-card-text>
            <div v-else>

                <v-card-text v-if="!exist">Califica este servicio de acuerdo a tu experiencia</v-card-text>
                <v-card-text v-else class="text-h6">Tu calificación</v-card-text>

                <v-card-text>
                    <div v-if="!exist">
                        <div class="d-flex gap-10 justify-center align-center mb-4">
                            <p>Calificación: </p>
                            <v-rating v-model="form.calificacion" active-color="primary" empty-icon="mdi-cog-outline"
                                full-icon="mdi-cog" density="compact"></v-rating>
                            <pre>{{ form.calificacion }}</pre>
                        </div>

                        <v-textarea v-model="form.comentario" label="Comentario" variant="solo"></v-textarea>


                    </div>
                    <div v-else>
                        <div class="d-flex gap-10 justify-center align-center mb-4">
                            <p>Calificación: </p>
                            <v-rating readonly v-model="comentarioData.calificacion" active-color="primary"
                                empty-icon="mdi-cog-outline" full-icon="mdi-cog" density="compact"></v-rating>
                            <pre>{{ comentarioData.calificacion }}</pre>
                        </div>

                        <v-textarea readonly no-resize v-model="comentarioData.comentario" label="Comentario"
                            variant="solo" row-height="30" rows="4" auto-grow></v-textarea>
                    </div>


                </v-card-text>

                <v-card-actions class="mt-3">
                    <v-btn v-if="!exist" class="bg-primary" @click="enviarComentario">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>
                </v-card-actions>
            </div>

        </v-card>

    </v-dialog>
</template>


<script setup>
import { ref, defineProps } from 'vue'
import notify from '@/plugins/notify.js'
import { postData, getData } from '@/plugins/api.js';



const dialog = ref(false);
const cargando = ref(true);

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
    info: {
        required: false,
    }

})
const emit = defineEmits(['actualizar'])

const exist = ref(true);
const comentarioData = ref({});
const form = ref({
    calificacion: 0,
})

const enviarComentario = async () => {

    try {
        form.value.contratacion_id = prop.id;
        form.value.servicio_id = prop.info.servicio_id;
        form.value.user_id = prop.info.conductor_id;
        await postData(('comentario'), form.value, { headers: { 'Content-Type': 'application/json' } });
    } catch (error) {
        notify(error, 'error');
    } finally {
        emit('actualizar')
        dialog.value = false;
    }
}

const obtenerCalificacion = async () => {
    try {
        const data = await getData(('comentario/' + prop.id));
        comentarioData.value = data.data;
        exist.value = data.exist;
        console.log(prop.info)

    } catch (error) {
        notify(error, 'warning');
    } finally {
        cargando.value = false;
    }
}

</script>