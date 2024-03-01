<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }">
            <v-btn v-if="prop.type === 'text'" v-bind="props" class="bg-primary"  prepend-icon="mdi-comment-eye-outline" @click="getMotivo()">Motivo de rechazo</v-btn>

            <v-btn v-else v-bind="props" variant="flat" density="compact" icon="mdi-comment-eye-outline" @click="getMotivo()"></v-btn>

        </template>

            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Motivo de rechazo</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text class="pt-0">El servicio solicitado fue rechazado por el siguiente motivo</v-card-text>

                <v-card-text>
                    <v-textarea readonly label="Motivo" variant="solo" auto-grow
                    rows="4"
                    row-height="30" v-model="observacion">
                    </v-textarea>
                </v-card-text>

                <v-card-actions class="mt-3">
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
        
    </v-dialog>
    
</template>

<script setup>
import {ref, defineProps, onMounted} from 'vue';
import { getData, postData } from '@/plugins/api.js';
import notify from '@/plugins/notify.js';


const dialog = ref(false);
                   
const observacion = ref("")

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
    }

})

const getMotivo = async () => {
    try {
        const data = await getData(('verRechazo/' + prop.id));

        if (!data.status) {
            notify(data.message, 'warning');
            dialog.value = false;
        }else{
            observacion.value = data.data.motivo
        }

    } catch (error) {
        notify(error.message, 'error');
    }
};


</script>