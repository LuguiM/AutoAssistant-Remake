<template>
    <v-dialog v-model="dialog" persistent width="500">
        <template v-slot:activator="{ props }" v-if="prop.type === 'text'">

            <v-btn v-if="prop.mode === 'modificar'" @click="detallles" v-bind="props" class="bg-primary" size="small"
                icon>
                <v-icon>mdi-square-edit-outline</v-icon>
                <v-tooltip activator="parent" location="top">Modificar servicio</v-tooltip>
            </v-btn>

            <v-btn v-else v-bind="props" @click="detallles" class="bg-terceary" size="small" icon>
                <v-icon>mdi-file-cog-outline</v-icon>
                <v-tooltip activator="parent" location="top">Ver detalles</v-tooltip>
            </v-btn>
        </template>

        <template v-slot:activator="{ props }" v-else="prop.type ==='icon'">
            <v-btn v-if="prop.mode === 'modificar'" @click="detallles" v-bind="props" variant="flat" density="compact"
                icon="mdi-square-edit-outline"></v-btn>
            <v-btn v-else @click="detallles" v-bind="props" variant="flat" density="compact"
                icon="mdi-file-cog-outline"></v-btn>

        </template>

        <v-card class="text-center bg-greyDark">
            <v-card-title v-if="prop.mode === 'modificar'" class="text-primary font-weight-bold">Modificar
                contratación</v-card-title>
            <v-card-title v-else class="text-primary font-weight-bold">Detalles de la contratación</v-card-title>

            <v-divider class="border-opacity-100" color="primary"></v-divider>

            <v-card-text v-if="prop.mode === 'modificar'">
                <v-form @submit.prevent="modificarContratacion()" validate-on="submit lazy">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field hide-details v-model="servicio.servicio" readonly variant="solo"
                                label="Servicio a contratar" required></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <VueDatePicker v-model="date" time-picker-inline teleport-center :is-24="false"
                                :min-date="minDate" locale="es" cancelText="Cancelar" class="pickerDate"
                                selectText="Aceptar" placeholder="Fecha y hora" />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field hide-details v-model="form.tipo_servicio" readonly variant="solo"
                                label="Tipo de servicio" required></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model="form.direccion" hide-details color="primary" label="Dirección"
                                required variant="solo"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea v-model="form.comentario" base-color="primary" hide-details label="Comentario"
                                color="primary" variant="solo"></v-textarea>
                        </v-col>
                        <v-col cols="12" class="d-flex justify-space-between">
                            <v-btn :loading="cargando" color="primary" type="submit"
                                prepend-icon="mdi-car-cog">Contratar
                                servicio</v-btn>
                            <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>

                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>

            <v-card-text v-else>

                <v-row>
                    <v-col cols="12" class="d-flex flex-column">
                        <h3>Servicio</h3>

                        <h4 class="font-weight-regular">{{ servicio.servicio }}</h4>

                    </v-col>

                    <v-col cols="12" class="d-flex flex-column">
                        <h3>
                            Fecha y hora del servicio
                        </h3>
                        <h4 class="font-weight-regular">
                            {{ formatDate(detalles.fecha_contratacion) }}
                        </h4>
                    </v-col>

                    <v-col cols="12" class="d-flex flex-column">
                        <h3>Tipo de servicio</h3>

                        <h4 class="font-weight-regular">{{ detalles.tipo_servicio }}</h4>

                    </v-col>

                    <v-col cols="12" v-if="detalles.tipo_servicio === 'Adomicilio'" class="d-flex flex-column">
                        <h3>Direccion</h3>

                        <h4 class="font-weight-regular">{{ detalles.direccion }}</h4>
                    </v-col>

                    <v-col cols="12" class="d-flex flex-column">
                        <h3>Comentario</h3>

                        <h4 class="font-weight-regular">{{ detalles.comentario }}</h4>
                    </v-col>


                </v-row>

            </v-card-text>

            <v-card-actions v-if="prop.mode === 'detalles'" class="mt-3 d-flex justify-center">

                <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>

</template>

<script setup>
import { ref, defineProps } from 'vue'
import notify from '@/plugins/notify.js'
import { getData, putData } from '@/plugins/api.js';
import { format } from 'date-fns';


const dialog = ref(false);
const date = ref('');
const detalles = ref({});
const servicio = ref({});
const form = ref({});
const cargando = ref(false);
const minDate = ref(new Date());


const prop = defineProps({
    type: {
        type: String,
        required: true,
        default: 'icon'
    },
    id: {
        type: Number,
        required: true,
        default: 0,
    },
    mode: {
        type: String,
        required: true,
        default: 'detalles'
    }

})

const emit = defineEmits(['actualizar'])

const formatDate = (dateTime) => {
    if (!dateTime) return '';

    const dateTimeObj = new Date(dateTime);
    return format(dateTimeObj, 'dd/MM/yyyy hh:mm a');
};

const detallles = async () => {
    try {
        const data = await getData(('detalleContratacion/' + prop.id));

        if (!data.status) {
            notify(data.message, 'warning');
            dialog.value = false;
        } else {
            detalles.value = data.data
            servicio.value = detalles.value.servicio

            form.value.tipo_servicio = detalles.value.tipo_servicio;
            date.value = detalles.value.fecha_contratacion
            form.value.direccion = detalles.value.direccion
            form.value.comentario = detalles.value.comentario
        }

    } catch (error) {
        notify(error.message, 'error');
    }
}

const modificarContratacion = async () => {
    try {
        cargando.value = true
        form.value.fecha_contratacion = date.value;
        await putData(('contrataciones/edit/' + prop.id), form.value, { headers: { 'Content-Type': 'application/json' } });
    } catch (error) {
        console.log(error)
    } finally {
        emit('actualizar')
        dialog.value = false
        cargando.value = false
    }
}

</script>